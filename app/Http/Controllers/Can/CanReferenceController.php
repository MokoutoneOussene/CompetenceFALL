<?php

namespace App\Http\Controllers\Can;

use App\Http\Controllers\Controller;
use App\Models\Emploi\CandidatReference;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\UnauthorizedException;

class CanReferenceController extends Controller
{
    /**
     * Créer une personne de référence.
     */
    public function creer(Request $requete): JsonResponse
    {
        try {

            $entrees = Arr::only($requete->json()->all(), [
                'nom',
                'prenoms',
                'poste',
                'organisation',
                'email',
                'indicatifTelephonique',
                'telephone',
                'relation',
                'dateDebut',
                'dateFin',
            ]);

            // Valider les entrées.
            $validateur = Validator::make($entrees, [
                'nom' => 'required|string|max:64',
                'prenoms' => 'required|string|max:64',
                'poste' => 'required|string|max:64',
                'organisation' => 'required|string|max:64',
                'email' => 'nullable|email|max:255',
                'indicatifTelephonique' => 'required_with:telephone|prohibited_if:telephone,null|int|min:1|max:196',
                'telephone' => "required_without_all:email|regex:/^\d+$/|min:8|max:12",
                'relation' => 'required|string|max:64',
                'dateDebut' => 'required|date_format:Y-m-d H:i:s',
                'dateFin' => 'nullable|date_format:Y-m-d H:i:s|after:dateDebut',
            ]);

            if ($validateur->fails()) {
                return parent::ReponseJsonEchecValidation(erreurs: $validateur->errors()->toArray());
            }

            // Ajouter l'utilisateur comme propriétaire.
            $entrees['utilisateur'] = $requete->utilisateur->id;

            // Créer une nouvelle candidature.
            $reference = CandidatReference::create($entrees);

            // Retourner une reponse de succès.
            return parent::ReponseJsonSuccesCreation(donnees: $reference->toArray());
        } catch (Exception $e) {
            return parent::ReponseJsonEchecServeur(exception: $e);
        }
    }

    /**
     * Lister ses personnes de référence.
     *
     *
     * @return JsonResponse $reponse
     */
    public function lister(Request $requete): JsonResponse
    {

        try {

            // Récupérer l'utlisateur.
            $utilisateur = $requete->utilisateur;

            $references = CandidatReference::where('utilisateur', $utilisateur->id)->orderBy('dateDebut', 'desc')->get();

            if ($references->isEmpty()) {
                return parent::ReponseJsonEchecRessource();
            }

            return parent::ReponseJsonSucces(donnees: $references->toArray());
        } catch (Exception $e) {
            return parent::ReponseJsonEchecServeur(exception: $e);
        }
    }

    /**
     * Supprimer une personne de référence.
     */
    public function supprimer(Request $requete, string $id): JsonResponse
    {
        try {

            $reference = CandidatReference::findOrFail($id);

            // Récupérer l'utilisateur.
            $utilisateur = $requete->utilisateur;

            // Vérifier les autorisations.
            $porte = Gate::forUser($utilisateur);

            if ($porte->denies('proprietaire-modele', $reference)) {
                throw new UnauthorizedException();
            }

            $reference->delete();

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
