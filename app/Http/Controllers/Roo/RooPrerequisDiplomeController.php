<?php

namespace App\Http\Controllers\Roo;

use App\Http\Controllers\Controller;
use App\Models\Emploi\PrerequisDiplome;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;

class RooPrerequisDiplomeController extends Controller
{
    /**
     * Créer un prérequis de diplôme.
     */
    public function creer(Request $requete): JsonResponse
    {
        try {

            // Récupérer les entrées.
            $entrees = Arr::only($requete->json()->all(), [
                'offre',
                'domaineEtude',
                'noteDomaine',
                'niveauEtude',
                'niveauSpecialisation',
            ]);

            // Valider les entrées.
            $validateur = Validator::make($entrees, [
                'offre' => 'required|exists:emploi_offre_emplois,id',
                'domaineEtude' => 'required_without_all:niveauEtude,niveauSpecialisation|exists:emploi_domaine_etudes,id',
                'noteDomaine' => 'required_with:domaineEtude|int|min:1',
                'niveauEtude' => 'required_without_all:domaineEtude,niveauSpecialisation|exists:emploi_niveau_etudes,id',
                'niveauSpecialisation' => 'required_without_all:domaineEtude,niveauEtude|exists:emploi_niveau_specialisations,id',
            ]);

            if ($validateur->fails()) {
                return parent::ReponseJsonEchecValidation(erreurs: $validateur->errors()->toArray());
            }

            // Créer un prérequis de diplôme.
            $prerequis = PrerequisDiplome::create($entrees);

            $prerequis = PrerequisDiplome::with([
                'domaineEtude',
                'niveauEtude',
                'niveauSpecialisation',
            ])->find($prerequis->id);

            // Récupérer l'utilisateur.
            $utilisateur = $requete->utilisateur;

            // Enregistrer l'activité.
            parent::enregistrerCreation($utilisateur, $entrees, PrerequisDiplome::class, $prerequis->id);

            return parent::ReponseJsonSuccesCreation(donnees: $prerequis->toArray());
        } catch (Exception $e) {
            return parent::ReponseJsonEchecServeur(exception: $e);
        }
    }

    /**
     * Voir un préréquis diplôme.
     */
    public function voir(string $id): JsonResponse
    {
        try {

            // Rechercher l'instance à visualiser et ses rélations.
            $prerequis = PrerequisDiplome::with([
                'domaineEtude',
                'niveauEtude',
                'niveauSpecialisation',
            ])->findOrFail($id);

            return parent::ReponseJsonSuccesVisualisation(donnees: $prerequis->toArray());
        } catch (ModelNotFoundException $e) {
            return parent::ReponseJsonEchecNonTrouve();
        } catch (Exception $e) {
            return parent::ReponseJsonEchecServeur(exception: $e);
        }
    }

    /**
     * Mettre à jour un prérequis diplôme.
     */
    public function mettreAJour(Request $requete, string $id): JsonResponse
    {
        try {

            // Rechercher l'instance à mettre à jour.
            $prerequis = PrerequisDiplome::findOrFail($id);

            // Récupérer les entrées.
            $entrees = Arr::only($requete->json()->all(), [
                'offre',
                'domaineEtude',
                'noteDomaine',
                'niveauEtude',
                'niveauSpecialisation',
            ]);

            // Valider les entrées.
            $validateur = Validator::make($entrees, [
                'offre' => 'required_without_all:offre,noteDomaine,domaineEtude,niveauEtude,niveauSpecialisation|exists:emploi_offre_emplois,id',
                'domaineEtude' => 'required_without_all:offre,noteDomaine,domaineEtude,niveauEtude,niveauSpecialisation|exists:emploi_domaine_etudes,id',
                'noteDomaine' => 'required_without_all:offre,noteDomaine,domaineEtude,niveauEtude,niveauSpecialisation|int|min:1',
                'niveauEtude' => 'required_without_all:offre,noteDomaine,domaineEtude,niveauEtude,niveauSpecialisation|exists:emploi_niveau_etudes,id',
                'niveauSpecialisation' => 'required_without_all:offre,noteDomaine,domaineEtude,niveauEtude,niveauSpecialisation|exists:emploi_niveau_specialisations,id',
            ]);

            if ($validateur->fails()) {
                return parent::ReponseJsonEchecValidation(erreurs: $validateur->errors()->toArray());
            }

            // Mettre à jour l'instance.
            $prerequis->update($entrees);

            // Récupérer l'instance et ses rélations.
            $prerequis = PrerequisDiplome::with([
                'domaineEtude',
                'niveauEtude',
                'niveauSpecialisation',
            ])->find($id);

            // Récupérer l'utilisateur.
            $utilisateur = $requete->utilisateur;

            // Enregistrer l'activité.
            parent::enregistrerMiseAJour($utilisateur, $entrees, PrerequisDiplome::class, $id);

            return parent::ReponseJsonSuccesMiseAJour(donnees: $prerequis->toArray());
        } catch (ModelNotFoundException $e) {
            return parent::ReponseJsonEchecNonTrouve();
        } catch (Exception $e) {
            return parent::ReponseJsonEchecServeur(exception: $e);
        }
    }

    /**
     * Supprimer un prérequis de diplôme.
     */
    public function supprimer(Request $requete, string $id): JsonResponse
    {
        try {

            // Rechercher l'instance à supprimer.
            $prerequis = PrerequisDiplome::findOrFail($id);

            // Supprimer l'instance.
            $prerequis->delete();

            // Récupérer l'utilisateur.
            $utilisateur = $requete->utilisateur;

            // Enregistrer l'activité.
            parent::enregistrerSuppression($utilisateur, PrerequisDiplome::class, $id);

            return parent::ReponseJsonSuccesSuppression();
        } catch (ModelNotFoundException $e) {
            return parent::ReponseJsonEchecNonTrouve();
        } catch (Exception $e) {
            return parent::ReponseJsonEchecServeur(exception: $e);
        }
    }
}
