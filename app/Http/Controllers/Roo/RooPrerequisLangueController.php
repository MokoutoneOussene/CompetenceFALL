<?php

namespace App\Http\Controllers\Roo;

use App\Http\Controllers\Controller;
use App\Models\Emploi\PrerequisLangue;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;

class RooPrerequisLangueController extends Controller
{
    /**
     * Créer un prérequis langue.
     *
     * @param  Request  $$requete
     */
    public function creer(Request $requete): JsonResponse
    {
        try {

            // Récupérer les entrées.
            $entrees = Arr::only($requete->json()->all(), [
                'offre',
                'intitule',
                'noteLangue',
                'niveau',
                'noteNiveau',
                'statutParle',
                'noteStatutParle',
                'statutLu',
                'noteStatutLu',
                'statutEcrit',
                'noteStatutEcrit',
            ]);

            // Valider les entrées.
            $validateur = Validator::make($entrees, [
                'offre' => 'required|exists:emploi_offre_emplois,id',
                'intitule' => 'required|string|max:64',
                'noteLangue' => 'nullable|int|min:0',
                'niveau' => 'nullable|in:a1,a2,b1,b2,c1,c2',
                'noteNiveau' => 'required_with:niveau|prohibited_if:niveau,null|int|min:0',
                'statutParle' => 'nullable|boolean',
                'noteStatutParle' => 'required_with:statutParle|prohibited_if:statutParle,null|int|min:0',
                'statutLu' => 'nullable|boolean',
                'noteStatutLu' => 'required_with:statutLu|prohibited_if:statutLu,null|int|min:0',
                'statutEcrit' => 'nullable|boolean',
                'noteStatutEcrit' => 'required_with:statutEcrit|prohibited_if:statutEcrit,null|int|min:0',
            ]);

            if ($validateur->fails()) {
                return parent::ReponseJsonEchecValidation(erreurs: $validateur->errors()->toArray());
            }

            // Créer un prérequis de langue.
            $prerequis = PrerequisLangue::create($entrees);

            // Raffraichir l'instance.
            $prerequis->refresh();

            // Récupérer l'utilisateur.
            $utilisateur = $requete->utilisateur;

            // Enregistrer l'activité.
            parent::enregistrerCreation($utilisateur, $entrees, PrerequisLangue::class, $prerequis->id);

            return parent::ReponseJsonSuccesCreation(donnees: $prerequis->toArray());
        } catch (Exception $e) {
            return parent::ReponseJsonEchecServeur(exception: $e);
        }
    }

    /**
     * Voir un préréquis langue.
     */
    public function voir(string $id): JsonResponse
    {
        try {

            // Rechercher l'instance à visualiser.
            $prerequis = PrerequisLangue::findOrFail($id);

            return parent::ReponseJsonSuccesVisualisation(donnees: $prerequis->toArray());
        } catch (ModelNotFoundException $e) {
            return parent::ReponseJsonEchecNonTrouve();
        } catch (Exception $e) {
            return parent::ReponseJsonEchecServeur(exception: $e);
        }
    }

    /**
     * Mettre à jour un prérequis langue.
     *
     * @param  Request  $$requete
     */
    public function mettreAJour(Request $requete, string $id): JsonResponse
    {
        try {

            // Rechercher l'instance à mettre à jour.
            $prerequis = PrerequisLangue::findOrFail($id);

            // Récupérer les entrées.
            $entrees = Arr::only($$requete->json()->all(), [
                'offre',
                'intitule',
                'noteLangue',
                'niveau',
                'noteNiveau',
                'statutParle',
                'noteStatutParle',
                'statutLu',
                'noteStatutLu',
                'statutEcrit',
                'noteStatutEcrit',
            ]);

            // Valider les entrées.
            $validateur = Validator::make($entrees, [
                'offre' => 'required_without_all:noteLangue,niveau,offre,intitule,noteNiveau,statutParle,noteStatutParle,statutLu,noteStatutLu,statutEcrit,noteStatutEcrit|exists:emploi_offre_emplois,id',
                'intitule' => 'required_without_all:noteLangue,niveau,offre,intitule,noteNiveau,statutParle,noteStatutParle,statutLu,noteStatutLu,statutEcrit,noteStatutEcrit|string|max:64',
                'noteLangue' => 'required_without_all:noteLangue,niveau,offre,intitule,noteNiveau,statutParle,noteStatutParle,statutLu,noteStatutLu,statutEcrit,noteStatutEcrit|int|min:0',
                'niveau' => 'required_without_all:noteLangue,niveau,offre,intitule,noteNiveau,statutParle,noteStatutParle,statutLu,noteStatutLu,statutEcrit,noteStatutEcrit|in:a1,a2,b1,b2,c1,c2',
                'noteNiveau' => 'required_without_all:noteLangue,niveau,offre,intitule,noteNiveau,statutParle,noteStatutParle,statutLu,noteStatutLu,statutEcrit,noteStatutEcrit|int|min:0',
                'statutParle' => 'required_without_all:noteLangue,niveau,offre,intitule,noteNiveau,statutParle,noteStatutParle,statutLu,noteStatutLu,statutEcrit,noteStatutEcrit|boolean',
                'noteStatutParle' => 'required_without_all:noteLangue,niveau,offre,intitule,noteNiveau,statutParle,noteStatutParle,statutLu,noteStatutLu,statutEcrit,noteStatutEcrit:statutParle|prohibited_if:statutParle,null|int|min:0',
                'statutLu' => 'required_without_all:noteLangue,niveau,offre,intitule,noteNiveau,statutParle,noteStatutParle,statutLu,noteStatutLu,statutEcrit,noteStatutEcrit|boolean',
                'noteStatutLu' => 'required_without_all:noteLangue,niveau,offre,intitule,noteNiveau,statutParle,noteStatutParle,statutLu,noteStatutLu,statutEcrit,noteStatutEcrit:statutLu|prohibited_if:statutLu,null|int|min:0',
                'statutEcrit' => 'required_without_all:noteLangue,niveau,offre,intitule,noteNiveau,statutParle,noteStatutParle,statutLu,noteStatutLu,statutEcrit,noteStatutEcrit|boolean',
                'noteStatutEcrit' => 'required_without_all:noteLangue,niveau,offre,intitule,noteNiveau,statutParle,noteStatutParle,statutLu,noteStatutLu,statutEcrit,noteStatutEcrit:statutEcrit|prohibited_if:statutEcrit,null|int|min:0',
            ]);

            if ($validateur->fails()) {
                return parent::ReponseJsonEchecValidation(erreurs: $validateur->errors()->toArray());
            }

            // Mettre à jour l'instance.
            $prerequis->update($entrees);

            // Raffraichir l'instance.
            $prerequis->refresh();

            // Récupérer l'utilisateur.
            $utilisateur = $requete->utilisateur;

            // Enregistrer l'activité.
            parent::enregistrerMiseAJour($utilisateur, $entrees, PrerequisLangue::class, $id);

            return parent::ReponseJsonSuccesMiseAJour(donnees: $prerequis->toArray());
        } catch (ModelNotFoundException $e) {
            return parent::ReponseJsonEchecNonTrouve();
        } catch (Exception $e) {
            return parent::ReponseJsonEchecServeur(exception: $e);
        }
    }

    /**
     * Supprimer un prérequis langue.
     */
    public function supprimer(Request $requete, string $id): JsonResponse
    {
        try {

            // Rechercher l'instance à supprimer.
            $prerequis = PrerequisLangue::findOrFail($id);

            // Supprimer l'instance.
            $prerequis->delete();

            // Récupérer l'utilisateur.
            $utilisateur = $requete->utilisateur;

            // Enregistrer l'activité.
            parent::enregistrerSuppression($utilisateur, PrerequisLangue::class, $id);

            return parent::ReponseJsonSuccesSuppression();
        } catch (ModelNotFoundException $e) {
            return parent::ReponseJsonEchecNonTrouve();
        } catch (Exception $e) {
            return parent::ReponseJsonEchecServeur(exception: $e);
        }
    }
}
