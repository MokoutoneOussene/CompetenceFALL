<?php

namespace App\Http\Controllers\Can;

use App\Http\Controllers\Controller;
use App\Models\Emploi\CandidatLangue;
use App\Models\Emploi\CandidatPortfolio;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\UnauthorizedException;

class CanPortfolioController extends Controller
{
    /**
     * Créer une réalisation.
     */
    public function creer(Request $requete): JsonResponse
    {
        try {

            // Récupérer les entrées.
            $entrees = Arr::only($requete->json()->all(), [
                'intitule',
                'date',
                'description',
                'lien',
            ]);

            // Valider les entrées.
            $validateur = Validator::make($entrees, [
                'intitule' => 'required|string|max:64',
                'date' => 'nullable|date_format:Y-m-d H:i:s|before:'.now()->format('Y-m-d H:i:s'),
                'description' => 'nullable|string|max:255',
                'lien' => 'nullable|url',
            ]);

            // Retourner un message d'échec des validations.
            if ($validateur->fails()) {
                return parent::ReponseJsonEchecValidation(erreurs: $validateur->errors()->toArray());
            }

            // Ajouter l'utilisateur comme propriétaire.
            $entrees['utilisateur'] = $requete->utilisateur->id;

            // Créer une realisation.
            $realisation = CandidatPortfolio::create($entrees);

            // Raffraichir le modèle.
            $realisation->refresh();

            // Retourner une reponse de succès.
            return parent::ReponseJsonSuccesCreation(donnees: $realisation->toArray());
        } catch (Exception $e) {
            return parent::ReponseJsonEchecServeur(exception: $e);
        }
    }

    /**
     * Lister ses réalisations.
     *
     *
     * @return JsonResponse $reponse
     */
    public function lister(Request $requete): JsonResponse
    {

        try {

            // Récupérer l'utlisateur.
            $utilisateur = $requete->utilisateur;

            $realisations = CandidatPortfolio::where('utilisateur', $utilisateur->id)->orderBy('intitule')->get();

            if ($realisations->isEmpty()) {
                return parent::ReponseJsonEchecRessource();
            }

            return parent::ReponseJsonSucces(donnees: $realisations->toArray());
        } catch (Exception $e) {
            return parent::ReponseJsonEchecServeur(exception: $e);
        }
    }

    /**
     * Supprimer une réalisation.
     */
    public function supprimer(Request $requete, string $id): JsonResponse
    {
        try {

            $realisation = CandidatLangue::findOrFail($id);

            // Récupérer l'utilisateur.
            $utilisateur = $requete->utilisateur;

            // Vérifier les autorisations.
            $porte = Gate::forUser($utilisateur);

            if ($porte->denies('proprietaire-modele', $realisation)) {
                throw new UnauthorizedException();
            }

            $realisation->delete();

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
