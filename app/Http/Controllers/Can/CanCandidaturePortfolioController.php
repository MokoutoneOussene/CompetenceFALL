<?php

namespace App\Http\Controllers\Can;

use App\Http\Controllers\Controller;
use App\Jobs\Emploi\CalculerNoteCandidatureJob;
use App\Models\Emploi\CandidatCentre;
use App\Models\Emploi\CandidatPortfolio;
use App\Models\Emploi\Candidature;
use App\Models\Emploi\CandidaturePortfolio;
use App\Rules\Emploi\Candidature\CandidaturePortfolioUniqueRule;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\UnauthorizedException;

class CanCandidaturePortfolioController extends Controller
{
    /**
     * Ajouter un portfoliolienCv à sa candidature.
     */
    public function lier(Request $requete): JsonResponse
    {
        try {

            // Récupérer les entrées.
            $entrees = Arr::only($requete->json()->all(), [
                'candidature',
                'portfolio',
            ]);

            // Valider les entrées.
            $validateur = Validator::make($entrees, [
                'candidature' => 'required|exists:emploi_candidatures,id',
                'portfolio' => [
                    'required',
                    'exists:emploi_candidat_portfolios,id',
                    new CandidaturePortfolioUniqueRule,
                ],
            ]);

            // Retourner un message d'échec des validations.
            if ($validateur->fails()) {
                return parent::ReponseJsonEchecValidation(erreurs: $validateur->errors()->toArray());
            }

            // Récupérer l'utilisateur.
            $utilisateur = $requete->utilisateur;

            // Récupérer la candidature.
            $candidature = Candidature::find($entrees['candidature']);

            // Vérifier les autorisations.
            $porte = Gate::forUser($utilisateur);

            if ($porte->denies('proprietaire-modele', $candidature)) {
                throw new UnauthorizedException();
            }

            // Récupérer le portfoliolienCv.
            $portfolio = CandidatPortfolio::find($entrees['portfolio']);

            if ($porte->denies('proprietaire-modele', $portfolio)) {
                throw new UnauthorizedException();
            }

            // Créer un lien portfoliolienCvs.
            $lien = CandidaturePortfolio::create($entrees);

            // Raffraichir le modèle.
            $lien->refresh();

            // Retourner une reponse de succès.
            return parent::ReponseJsonSuccesCreation(donnees: $lien->toArray());
        } catch (UnauthorizedException $e) {
            return parent::ReponseJsonEchecAutorisation();
        } catch (Exception $e) {
            return parent::ReponseJsonEchecServeur(exception: $e);
        }
    }

    /**
     * Supprimer un portfolio d'intérêts d'une candidature.
     */
    public function delier(Request $requete, string $id): JsonResponse
    {
        try {

            // Rechercher le lien.
            $lien = CandidaturePortfolio::findOrFail($id);

            $candidature = $lien->candidature()->first();

            // Récupérer l'utilisateur.
            $utilisateur = $requete->utilisateur;

            // Vérifier les autorisations.
            $porte = Gate::forUser($utilisateur);

            if ($porte->denies('proprietaire-modele', $candidature)) {
                throw new UnauthorizedException();
            }

            $lien->delete();

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
