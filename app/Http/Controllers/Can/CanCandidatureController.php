<?php

namespace App\Http\Controllers\Can;

use App\Http\Controllers\Controller;
use App\Models\Emploi\Candidature;
use App\Rules\Emploi\Candidature\CandidatureMiseAJourRule;
use App\Rules\Emploi\Candidature\CandidatureUniqueRule;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\UnauthorizedException;

class CanCandidatureController extends Controller
{
    /**
     * Créer une candidature.
	 *
	 * @param Request $requete
	 *
	 * @return JsonResponse $reponse
     */
    public function creer(Request $requete): JsonResponse
    {
        try {

            // Récupérer les entrées.
            $entrees = Arr::only($requete->json()->all(), [
                'offre',
                'intitule',
                'lettreMotivation',
                'statutSoumission'
            ]);

            // Ajouter l'utilisateur comme auteurCreation.
            $entrees['utilisateur'] = $requete->utilisateur->id;

            // Valider les entrées.
            $validateur = Validator::make($entrees, [
                'offre' => ['required', 'exists:emploi_offre_emplois,id', new CandidatureUniqueRule],
                'intitule' => 'required|string|max:64',
                'lettreMotivation' => 'nullable|string|max:255',
                'statutSoumission' => 'required|boolean'
            ]);

            // Rétourner une reponse d'échec pour les validations.
            if ($validateur->fails()) {
                return parent::ReponseJsonEchecValidation(erreurs: $validateur->errors()->toArray());
            }

            // Créer une candidature.
            $candidature = Candidature::create($entrees);

            // Raffraichir le modèle.
            $candidature->refresh();

            // Attributs à rétirer du modèle.
            $candidature = $candidature->makeHidden([
                'examinateur',
                'noteDiplomes',
                'noteCertificats',
                'noteExperiences',
                'noteLangues',
                'noteReponses',
                'noteGlobale',
                'updated_at',
                'auteurMiseAJour',
            ]);

            // Rétourner une reponse de succès.
            return parent::ReponseJsonSuccesCreation(donnees: $candidature->toArray());
        } catch (Exception $e) {
            return parent::ReponseJsonEchecServeur(exception: $e);
        }
    }

    /**
     * Voir une candidature.
	 *
	 * @param Request $requete
	 *
	 * @return JsonResponse $reponse
     */
    public function voir(Request $requete, string $id): JsonResponse
    {
        try {

            // Récupérer la candidature et ses rélations.
            $candidature = Candidature::with([
                'diplomes' => [
                    'domaineEtude',
                    'niveauEtude',
                    'niveauSpecialisation',
                ],
                'certificats' => ['domaineEtude'],
                'experiences' => ['domaineEtude'],
                'references',
                'langues',
                'centres',
                'competences',
                'portfolios',
            ])->findOrFail($id);

            // Récupérer l'utilisateur.
            $utilisateur = $requete->utilisateur;

            // Vérifier les autorisations.
            $porte = Gate::forUser($utilisateur);

            if ($porte->denies('proprietaire-modele', $candidature)) {
                throw new UnauthorizedException();
            }

            // Cacher certains champs à cet rôle utilisateur.
            $candidature = $candidature->makeHidden([
                'examinateur',
                'noteDiplomes',
                'noteCertificats',
                'noteExperiences',
                'noteLangues',
                'noteReponses',
                'noteGlobale',
                'auteurMiseAJour',
           ]);

            return parent::ReponseJsonSuccesVisualisation(donnees: $candidature->toArray());
        } catch (ModelNotFoundException $e) {
            return parent::ReponseJsonEchecNonTrouve();
        } catch (UnauthorizedException $e) {
            return parent::ReponseJsonEchecAutorisation();
        } catch (Exception $e) {
            return parent::ReponseJsonEchecServeur(exception: $e);
        }
    }

    /**
     * Lister ses candidatures.
	 *
	 * @param Request $requete
	 *
	 * @return JsonResponse $reponse
     */
    public function lister(Request $requete): JsonResponse
    {
        try {

            // Récupérer l'utilisateur.
            $utilisateur = $requete->utilisateur;

            // Récupérer ses candidatures.
            $candidatures = Candidature::where('utilisateur', $utilisateur->id)->orderBy('created_at', 'desc')->get([
                'id',
                'offre',
                'intitule',
                'statutSoumission',
                'statutExamination',
                'created_at',
                'updated_at',
            ]);

            // Vérifier l'effectif de ses instances.
            if ($candidatures->isEmpty()) {
                return parent::ReponseJsonEchecRessource();
            }

            return parent::ReponseJsonSucces(donnees: $candidatures->toArray());
        } catch (ModelNotFoundException $e) {
            return parent::ReponseJsonEchecNonTrouve();
        } catch (Exception $e) {
            return parent::ReponseJsonEchecServeur(exception: $e);
        }
    }

    /**
     * Mettre à jour sa candidature.
	 *
	 * @param Request $requete
	 *
	 * @return JsonResponse $reponse
     */
    public function mettreAJour(Request $requete, string $id): JsonResponse
    {
        try {

            // Récupérer l'instance de candidature à mettre à jour.
            $candidature = Candidature::findOrFail($id);

            // Récupérer l'utilisateur.
            $utilisateur = $requete->utilisateur;

            // Initialiser la porte de vérification.
            $porte = Gate::forUser($utilisateur);

            if ($porte->denies('proprietaire-modele', $candidature)) {
                throw new UnauthorizedException();
            }

            // Récupérer les entrées.
            $entrees = Arr::only($requete->json()->all(), [
                'intitule',
                'lettreMotivation',
                'statutSoumission',
            ]);

            // Valider les entrées.
            $validateur = Validator::make($entrees, [
                'intitule' => [
                    'required_without_all:lettreMotivation,statutSoumission',
                    'string',
                    'max:64',
                    new CandidatureMiseAJourRule,
                ],
                'lettreMotivation' => [
                    'required_without_all:intitule,statutSoumission',
                    'string',
                    'max:255',
                    new CandidatureMiseAJourRule,
                ],
                'statutSoumission' => [
                    'required_without_all:intitule,lettreMotivation',
                    'boolean',
                    new CandidatureMiseAJourRule,
                ],
            ]);

            if ($validateur->fails()) {
                return parent::ReponseJsonEchecValidation(erreurs: $validateur->errors()->toArray());
            }

            // Ajouter l'utilisateur comme auteurMiseAJour.
            $entrees['auteurMiseAJour'] = $utilisateur->id;

            // Mettre à jour la candidature.
            $candidature->update($entrees);

            // Raffraichir l'instance.
            $candidature->refresh();

            // Attributs à rétirer du modèle.
            $candidature = $candidature->makeHidden([
                'examinateur',
                'noteDiplomes',
                'noteCertificats',
                'noteExperiences',
                'noteLangues',
                'noteReponses',
                'noteGlobale',
                'auteurMiseAJour',
           ]);

            return parent::ReponseJsonSuccesMiseAJour(donnees: $candidature->toArray());
        } catch (ModelNotFoundException $e) {
            return parent::ReponseJsonEchecNonTrouve();
        } catch (UnauthorizedException $e) {
            return parent::ReponseJsonEchecAutorisation();
        } catch (Exception $e) {
            return parent::ReponseJsonEchecServeur(exception: $e);
        }
    }

    /**
     * Supprimer une candidature.
	 *
	 * @param Request $requete
	 *
	 * @return JsonResponse $reponse
     */
    public function supprimer(Request $requete, string $id): JsonResponse
    {
        try {

            // Récupérer l'instance de la candidature.
            $candidature = Candidature::findOrFail($id);

            // Récupérer l'utilisateur.
            $utilisateur = $requete->utilisateur;

            // Vérifier les autorisations.
            $porte = Gate::forUser($utilisateur);

            if ($porte->denies('proprietaire-modele', $candidature)) {
                throw new UnauthorizedException();
            }

            // Supprimer la candidature.
            $candidature->delete();

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
