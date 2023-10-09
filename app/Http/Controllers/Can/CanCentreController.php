<?php

namespace App\Http\Controllers\Can;

use App\Http\Controllers\Controller;
use App\Models\Emploi\CandidatCentre;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\UnauthorizedException;

class CanCentreController extends Controller
{
    /**
     * Créer un centre d'intérets.
     */
    public function creer(Request $requete): JsonResponse
    {
        try {

            // Récupérer les entrées.
            $entrees = Arr::only($requete->json()->all(), [
                'intitule',
                'description',
            ]);

            // Valider les entrées.
            $validateur = Validator::make($entrees, [
                'intitule' => 'required|string|max:64',
                'description' => 'string|max:255',
            ]);

            // Retourner un message d'échec des validations.
            if ($validateur->fails()) {
                return parent::ReponseJsonEchecValidation(erreurs: $validateur->errors()->toArray());
            }

            // Ajouter l'utilisateur comme propriétaire.
            $entrees['utilisateur'] = $requete->utilisateur->id;

            // Créer une centre d'intérets.
            $centre = CandidatCentre::create($entrees);

            // Raffraichir le modèle.
            $centre->refresh();

            // Retourner une reponse de succès.
            return parent::ReponseJsonSuccesCreation(donnees: $centre->toArray());
        } catch (Exception $e) {
            return parent::ReponseJsonEchecServeur(exception: $e);
        }
    }

    /**
     * Lister ses centres d'intérets.
     *
     *
     * @return JsonResponse $reponse
     */
    public function lister(Request $requete): JsonResponse
    {

        try {

            // Récupérer l'utlisateur.
            $utilisateur = $requete->utilisateur;

            // Récupérer ses centres d'intérêts.
            $centres = CandidatCentre::where('utilisateur', $utilisateur->id)->orderBy('intitule')->get([
                'id', 'intitule', 'description',
            ]);

            // Vérifier l'effectif.
            if ($centres->isEmpty()) {
                return parent::ReponseJsonEchecRessource();
            }

            return parent::ReponseJsonSucces(donnees: $centres->toArray());
        } catch (Exception $e) {
            return parent::ReponseJsonEchecServeur(exception: $e);
        }
    }

    /**
     * Supprimer un centre d'intérêts.
     */
    public function supprimer(Request $requete, string $id): JsonResponse
    {
        try {

            // Récupérer l'instance à supprimer.
            $centre = CandidatCentre::findOrFail($id);

            // Récupérer l'utilisateur.
            $utilisateur = $requete->utilisateur;

            // Initialiser une porte de vérification.
            $porte = Gate::forUser($utilisateur);

            if ($porte->denies('proprietaire-modele', $centre)) {
                throw new UnauthorizedException();
            }

            // Supprimer le centre d'intérets.
            $centre->delete();

            return parent::ReponseJsonSuccesSuppression();
        } catch (ModelNotFoundException $e) {
            return parent::ReponseJsonEchecNonTrouve();
        } catch (UnauthorizedException $e) {
            return parent::ReponseJsonEchecAutorisation();
        } catch (Exception $e) {
            return parent::ReponseJsonEchecServeur(exception: $e);
        }
    }
}
