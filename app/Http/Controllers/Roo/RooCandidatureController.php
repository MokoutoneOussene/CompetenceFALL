<?php

namespace App\Http\Controllers\Roo;

use App\Http\Controllers\Controller;
use App\Models\Emploi\Candidature;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class RooCandidatureController extends Controller
{
	/**
	 * Voir une candidature.
	 *
	 *
	 * @return JsonResponse $reponse
	 */
	public function voir(string $id): JsonResponse
	{

		try {

			// Rechercher l'instance à visualiser et ses rélations.
			$candidature = Candidature::with([
				'diplomes',
				'certificats',
				'experiences',
				'references',
				'portfolios',
				'competences',
				'centres',
				'langue',
				'utilisateur' => [
					'personne' => [
						'paysNaissance',
						'paysResidence',
					],
				],
			])->findOrFail($id);

			return parent::ReponseJsonSuccesVisualisation(donnees: $candidature->toArray());
		} catch (ModelNotFoundException $e) {
			return parent::ReponseJsonEchecNonTrouve();
		} catch (Exception $e) {
			return parent::ReponseJsonEchecServeur(exception: $e);
		}
	}

	/**
	 * Lister les candidatures d'une offre d'emploi.
	 *
	 *
	 * @return JsonResponse $reponse
	 */
	public function lister(Request $requete, string $id): JsonResponse
	{

		try {

			// Rechercher les instances de candidatures pour l'id de l'offre de l'offre fourni.
			$candidatures = Candidature::where('offre', $id)->orderBy('created_at', 'desc')->get([
				'id',
				'utilisateur',
				'examinateur',
				'intitule',
				'statutSoumission',
				'statutExamination',
				'noteGlobale',
				'created_at',
				'updated_at',
				'auteurMiseAJour'
			]);

			// Vérifier l'effectif des instances.
			if ($candidatures->isEmpty()) {
				return parent::ReponseJsonEchecRessource();
			}

			return parent::ReponseJsonSucces(donnees: $candidatures->toArray());
		} catch (Exception $e) {
			return parent::ReponseJsonEchecServeur(exception: $e);
		}
	}

	/**
	 * Rechercher desc candidatures.
	 *
	 *
	 * @return JsonResponse $reponse
	 */
	public function rechercher(Request $requete): JsonResponse
	{

		return response()->json([

			'message' => 'En cours de développement...',

		], Response::HTTP_ACCEPTED);
	}

	/**
	 * Mettre à jour une candidature.
	 *
	 *
	 * @return JsonResponse $reponse
	 */
	public function mettreAJour(Request $requete, string $id): JsonResponse
	{

		try {

			// Rechercher l'instance à mettre à jour.
			$candidature = Candidature::with('offre')->findOrFail($id);

			// Récupérer les entrées.
			$entrees = Arr::only($requete->json()->all(), ['statutExamination', 'observations']);

			// Valider les entrées.
			$validateur = Validator::make($entrees, [
				'statutExamination' => 'nullable|boolean',
				'observations' => 'required|max:255',
			]);

			if ($validateur->fails()) {
				return parent::ReponseJsonEchecValidation(erreurs: $validateur->errors()->toArray());
			}

			// Récupérer l'utilisateur.
			$utilisateur = $requete->utilisateur;

			// Ajouter l'utilisateur comme auteurMiseAJour.
			$entrees['auteurMiseAJour'] = $utilisateur->id;

			// Mettre à jour l'instance.
			$candidature->update($entrees);

			// Raffraichir l'instance.
			$candidature->refresh();

			// Enregistrer l'activité.
			parent::enregistrerMiseAJour($utilisateur, $entrees, Candidature::class, $id);

			return parent::ReponseJsonSuccesMiseAJour(donnees: $candidature->toArray());
		} catch (ModelNotFoundException $e) {
			return parent::ReponseJsonEchecNonTrouve();
		} catch (Exception $e) {
			return parent::ReponseJsonEchecServeur(exception: $e);
		}
	}
}
