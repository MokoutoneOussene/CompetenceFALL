<?php

namespace App\Http\Controllers\Can;

use App\Http\Controllers\Controller;
use App\Models\Emploi\CandidatCompetence;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\UnauthorizedException;

class CanCompetenceController extends Controller
{
    /**
     * Créer uncompétence.
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
                'description' => 'nullable|string|max:255',
            ]);

            if ($validateur->fails()) {
                return parent::ReponseJsonEchecValidation(erreurs: $validateur->errors()->toArray());
            }

            // Ajouter l'utilisateur comme propriétaire.
            $entrees['utilisateur'] = $requete->utilisateur->id;

            // Créer une compétence.
            $competence = CandidatCompetence::create($entrees);

            // Raffraichir le modèle.
            $competence->refresh();

            // Retourner une reponse de succès.
            return parent::ReponseJsonSuccesCreation(donnees: $competence->toArray());
        } catch (Exception $e) {
            return parent::ReponseJsonEchecServeur(exception: $e);
        }
    }

    /**
     * Lister ses compétences.
     *
     *
     * @return JsonResponse $reponse
     */
    public function lister(Request $requete): JsonResponse
    {

        try {

            // Récupérer l'utlisateur.
            $utilisateur = $requete->utilisateur;

            $competences = CandidatCompetence::where('utilisateur', $utilisateur->id)->orderBy('intitule')->get();

            if ($competences->isEmpty()) {
                return parent::ReponseJsonEchecRessource();
            }

            return parent::ReponseJsonSucces(donnees: $competences->toArray());
        } catch (Exception $e) {
            return parent::ReponseJsonEchecServeur(exception: $e);
        }
    }

    /**
     * Supprimer un compétence.
     */
    public function supprimer(Request $requete, string $id): JsonResponse
    {
        try {
            // Rechercher l'instance.
            $competence = CandidatCompetence::findOrFail($id);

            // Récupérer l'utilisateur.
            $utilisateur = $requete->utilisateur;

            // Vérifier les autorisations.
            $porte = Gate::forUser($utilisateur);

            if ($porte->denies('proprietaire-modele', $competence)) {
                throw new UnauthorizedException();
            }

            $competence->delete();

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
