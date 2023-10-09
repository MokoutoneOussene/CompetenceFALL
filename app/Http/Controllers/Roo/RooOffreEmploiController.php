<?php

namespace App\Http\Controllers\Roo;

use App\Http\Controllers\Controller;
use App\Models\Emploi\OffreEmploi;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class RooOffreEmploiController extends Controller
{
	/**
	 * Créer une offre d'emploi.
	 *
	 *
	 * @return JsonResponse $reponse
	 */
	public function creer(Request $requete): JsonResponse
	{
		try {

			// Récupérer les entrées.
			$entrees = Arr::only($requete->json()->all(), [
				'poste',
				'contrat',
				'nomOrganisation',
				'infosOrganisation',
				'domaine',
				'prerequis',
				'lieu',
				'pays',
				'typeLieu',
				'remuneration',
				'avantages',
				'places',
				'dateDebutPoste',
				'consignes',
				'infosComplementaires',
				'pourcentageMoyenne',
				'statutPublication',
				'dateDebutPublication',
				'dateFinPublication',
			]);

			// Valider les entrées.
			$validateur = Validator::make($entrees, [
				'poste' => 'required|string|max:64',
				'contrat' => 'required|string|max:64',
				'nomOrganisation' => 'required|string|max:64',
				'infosOrganisation' => 'required|string|max:255',
				'domaine' => 'required|string|max:64',
				'prerequis' => 'required|string|max:255',
				'lieu' => 'required|string|max:64',
				'pays' => 'nullable|exists:systeme_pays,id',
				'typeLieu' => 'nullable|in:surSite,teleTravail,hybride',
				'remuneration' => "nullable|regex:/^\d+$/",
				'avantages' => 'nullable|string|max:255',
				'places' => 'required|int|min:1',
				'dateDebutPoste' => [
					'nullable',
					'date_format:Y-m-d H:i:s',
					'after:'.Carbon::parse(now())->addDays(1)->format('Y-m-d H:i:s'),
				],
				'consignes' => 'nullable|string|max:255',
				'infosComplementaires' => 'nullable|string|max:255',
				'pourcentageMoyenne' => 'nullable|int|min:1|max:100',
				'statutPublication' => 'nullable|boolean',
				'dateDebutPublication' => [
					'nullable',
					'date_format:Y-m-d H:i:s',
					'before:dateDebutPoste',
					'after:'.Carbon::parse(now())->addMinutes(10)->format('Y-m-d H:i:s'),
				],
				'dateFinPublication' => [
					'nullable',
					'date_format:Y-m-d H:i:s',
					'after:dateDebutPublication',
				],
			]);

			if ($validateur->fails()) {
				return parent::ReponseJsonEchecValidation(erreurs: $validateur->errors()->toArray());
			}

			// Récupérer l'utilisateur.
			$utilisateur = $requete->utilisateur;

			// Injecter l'utilisateur comme auteurCreation.
			$entrees['auteurCreation'] = $utilisateur->id;

			// Persister l'instance.
			$offre = OffreEmploi::create($entrees);

			// Récupérer l'instance et ses rélations.
			$offre = OffreEmploi::with([
				'pays',
				'auteurCreation' => [
					'personne' => [
						'paysNaissance',
						'paysResidence',
					],
					'organisation' => ['paysSiege'],
				],
				'auteurMiseAJour' => [
					'personne' => [
						'paysNaissance',
						'paysResidence',
					],
					'organisation' => ['paysSiege'],
				],
				'prerequisDiplomes' => [
					'domaineEtude',
					'niveauEtude',
					'niveauSpecialisation',
				],
				'prerequisCertificats' => ['domaineEtude'],
				'prerequisExperiences' => ['domaineEtude'],
				'prerequisLangues',
				'questions',
			])->find($offre->id);

			// Enregistrer l'activité.
			parent::enregistrerCreation($utilisateur, $entrees, OffreEmploi::class, $offre->id);

			return parent::ReponseJsonSuccesCreation(donnees: $offre->toArray());
		} catch (Exception $e) {
			return parent::ReponseJsonEchecServeur(exception: $e);
		}
	}

	/**
	 * Voir une offre d'emploi.
	 *
	 *
	 * @return JsonResponse $reponse
	 */
	public function voir(string $id): JsonResponse
	{

		try {

			// Rechercher l'instance à visualiser et ses rélations.
			$offre = OffreEmploi::with([
				'pays',
				'auteurCreation' => [
					'personne' => [
						'paysNaissance',
						'paysResidence',
					],
					'organisation' => ['paysSiege'],
				],
				'auteurMiseAJour' => [
					'personne' => [
						'paysNaissance',
						'paysResidence',
					],
					'organisation' => ['paysSiege'],
				],
				'prerequisDiplomes' => [
					'domaineEtude',
					'niveauEtude',
					'niveauSpecialisation',
				],
				'prerequisCertificats' => ['domaineEtude'],
				'prerequisExperiences' => ['domaineEtude'],
				'prerequisLangues',
				'questions',
			])->findOrFail($id);

			return parent::ReponseJsonSuccesVisualisation(donnees: $offre->toArray());
		} catch (ModelNotFoundException $e) {
			return parent::ReponseJsonEchecNonTrouve();
		} catch (Exception $e) {
			return parent::ReponseJsonEchecServeur(exception: $e);
		}
	}

	/**
	 * Télécharger le fichier PDF d'une offre d'emploi.
	 *
	 *
	 * @return Response $reponse
	 */
	public function telecharger(Request $requete, string $id)
	{

		try {

			// Rechercher l'instance à transformer et ses rélations.
			$offre = OffreEmploi::with([
				'pays',
				'auteurCreation' => [
					'personne' => [
						'paysNaissance',
						'paysResidence',
					],
					'organisation' => ['paysSiege'],
				],
				'auteurMiseAJour' => [
					'personne' => [
						'paysNaissance',
						'paysResidence',
					],
					'organisation' => ['paysSiege'],
				],
				'prerequisDiplomes' => [
					'domaineEtude',
					'niveauEtude',
					'niveauSpecialisation',
				],
				'prerequisCertificats' => ['domaineEtude'],
				'prerequisExperiences' => ['domaineEtude'],
				'prerequisLangues',
				'questions',
			])->findOrFail($id);

			// Formatter le champs de la date de prise de fonction.
			if (isset($offre->dateDebutPoste)) {
				$offre->dateDebutPoste = Carbon::parse($offre->dateDebutPoste)->format('Y-m-d');
			}

			// Récupérer l'utilisateur.
			$utilisateur = $requete->utilisateur;

			// Préparer un tableau avec les objets pou la vue blade.
			$donnees = [
				'offre' => $offre,
				'utilisateur' => $utilisateur,
			];

			// Charger le modèle HTML et générer le PDF.
			$pdf = Pdf::loadView('pdfs.emplois.offres.test-offre', compact('donnees'));

			// Proposer le PDF en streaming ou en téléchargement.
			return $pdf->download('offre.pdf');
		} catch (ModelNotFoundException $e) {
			return parent::ReponseJsonEchecNonTrouve();
		} catch (Exception $e) {
			return parent::ReponseJsonEchecServeur(exception: $e);
		}
	}

	/**
	 * Lister les offres d'emploi.
	 *
	 *
	 * @return JsonResponse $reponse
	 */
	public function lister(Request $requete): JsonResponse
	{
		try {

			// Récupérer l'effectif des instances en base de données.
			$total = OffreEmploi::count();

			if (! $total) {
				return parent::ReponseJsonEchecRessource();
			}

			// Récuéprer les entrées.
			$entrees = Arr::only($requete->all(), [
				'nombre',
				'debut',
				'champsTri',
				'sensTri',
			]);

			// Valider les entrées.
			$validateur = Validator::make($entrees, [
				'nombre' => 'nullable|int|min:0',
				'debut' => 'nullable|int|min:0|max:'.(int) $total - 1,
				'champsTri' => 'nullable|in:poste,contrat,domaine,lieu,'.
					'pays,statutPublication,created_at,updated_at',
				'sensTri' => 'nullable|in:asc,desc',
			]);

			if ($validateur->fails()) {
				return parent::ReponseJsonEchecValidation(erreurs: $validateur->errors()->toArray());
			}

			// Préparer les filtres.
			$nombre = isset($entrees['nombre']) ? (int) $entrees['nombre'] : 100;
			$nombre = $nombre > 1000 ? 1000 : $nombre;
			$debut = isset($entrees['debut']) ? (int) $entrees['debut'] : 0;
			$sensTri = isset($entrees['sensTri']) ? $entrees['sensTri'] : 'asc';
			$champsTri = isset($entrees['champsTri']) ? $entrees['champsTri'] : 'created_at';

			// Récupérer les instances dans le cas où pays est le champs de tri.
			if ($champsTri == 'pays') {

				$offres = OffreEmploi::with('pays')->join('systeme_pays', 'emploi_offre_emplois.pays', '=', 'systeme_pays.id')
					->orderBy('systeme_pays.nom', $sensTri)
					->offset($debut)
					->limit($nombre)
					->get([
						'emploi_offre_emplois.id', 'emploi_offre_emplois.poste', 'emploi_offre_emplois.contrat', 'emploi_offre_emplois.domaine', 'emploi_offre_emplois.lieu', 'emploi_offre_emplois.pays', 'emploi_offre_emplois.statutPublication', 'emploi_offre_emplois.created_at', 'emploi_offre_emplois.updated_at',
					]);
			}

			// Récupérer les instances dans le cas où pays n'est pas le champs de tri.
			else {

				$offres = OffreEmploi::with('pays')->orderBy($champsTri, $sensTri)->offset($debut)->limit($nombre)->get([
					'id', 'poste', 'contrat', 'domaine', 'lieu', 'pays', 'statutPublication', 'created_at', 'updated_at',
				]);
			}

			// Vérifier l'effectif des instances.
			if ($offres->isEmpty()) {
				return parent::ReponseJsonEchecRessource();
			}

			// Valider l'effectif de correspondances.
			if ($offres->isEmpty()) {
				return parent::ReponseJsonEchecRessource();
			}

			return parent::ReponseJsonSucces(donnees: $offres->toArray());
		} catch (Exception $e) {
			return parent::ReponseJsonEchecServeur(exception: $e);
		}
	}

	/**
	 * Rechercher une offre d'emploi.
	 *
	 *
	 * @return JsonResponse $reponse
	 */
	public function rechercher(Request $requete): JsonResponse
	{

		try {

			// Récupérer l'effectif des instances en base de données.
			$total = OffreEmploi::count();

			if (! $total) {
				return parent::ReponseJsonEchecRessource();
			}

			// Récuéprer les entrées.
			$entrees = Arr::only($requete->all(), [
				'poste',
				'domaine',
				'contrat',
				'lieu',
				'pays'
			]);

			// Valider les entrées.
			$validateur = Validator::make($entrees, [
				'poste' => "required_without_all:poste,domaine,contrat,lieu,pays|string|max:64",
				'domaine' => "required_without_all:poste,domaine,contrat,lieu,pays|string|max:64",
				'contrat' => "required_without_all:poste,domaine,contrat,lieu,pays|string|max:64",
				'lieu' => "required_without_all:poste,domaine,contrat,lieu,pays|string|max:64",
				'pays' => "required_without_all:poste,domaine,contrat,lieu,pays|string|max:64"
			]);

			$offres = OffreEmploi::rechercher(OffreEmploi::query(), $entrees, isset($entrees['pays']) ? TRUE : FALSE);

			if($offres->isEmpty()) { return parent::ReponseJsonEchecRessource(); }

			$offres = $offres->sortBy('dateDebutPublication');

			if ($validateur->fails()) {
				return parent::ReponseJsonEchecValidation(erreurs: $validateur->errors()->toArray());
			}

			return parent::ReponseJsonSucces(donnees: $offres->toArray());
		} catch (Exception $e) {
			return parent::ReponseJsonEchecServeur(exception: $e);
		}

	}

	/**
	 * Mettre à jour une offre d'emploi.
	 *
	 *
	 * @return JsonResponse $reponse
	 */
	public function mettreAJour(Request $requete, string $id): JsonResponse
	{

		try {

			// Rechercher l'instance à mettre ç=à jour.
			$offre = OffreEmploi::findOrFail($id);

			// Récupérer les entrées.
			$entrees = Arr::only($requete->json()->all(), [
				'poste',
				'contrat',
				'nomOrganisation',
				'infosOrganisation',
				'domaine',
				'prerequis',
				'lieu',
				'pays',
				'typeLieu',
				'remuneration',
				'avantages',
				'places',
				'dateDebutPoste',
				'consignes',
				'infosComplementaires',
				'pourcentageMoyenne',
				'statutPublication',
				'dateDebutPublication',
				'dateFinPublication',
			]);

			// Valider les entrées.
			$validateur = Validator::make($entrees, [
				'poste' => 'required_without_all:poste,contrat,nomOrganisation,infosOrganisation,dimaine,prerequis,lieu,pays,typeLieu,remuneration,avantages,places,dateDebutPoste,consignes,infosComplementaires,pourcentageMoyenne,statutPublication,dateDebutPublication,dateFinPublication'.'|string|max:64',
				'contrat' => 'required_without_all:poste,contrat,nomOrganisation,infosOrganisation,dimaine,prerequis,lieu,pays,typeLieu,remuneration,avantages,places,dateDebutPoste,consignes,infosComplementaires,pourcentageMoyenne,statutPublication,dateDebutPublication,dateFinPublication'.'|string|max:64',
				'nomOrganisation' => 'required_without_all:poste,contrat,nomOrganisation,infosOrganisation,dimaine,prerequis,lieu,pays,typeLieu,remuneration,avantages,places,dateDebutPoste,consignes,infosComplementaires,pourcentageMoyenne,statutPublication,dateDebutPublication,dateFinPublication'.'|string|max:64',
				'infosOrganisation' => 'required_without_all:poste,contrat,nomOrganisation,infosOrganisation,dimaine,prerequis,lieu,pays,typeLieu,remuneration,avantages,places,dateDebutPoste,consignes,infosComplementaires,pourcentageMoyenne,statutPublication,dateDebutPublication,dateFinPublication'.'|string|max:255',
				'domaine' => 'required_without_all:poste,contrat,nomOrganisation,infosOrganisation,dimaine,prerequis,lieu,pays,typeLieu,remuneration,avantages,places,dateDebutPoste,consignes,infosComplementaires,pourcentageMoyenne,statutPublication,dateDebutPublication,dateFinPublication'.'|string|max:64',
				'prerequis' => 'required_without_all:poste,contrat,nomOrganisation,infosOrganisation,dimaine,prerequis,lieu,pays,typeLieu,remuneration,avantages,places,dateDebutPoste,consignes,infosComplementaires,pourcentageMoyenne,statutPublication,dateDebutPublication,dateFinPublication'.'|string|max:255',
				'lieu' => 'required_without_all:poste,contrat,nomOrganisation,infosOrganisation,dimaine,prerequis,lieu,pays,typeLieu,remuneration,avantages,places,dateDebutPoste,consignes,infosComplementaires,pourcentageMoyenne,statutPublication,dateDebutPublication,dateFinPublication'.'|string|max:64',
				'pays' => 'required_without_all:poste,contrat,nomOrganisation,infosOrganisation,dimaine,prerequis,lieu,pays,typeLieu,remuneration,avantages,places,dateDebutPoste,consignes,infosComplementaires,pourcentageMoyenne,statutPublication,dateDebutPublication,dateFinPublication'.'|exists:systeme_pays,id',
				'typeLieu' => 'required_without_all:poste,contrat,nomOrganisation,infosOrganisation,dimaine,prerequis,lieu,pays,typeLieu,remuneration,avantages,places,dateDebutPoste,consignes,infosComplementaires,pourcentageMoyenne,statutPublication,dateDebutPublication,dateFinPublication'.'|in:surSite,teleTravail,hybride',
				'remuneration' => 'required_without_all:poste,contrat,nomOrganisation,infosOrganisation,dimaine,prerequis,lieu,pays,typeLieu,remuneration,avantages,places,dateDebutPoste,consignes,infosComplementaires,pourcentageMoyenne,statutPublication,dateDebutPublication,dateFinPublication'."|int|regex:/^\d+$/",
				'avantages' => 'required_without_all:poste,contrat,nomOrganisation,infosOrganisation,dimaine,prerequis,lieu,pays,typeLieu,remuneration,avantages,places,dateDebutPoste,consignes,infosComplementaires,pourcentageMoyenne,statutPublication,dateDebutPublication,dateFinPublication'.'|string|max:255',
				'places' => 'required_without_all:poste,contrat,nomOrganisation,infosOrganisation,dimaine,prerequis,lieu,pays,typeLieu,remuneration,avantages,places,dateDebutPoste,consignes,infosComplementaires,pourcentageMoyenne,statutPublication,dateDebutPublication,dateFinPublication'.'|int|min:1',
				'dateDebutPoste' => 'required_without_all:poste,contrat,nomOrganisation,infosOrganisation,dimaine,prerequis,lieu,pays,typeLieu,remuneration,avantages,places,dateDebutPoste,consignes,infosComplementaires,pourcentageMoyenne,statutPublication,dateDebutPublication,dateFinPublication'.'|date_format:Y-m-d H:i:s',
				'consignes' => 'required_without_all:poste,contrat,nomOrganisation,infosOrganisation,dimaine,prerequis,lieu,pays,typeLieu,remuneration,avantages,places,dateDebutPoste,consignes,infosComplementaires,pourcentageMoyenne,statutPublication,dateDebutPublication,dateFinPublication'.'|string|max:255',
				'infosComplementaires' => 'required_without_all:poste,contrat,nomOrganisation,infosOrganisation,dimaine,prerequis,lieu,pays,typeLieu,remuneration,avantages,places,dateDebutPoste,consignes,infosComplementaires,pourcentageMoyenne,statutPublication,dateDebutPublication,dateFinPublication'.'|string|max:255',
				'pourcentageMoyenne' => 'required_without_all:poste,contrat,nomOrganisation,infosOrganisation,dimaine,prerequis,lieu,pays,typeLieu,remuneration,avantages,places,dateDebutPoste,consignes,infosComplementaires,pourcentageMoyenne,statutPublication,dateDebutPublication,dateFinPublication'.'|int|max:100',
				'statutPublication' => 'required_without_all:poste,contrat,nomOrganisation,infosOrganisation,dimaine,prerequis,lieu,pays,typeLieu,remuneration,avantages,places,dateDebutPoste,consignes,infosComplementaires,pourcentageMoyenne,statutPublication,dateDebutPublication,dateFinPublication'.'|boolean',
				'dateDebutPublication' => 'required_without_all:poste,contrat,nomOrganisation,infosOrganisation,dimaine,prerequis,lieu,pays,typeLieu,remuneration,avantages,places,dateDebutPoste,consignes,infosComplementaires,pourcentageMoyenne,statutPublication,dateDebutPublication,dateFinPublication'.'|date_format:Y-m-d H:i:s|after:'.now()->format('Y-m-d h:i:s'),
				'dateFinPublication' => 'required_without_all:poste,contrat,nomOrganisation,infosOrganisation,dimaine,prerequis,lieu,pays,typeLieu,remuneration,avantages,places,dateDebutPoste,consignes,infosComplementaires,pourcentageMoyenne,statutPublication,dateDebutPublication,dateFinPublication'.'|date_format:Y-m-d H:i:s|after:dateDebutPublication',
			]);

			if ($validateur->fails()) {
				return parent::ReponseJsonEchecValidation(erreurs: $validateur->errors()->toArray());
			}

			// Récupérer l'utilisateur.
			$utilisateur = $requete->utilisateur;

			// Ajouter l'utilisateur comme auteurMiseAJour.
			$entrees['auteurMiseAJour'] = $utilisateur->id;

			// Mettre à jour l'instance.
			$offre->update($entrees);

			// Récupérer l'instance et ses rélations.
			$offre = OffreEmploi::with([
				'pays',
				'auteurCreation' => [
					'personne' => [
						'paysNaissance',
						'paysResidence',
					],
					'organisation' => ['paysSiege'],
				],
				'auteurMiseAJour' => [
					'personne' => [
						'paysNaissance',
						'paysResidence',
					],
					'organisation' => ['paysSiege'],
				],
				'prerequisDiplomes' => [
					'domaineEtude',
					'niveauEtude',
					'niveauSpecialisation',
				],
				'prerequisCertificats' => ['domaineEtude'],
				'prerequisExperiences' => ['domaineEtude'],
				'prerequisLangues',
				'questions',
			])->find($id);

			// Enregistrer l'activité.
			parent::enregistrerMiseAJour($utilisateur, $entrees, OffreEmploi::class, $id);

			// Reponse de succès.
			return parent::ReponseJsonSuccesMiseAJour(donnees: $offre->toArray());
		} catch (ModelNotFoundException $e) {
			return parent::ReponseJsonEchecNonTrouve();
		} catch (Exception $e) {
			return parent::ReponseJsonEchecServeur(exception: $e);
		}
	}

	/**
	 * Supprimer une offre d'emploi.
	 *
	 *
	 * @return JsonResponse $reponse
	 */
	public function supprimer(Request $requete, string $id): JsonResponse
	{

		try {

			// Rechercher l'instance à supprimer.
			$offre = OffreEmploi::findOrFail($id);

			// Supprimer l'instance.
			$offre->delete();

			// Récupérer l'utilisateur.
			$utilisateur = $requete->utilisateur;

			// Enregistrer l'activité.
			parent::enregistrerSuppression($utilisateur, OffreEmploi::class, $id);

			return parent::ReponseJsonSuccesSuppression();
		} catch (ModelNotFoundException $e) {
			return parent::ReponseJsonEchecNonTrouve();
		} catch (Exception $e) {
			return parent::ReponseJsonEchecServeur(exception: $e);
		}
	}
}
