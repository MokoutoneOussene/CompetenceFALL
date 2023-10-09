<?php

namespace App\Http\Controllers\Can;

use App\Http\Controllers\Controller;
use App\Models\Emploi\CandidatCentre;
use App\Models\Emploi\Candidature;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\UnauthorizedException;

class CanCandidatureCvController extends Controller
{
    /**
     * Ajouter un cvlienCv à sa candidature.
     */
    public function lier(Request $requete): JsonResponse
    {
        try {

            // Récupérer les entrées.
            $entrees = Arr::only($requete->json()->all(), [
                'candidature',
                'cv',
            ]);

            // Valider les entrées.
            $validateur = Validator::make($entrees, [
                'candidature' => 'required|exists:emploi_candidatures,id',
                'cv' => 'require|exists:emploi_candidat_cvs,id',
            ]);

            // Retourner un message d'échec des validations.
            if ($validateur->fails()) {
                return parent::ReponseJsonEchecValidation(erreurs: $validateur->errors()->toArray());
            }

            // Récupérer l'utilisateur.
            $utilisateur = $requete->utilisateur;

            // Récupérer la candidature.
            $candidature = Candidature::find($entrees['candidature']);

            // Vérifier les autorisations.
            $porte = Gate::forUser($utilisateur);

            if ($porte->denies('proprietaire-modele', $candidature)) {
                throw new UnauthorizedException();
            }

            // Récupérer le cvlienCv.
            $cv = CandidatCentre::find($entrees['cv']);

            if ($porte->denies('proprietaire-modele', $cv)) {
                throw new UnauthorizedException();
            }

            // Ajouter l'utilisateur comme auteurMiseAJour.
            $entrees = [
                'cv' => $entrees['cv'],
                'auteurMiseAJour' => $utilisateur->id,
            ];

            // Mettre à jour la candidature.
            $candidature->update($entrees);

            // Raffraichir le modèle.
            $candidature->refresh();

            // Retourner une reponse de succès.
            return parent::ReponseJsonSuccesCreation(donnees: $candidature->toArray());
        } catch (UnauthorizedException $e) {
            return parent::ReponseJsonEchecAutorisation();
        } catch (Exception $e) {
            return parent::ReponseJsonEchecServeur(exception: $e);
        }
    }
}
