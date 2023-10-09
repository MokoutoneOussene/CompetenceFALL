<?php

namespace App\Http\Controllers\Roo;

use App\Http\Controllers\Controller;
use App\Models\Emploi\PrerequisCertificat;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;

class RooPrerequisCertificatController extends Controller
{
    /**
     * Créer un prérequis de certificat.
     */
    public function creer(Request $requete): JsonResponse
    {
        try {

            // Récupérer les entrées.
            $entrees = Arr::only($requete->json()->all(), [
                'offre',
                'domaineEtude',
                'noteDomaine',
            ]);

            // Valider les entrées.
            $validateur = Validator::make($entrees, [
                'offre' => 'required|exists:emploi_offre_emplois,id',
                'domaineEtude' => 'required|exists:emploi_domaine_etudes,id',
                'noteDomaine' => 'required|int|min:1',
            ]);

            if ($validateur->fails()) {
                return parent::ReponseJsonEchecValidation(erreurs: $validateur->errors()->toArray());
            }

            // Créer un prérequis de certificat.
            $prerequis = PrerequisCertificat::create($entrees);

            // Récupérer l'instance et ses rélations.
            $prerequis = PrerequisCertificat::with(['domaineEtude'])->find($prerequis->id);

            // Récupérer l'utilisateur.
            $utilisateur = $requete->utilisateur;

            // Enregistrer l'activité.
            parent::enregistrerCreation($utilisateur, $entrees, PrerequisCertificat::class, $prerequis->id);

            return parent::ReponseJsonSuccesCreation(donnees: $prerequis->toArray());
        } catch (Exception $e) {
            return parent::ReponseJsonEchecServeur(exception: $e);
        }
    }

    /**
     * Voir un préréquis certificat.
     */
    public function voir(string $id): JsonResponse
    {
        try {

            // Rechercher l'instance à visualiser et ses rélations.
            $prerequis = PrerequisCertificat::with(['domaineEtude'])->findOrFail($id);

            return parent::ReponseJsonSuccesVisualisation(donnees: $prerequis->toArray());
        } catch (ModelNotFoundException $e) {
            return parent::ReponseJsonEchecNonTrouve();
        } catch (Exception $e) {
            return parent::ReponseJsonEchecServeur(exception: $e);
        }
    }

    /**
     * Mettre à jour un prérequis certificat.
     */
    public function mettreAJour(Request $requete, string $id): JsonResponse
    {
        try {

            // Rechercher l'instance à mettre à jour.
            $prerequis = PrerequisCertificat::findOrFail($id);

            // Récupérer les entrées.
            $entrees = Arr::only($requete->json()->all(), [
                'offre',
                'domaineEtude',
                'noteDomaine',
            ]);

            // Valider les entrées.
            $validateur = Validator::make($entrees, [
                'offre' => 'required_without_all:domaineEtude,noteDomaine|exists:emploi_offre_emplois,id',
                'domaineEtude' => 'required_without_all:offre,noteDomaine|exists:emploi_domaine_etudes,id',
                'noteDomaine' => 'required_without_all:offre,domaineEtude|int|min:1',
            ]);

            if ($validateur->fails()) {
                return parent::ReponseJsonEchecValidation(erreurs: $validateur->errors()->toArray());
            }

            // Mettre à jour l'instance.
            $prerequis->update($entrees);

            // Récupérer l'instance et ses rélations.
            $prerequis = PrerequisCertificat::with(['domaineEtude'])->find($id);

            // Récupérer l'utilisateur.
            $utilisateur = $requete->utilisateur;

            // Enregistrer l'activité.
            parent::enregistrerMiseAJour($utilisateur, $entrees, PrerequisCertificat::class, $id);

            return parent::ReponseJsonSuccesMiseAJour(donnees: $prerequis->toArray());
        } catch (ModelNotFoundException $e) {
            return parent::ReponseJsonEchecNonTrouve();
        } catch (Exception $e) {
            return parent::ReponseJsonEchecServeur(exception: $e);
        }
    }

    /**
     * Supprimer un prérequis certificat.
     */
    public function supprimer(Request $requete, string $id): JsonResponse
    {
        try {

            // Rechercher l'instance à supprimer.
            $prerequis = PrerequisCertificat::findOrFail($id);

            // Supprimer l'instance.
            $prerequis->delete();

            // Récupérer l'utilisateur.
            $utilisateur = $requete->utilisateur;

            // Enregistrer l'activité.
            parent::enregistrerSuppression($utilisateur, PrerequisCertificat::class, $id);

            return parent::ReponseJsonSuccesSuppression();
        } catch (ModelNotFoundException $e) {
            return parent::ReponseJsonEchecNonTrouve();
        } catch (Exception $e) {
            return parent::ReponseJsonEchecServeur(exception: $e);
        }
    }
}
