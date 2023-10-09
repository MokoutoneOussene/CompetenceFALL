<?php

namespace App\Http\Controllers\Can;

use App\Http\Controllers\Controller;
use App\Models\Emploi\CandidatLangue;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\UnauthorizedException;

class CanLangueController extends Controller
{
    /**
     * Créer une langue.
     */
    public function creer(Request $requete): JsonResponse
    {
        try {

            // Récupérer les entrées.
            $entrees = Arr::only($requete->json()->all(), [
                'intitule',
                'niveau',
                'statutParle',
                'statutLu',
                'statutEcrit',
            ]);

            // Valider les entrées.
            $validateur = Validator::make($entrees, [
                'intitule' => 'required|string|max:64',
                'niveau' => 'nullable|in:a1,a2,b1,b2,c1,c2',
                'statutParle' => 'nullable|boolean',
                'statutLu' => 'nullable|boolean',
                'statutEcrit' => 'nullable|boolean',
            ]);

            // Retourner un message d'échec des validations.
            if ($validateur->fails()) {
                return parent::ReponseJsonEchecValidation(erreurs: $validateur->errors()->toArray());
            }

            // Ajouter l'utilisateur comme propriétaire.
            $entrees['utilisateur'] = $requete->utilisateur->id;

            // Créer une langue.
            $langue = CandidatLangue::create($entrees);

            // Raffraichir le modèle.
            $langue->refresh();

            // Retourner une reponse de succès.
            return parent::ReponseJsonSuccesCreation(donnees: $langue->toArray());
        } catch (Exception $e) {
            return parent::ReponseJsonEchecServeur(exception: $e);
        }
    }

    /**
     * Lister ses langues.
     *
     *
     * @return JsonResponse $reponse
     */
    public function lister(Request $requete): JsonResponse
    {

        try {

            // Récupérer l'utlisateur.
            $utilisateur = $requete->utilisateur;

            $langues = CandidatLangue::where('utilisateur', $utilisateur->id)->orderBy('intitule')->get();

            if ($langues->isEmpty()) {
                return parent::ReponseJsonEchecRessource();
            }

            return parent::ReponseJsonSucces(donnees: $langues->toArray());
        } catch (Exception $e) {
            return parent::ReponseJsonEchecServeur(exception: $e);
        }
    }

    /**
     * Supprimer une langue.
     */
    public function supprimer(Request $requete, string $id): JsonResponse
    {
        try {

            $langue = CandidatLangue::findOrFail($id);

            // Récupérer l'utilisateur.
            $utilisateur = $requete->utilisateur;

            // Vérifier les autorisations.
            $porte = Gate::forUser($utilisateur);

            if ($porte->denies('proprietaire-modele', $langue)) {
                throw new UnauthorizedException();
            }

            $langue->delete();

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
