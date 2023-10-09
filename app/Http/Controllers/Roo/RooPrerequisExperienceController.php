<?php

namespace App\Http\Controllers\Roo;

use App\Http\Controllers\Controller;
use App\Models\Emploi\PrerequisExperience;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;

class RooPrerequisExperienceController extends Controller
{
    /**
     * Créer un prérequis experience.
     */
    public function creer(Request $requete): JsonResponse
    {
        try {

            // Récupérer les entrées.
            $entrees = Arr::only($requete->json()->all(), [
                'offre',
                'domaineEtude',
                'noteDomaine',
                'duree',
            ]);

            // Valider les entrées.
            $validateur = Validator::make($entrees, [
                'offre' => 'required|exists:emploi_offre_emplois,id',
                'domaineEtude' => 'required|exists:emploi_domaine_etudes,id',
                'noteDomaine' => 'nullable|int|min:0',
                'duree' => 'nullable|int|min:1',
            ]);

            if ($validateur->fails()) {
                return parent::ReponseJsonEchecValidation(erreurs: $validateur->errors()->toArray());
            }

            // Créer un prérequis de experience.
            $prerequis = PrerequisExperience::create($entrees);

            // Récupérer l'instance et ses rélations.
            $prerequis = PrerequisExperience::with(['domaineEtude'])->find($prerequis->id);

            // Récupérer l'utilisateur.
            $utilisateur = $requete->utilisateur;

            // Enregistrer l'activité.
            parent::enregistrerCreation($utilisateur, $entrees, PrerequisExperience::class, $prerequis->id);

            return parent::ReponseJsonSuccesCreation(donnees: $prerequis->toArray());
        } catch (Exception $e) {
            return parent::ReponseJsonEchecServeur(exception: $e);
        }
    }

    /**
     * Voir un préréquis experience.
     */
    public function voir(string $id): JsonResponse
    {
        try {

            // Rechercher l'instance à visualiser et ses rélations.
            $prerequis = PrerequisExperience::with(['domaineEtude'])->findOrFail($id);

            return parent::ReponseJsonSuccesVisualisation(donnees: $prerequis->toArray());
        } catch (ModelNotFoundException $e) {
            return parent::ReponseJsonEchecNonTrouve();
        } catch (Exception $e) {
            return parent::ReponseJsonEchecServeur(exception: $e);
        }
    }

    /**
     * Mettre à jour un prérequis experience.
     */
    public function mettreAJour(Request $requete, string $id): JsonResponse
    {
        try {
            // Rechercher l'instance à visualiser et ses rélations.
            $prerequis = PrerequisExperience::findOrFail($id);

            // Récupérer les entrées.
            $entrees = Arr::only($requete->json()->all(), [
                'offre',
                'domaineEtude',
                'noteDomaine',
                'duree',
            ]);

            // Valider les entrées.
            $validateur = Validator::make($entrees, [
                'offre' => 'required_without_all:offre,domaineEtude,noteDomaine,duree|exists:emploi_offre_emplois,id',
                'domaineEtude' => 'required_without_all:offre,domaineEtude,noteDomaine,duree|exists:emploi_domaine_etudes,id',
                'noteDomaine' => 'required_without_all:offre,domaineEtude,noteDomaine,duree|int|min:0',
                'duree' => 'required_without_all:offre,domaineEtude,noteDomaine,duree|int|min:1',
            ]);

            if ($validateur->fails()) {
                return parent::ReponseJsonEchecValidation(erreurs: $validateur->errors()->toArray());
            }

            // Mettre à jour l'instance.
            $prerequis->update($entrees);

            // Récupérer l'instance et ses rélations.
            $prerequis = PrerequisExperience::with(['domaineEtude'])->find($id);

            // Récupérer l'utilisateur.
            $utilisateur = $requete->utilisateur;

            // Enregistrer l'activité.
            parent::enregistrerMiseAJour($utilisateur, $entrees, PrerequisExperience::class, $id);

            return parent::ReponseJsonSuccesMiseAJour(donnees: $prerequis->toArray());
        } catch (ModelNotFoundException $e) {
            return parent::ReponseJsonEchecNonTrouve();
        } catch (Exception $e) {
            return parent::ReponseJsonEchecServeur(exception: $e);
        }
    }

    /**
     * Supprimer un prérequis experience.
     */
    public function supprimer(Request $requete, string $id): JsonResponse
    {
        try {

            // Rechercher l'instance à supprimer.
            $prerequis = PrerequisExperience::findOrFail($id);

            // Supprimer l'instance.
            $prerequis->delete();

            // Récupérer l'utilisateur.
            $utilisateur = $requete->utilisateur;

            // Enregistrer l'activité.
            parent::enregistrerSuppression($utilisateur, PrerequisExperience::class, $id);

            return parent::ReponseJsonSuccesSuppression();
        } catch (ModelNotFoundException $e) {
            return parent::ReponseJsonEchecNonTrouve();
        } catch (Exception $e) {
            return parent::ReponseJsonEchecServeur(exception: $e);
        }
    }
}
