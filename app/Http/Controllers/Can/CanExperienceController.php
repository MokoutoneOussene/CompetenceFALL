<?php

namespace App\Http\Controllers\Can;

use App\Http\Controllers\Controller;
use App\Models\Emploi\CandidatExperience;
use App\Models\Emploi\Candidature;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\UnauthorizedException;

class CanExperienceController extends Controller
{
    /**
     * Créer une nouvelle candidature.
     */
    public function creer(Request $requete): JsonResponse
    {
        try {

            // Récupérer les entrées.
            $entrees = Arr::only($requete->json()->all(), [
                'poste',
                'domaineEtude',
                'duree',
                'dateDebut',
                'dateFin',
                'taches',
                'contrat',
                'organisation',
                'lieu',
                'pays',
                'typeLieu',
                'cheminAttestation',
                'nomSuperieur',
                'prenomsSuperieur',
                'posteSuperieur',
                'indicatifTelephoniqueSuperieur',
                'telephoneSuperieur',
            ]);

            // Valider les entrées.
            $validateur = Validator::make($entrees, [
                'poste' => 'required|string|max:64',
                'domaineEtude' => 'required|exists:emploi_domaine_etudes,id',
                'duree' => 'required|int|min:1',
                'dateDebut' => 'required|date_format:Y-m-d H:i:s',
                'dateFin' => 'nullable|date_format:Y-m-d H:i:s|after:dateDebut',
                'taches' => 'required|string|max:255',
                'contrat' => 'required|string|max:64',
                'organisation' => 'required|string|max:64',
                'lieu' => 'required|string|max:64',
                'pays' => 'required|exists:systeme_pays,id',
                'typeLieu' => 'required|in:surSite,teleTravail,hybride',
                'nomSuperieur' => 'required|string|max:64',
                'prenomsSuperieur' => 'required|string|max:64',
                'posteSuperieur' => 'required|string|max:64',
                'indicatifTelephoniqueSuperieur' => 'required|int|min:1|max:999',
                'telephoneSuperieur' => "required|regex:/^\d+$/|min:8|max:12",
            ]);

            if ($validateur->fails()) {
                return parent::ReponseJsonEchecValidation(erreurs: $validateur->errors()->toArray());
            }

            // Ajouter l'utilisateur comme propriétaire.
            $entrees['utilisateur'] = $requete->utilisateur;

            // Créer une nouvelle candidature.
            $experience = CandidatExperience::create($entrees);

            return parent::ReponseJsonSuccesCreation(donnees: $experience->toArray());
        } catch (Exception $e) {
            return parent::ReponseJsonEchecServeur(exception: $e);
        }
    }

    /**
     * Lister
     *
     *
     * @return JsonResponse $reponse
     */
    public function lister(Request $requete): JsonResponse
    {

        try {

            // Récupérer l'utilisateur.
            $utilisateur = $requete->utilisateur;

            // Récupérer les expériences.
            $experiences = CandidatExperience::where('utilisateur', $utilisateur->id)->get();

            // Vérifier l'effectif.
            if ($experiences->isEmpty()) {
                return parent::ReponseJsonEchecRessource();
            }

            return parent::ReponseJsonSucces(donnees: $experiences->toArray());
        } catch (Exception $e) {
            return parent::ReponseJsonEchecServeur(exception: $e);
        }
    }

    /**
     * Supprimer une candidature.
     */
    public function supprimer(Request $requete, string $id): JsonResponse
    {
        try {

            $experience = Candidature::findOrFail($id);

            // Récupérer l'utilisateur.
            $utilisateur = $requete->utilisateur;

            // Vérifier les autorisations.
            $porte = Gate::forUser($utilisateur);

            if ($porte->denies('proprietaire-modele', $experience)) {
                throw new UnauthorizedException();
            }

            $experience->delete();

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
