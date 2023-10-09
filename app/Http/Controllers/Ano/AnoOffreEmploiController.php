<?php

namespace App\Http\Controllers\Ano;

use App\Http\Controllers\Controller;
use App\Models\Emploi\OffreEmploi;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;

class AnoOffreEmploiController extends Controller
{
    /**
     * Lister les offres d'emploi.
     *
     *
     * @return JsonResponse $reponse
     */
    public function lister(Request $requete): JsonResponse
    {

        try {

            $offres = OffreEmploi::where('statutPublication', true)->orderBy('created_at')->get([
                'id',
                'poste',
                'contrat',
                'domaine',
                'dateLimite',
                'lieu',
                'pays',
                'typeLieu',
                'remuneration',
                'places',
                'dateDebutPublication',
                'dateFinPublication',
            ]);

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

			// Filtrer les recherches.
			$offresFiltrees = $offres->filter(function ($item) {
				return $item->statutPublication === TRUE;
			})->sortBy('dateDebutPublication')->map(function ($offre) {
				return [
					'poste',
					'contrat',
					'nomOrganisation',
					'domaine',
					'dateLimite',
					'lieu',
					'pays',
					'typeLieu',
					'remuneration',
					'places',
					'dateDebutPoste',
					'dateDebutPublication',
					'dateFinPublication'
				];
			});

            if ($validateur->fails()) {
                return parent::ReponseJsonEchecValidation(erreurs: $validateur->errors()->toArray());
            }

            return parent::ReponseJsonSucces(donnees: $offres->toArray());
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
}
