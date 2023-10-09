<?php

namespace App\Http\Controllers\Roo;

use App\Http\Controllers\Controller;
use App\Models\Emploi\QuestionOffre;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;

class RooQuestionOffreController extends Controller
{
    /**
     * Créer une question d'offre d'emploi.
     */
    public function creer(Request $requete): JsonResponse
    {
        try {

            // Récupérer les entrées.
            $entrees = Arr::only($requete->json()->all(), [
                'offre',
                'ordre',
                'contenu',
                'typeQuestion',
                'note',
                'bonneReponse',
            ]);

            // Valider les entrées.
            $validateur = Validator::make($entrees, [
                'offre' => 'required|exists:emploi_offre_emplois,id',
                'ordre' => 'required|int|min:1',
                'contenu' => 'required|string|max:255',
                'typeQuestion' => 'required|in:vraiFaux,reponseCourte',
                'note' => 'required_if:typeQuestion,vraiFaux|int|min:1',
                'bonneReponse' => 'required_if:typeQuestion,vraiFaux|boolean',
            ]);

            if ($validateur->fails()) {
                return parent::ReponseJsonEchecValidation(erreurs: $validateur->errors()->toArray());
            }

            // Créer une question d'offre d'emploi.
            $questionOffre = QuestionOffre::create($entrees);

            // Raffraichir l'instance.
            $questionOffre->refresh();

            // Récupérer l'utilisateur.
            $utilisateur = $requete->utilisateur;

            return parent::ReponseJsonSuccesCreation(donnees: $questionOffre->toArray());

        } catch (Exception $e) {
            return parent::ReponseJsonEchecServeur(exception: $e);
        }
    }

    /**
     * Voir une question d'offre d'emploi.
     */
    public function voir(string $id): JsonResponse
    {
        try {

            // Rechercher l'instance à visualiser.
            $questionOffre = QuestionOffre::findOrFail($id);

            return parent::ReponseJsonSuccesVisualisation(donnees: $questionOffre->toArray());
        } catch (ModelNotFoundException $e) {
            return parent::ReponseJsonEchecNonTrouve();
        } catch (Exception $e) {
            return parent::ReponseJsonEchecServeur(exception: $e);
        }
    }

    /**
     * Mettre à jour les détails d'une question d'offre d'emploi.
     */
    public function mettreAJour(Request $requete, string $id): JsonResponse
    {
        try {

            // Rechercher l'instance à mettre à jour.
            $questionOffre = QuestionOffre::findOrFail($id);

            // Récupérer les entrées.
            $entrees = Arr::only($requete->json()->all(), [
                'offre',
                'ordre',
                'contenu',
                'typeQuestion',
                'note',
                'bonneReponse',
            ]);

            // Valider les entrées.
            $validateur = Validator::make($entrees, [
                'offre' => 'required_without_all:offre,ordre,contenu,typeQuestion,note,bonneReponse|exists:emploi_offre_emplois,id',
                'ordre' => 'required_without_all:offre,ordre,contenu,typeQuestion,note,bonneReponse|int|min:1',
                'contenu' => 'required_without_all:offre,ordre,contenu,typeQuestion,note,bonneReponse|string|max:255',
                'typeQuestion' => 'required_without_all:offre,ordre,contenu,typeQuestion,note,bonneReponse|in:vraiFaux,reponseCourte',
                'note' => 'required_without_all:offre,ordre,contenu,typeQuestion,note,bonneReponse|int|min:1',
                'bonneReponse' => 'required_without_all:offre,ordre,contenu,typeQuestion,note,bonneReponse|boolean',
            ]);

            if ($validateur->fails()) {
                return parent::ReponseJsonEchecValidation(erreurs: $validateur->errors()->toArray());
            }

            // Mettre à jour l'instance.
            $questionOffre->update($entrees);

            // Raffraichir l'instance.
            $questionOffre->refresh();

            // Récupérer l'utilisateur.
            $utilisateur = $requete->utilisateur;

            return parent::ReponseJsonSuccesMiseAJour(donnees: $questionOffre->toArray());

        } catch (ModelNotFoundException $e) {
            return parent::ReponseJsonEchecNonTrouve();
        } catch (Exception $e) {
            return parent::ReponseJsonEchecServeur(exception: $e);
        }
    }

    /**
     * Supprimer une question d'offre d'emploi.
     */
    public function supprimer(Request $requete, string $id): JsonResponse
    {

        try {

            // Rechercher l'instance à supprimer.
            $questionOffre = QuestionOffre::findOrFail($id);

            // Supprimer l'instance.
            $questionOffre->delete();

            // Récupérer l'utilisateur.
            $utilisateur = $requete->utilisateur;

            return parent::ReponseJsonSuccesSuppression();
        } catch (ModelNotFoundException $e) {
            return parent::ReponseJsonEchecNonTrouve();
        } catch (Exception $e) {
            return parent::ReponseJsonEchecServeur(exception: $e);
        }
    }
}
