<?php

namespace App\Http\Controllers\Can;

use App\Http\Controllers\Controller;
use App\Models\Emploi\CandidatDiplome;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\UnauthorizedException;

class CanDiplomeController extends Controller
{
    /**
     * Créer un diplôme.
     */
    public function creer(Request $requete): JsonResponse
    {
        try {

            // Récupérer les entrées.
            $entrees = Arr::only($requete->json()->all(), [
                'identifiant',
                'statutObtention',
                'intitule',
                'domaineEtude',
                'niveauEtude',
                'niveauSpecialisation',
                'organisation',
                'dateDebut',
                'dateFin',
                'dateDelivrance',
            ]);

            // Valider les entrées.
            $validateur = Validator::make($entrees, [
                'identifiant' => 'nullable|string|max:64',
                'statutObtention' => 'required|boolean',
                'intitule' => 'required|string|max:64',
                'domaineEtude' => 'required|exists:emploi_domaine_etudes,id',
                'niveauEtude' => 'required|exists:emploi_niveau_etudes,id',
                'niveauSpecialisation' => 'required|exists:emploi_niveau_specialisations,id',
                'organisation' => 'required|string|max:64',
                'dateDebut' => 'required|date_format:Y-m-d H:i:s|before:'.now()->format('Y-m-d H:i:s'),
                'dateFin' => 'nullable|date_format:Y-m-d H:i:s|after:dateDebut|before:'.now()->format('Y-m-d H:i:s'),
                'dateDelivrance' => 'required_if:statutObtention,true|prohibited_if:statutObtention,false|date_format:Y-m-d H:i:s|after_or_equal:dateFin',
            ]);

            if ($validateur->fails()) {
                return parent::ReponseJsonEchecValidation(erreurs: $validateur->errors()->toArray());
            }

            // Ajouter l'utilisateur comme propriétaire.
            $entrees['utilisateur'] = $requete->utilisateur->id;

            // Créer un diplôme.
            $diplome = CandidatDiplome::create($entrees);

            // Raffraichir le modèle.
            $diplome = CandidatDiplome::with([
                'domaineEtude',
                'niveauEtude',
                'niveauSpecialisation',
            ])->find($diplome->id);

            return parent::ReponseJsonSuccesCreation(donnees: $diplome->toArray());
        } catch (Exception $e) {
            return parent::ReponseJsonEchecServeur(exception: $e);
        }
    }

    /**
     * Voir un diplôme.
     */
    public function voir(Request $requete, string $id): JsonResponse
    {
        try {

            // Récupérer l'instance.
            $diplome = CandidatDiplome::with([
                'domaineEtude',
                'niveauEtude',
                'niveauSpecialisation',
            ])->findOrFail($id);

            // Récupérer l'utilisateur.
            $utilisateur = $requete->utilisateur;

            // Vérifier les autorisations.
            $porte = Gate::forUser($utilisateur);

            if ($porte->denies('proprietaire-modele', $diplome)) {
                throw new UnauthorizedException();
            }

            return parent::ReponseJsonSuccesVisualisation(donnees: $diplome->toArray());
        } catch (ModelNotFoundException $e) {
            return parent::ReponseJsonEchecNonTrouve();
        } catch (UnauthorizedException $e) {
            return parent::ReponseJsonEchecAutorisation();
        } catch (Exception $e) {
            return parent::ReponseJsonEchecServeur(exception: $e);
        }
    }

	/**
	 * Mettre à jour le fichier du diplôme.
	 *
	 * @param Request $requete
	 *
	 * @return JsonResponse $reponse
	*/
	public function mettreAJourFichier(Request $requete, string $id) : JsonResponse {

		try {

			// Récupérer l'instance.
			$diplome = CandidatDiplome::findOrFail($id);

			// Récupérer l'utilisateur.
			$utilisateur = $requete->utilisateur;

			// Vérifier les autorisations.
			$porte = Gate::forUser($utilisateur);

			if($porte->denies('proprietaire-modele', $diplome)) {
				throw new UnauthorizedException();
			}

			// Récéupérer les entrées.
            $entrees = $requete->only(['fichier']);

			// Valider les entrées.
            $validateur = Validator::make($entrees, [
                'fichier' => "required|file|max:10240|mimes:pdf",
            ]);

			if ($validateur->fails()) {
                return parent::ReponseJsonEchecValidation(erreurs: $validateur->errors()->toArray());
            }

			// Sauvegarder les fichier.
            if ($requete->hasFile('fichier')) {

				// Garantir l'existence du chemin de destination.
				$cheminStockage = 'public/utilisateurs/' . $utilisateur->id . "/diplomes/";

				if (!Storage::exists($cheminStockage)) { Storage::makeDirectory($cheminStockage); }

				// Récupérer l'ancien slug et créer un nouveau slug du fichier.
				$ancienSlug = $diplome->slug;

				$nouveauSlug = "diplome_" . date('Y') . "_" . date('m') . "_" . date('d') . "_" . date('H') .
				"_" . date('i') . "_" . date('s') . ".pdf";

				// Stocker le nouveau fichier du diplôme.
				if($requete->file('fichier')->storeAs($cheminStockage, $nouveauSlug)) {

					// Mettre à jour le slug dans l'instance.
					if($diplome->update(['slug' => $nouveauSlug])) {

						Storage::delete($cheminStockage . $ancienSlug);
					}

					else Storage::delete($cheminStockage . $nouveauSlug);
				}

				else { return parent::ReponseJsonEchecValidation(message: "Le fichier n'a pas pu être stocké."); }
            }

			else { return parent::ReponseJsonEchecValidation(message: "Le fichier n'a pas été uploadé."); }

			return parent::ReponseJsonSucces();

		} catch (ModelNotFoundException $e) {
            return parent::ReponseJsonEchecNonTrouve();
        } catch (UnauthorizedException $e) {
            return parent::ReponseJsonEchecAutorisation();
        } catch (Exception $e) {
            return parent::ReponseJsonEchecServeur(exception: $e);
        }
	}

    /**
     * Lister ses diplomes.
     *
     *
     * @return JsonResponse $reponse
     */
    public function lister(Request $requete): JsonResponse
    {

        try {

            // Récupérer l'utlisateur.
            $utilisateur = $requete->utilisateur;

            $diplomes = CandidatDiplome::where('utilisateur', $utilisateur->id)->orderBy('dateDebut', 'desc')->get([
                'id',
                'statutObtention',
                'identifiant',
                'intitule',
                'domaineEtude',
                'niveauEtude',
                'niveauSpecialisation',
                'organisation',
                'dateDebut',
                'dateFin',
                'dateDelivrance',
            ]);

            // Vérifier l'effectif.
            if ($diplomes->isEmpty()) {
                return parent::ReponseJsonEchecRessource();
            }

            return parent::ReponseJsonSucces(donnees: $diplomes->toArray());
        } catch (Exception $e) {
            return parent::ReponseJsonEchecServeur(exception: $e);
        }
    }

    /**
     * Mettre à jour un diplome.
     */
    public function mettreAJour(Request $requete, string $id): JsonResponse
    {
        try {

            // Rechercher l'instance.
            $diplome = CandidatDiplome::findOrFail($id);

            // Récupérer l'utilisateur.
            $utilisateur = $requete->utilisateur;

            // Vérifier les autorisations.
            $porte = Gate::forUser($utilisateur);

            if ($porte->denies('proprietaire-modele', $diplome)) {
                throw new UnauthorizedException();
            }

            // Récupérer les entrées.
            $entrees = Arr::only($requete->json()->all(), [
                'identifiant',
                'intitule',
                'statutObtention',
                'domaineEtude',
                'niveauEtude',
                'niveauSpecialisation',
                'organisation',
                'dateDebut',
                'dateFin',
                'dateDelivrance',
            ]);

            // Valider les entrées.
            $validateur = Validator::make($entrees, [
                'identifiant' => 'required_without_all:statutObtention,niveauEtude,niveauSpecialisation,intitule,domaineEtude,organistion,dateDebut,dateFin,dateDelivrance|string|max:64',
                'statutObtention' => 'required_without_all:niveauEtude,niveauSpecialisation,identifiant,intitule,domaineEtude,organistion,dateDebut,dateFin,dateDelivrance|boolean',
                'intitule' => 'required_without_all:statutObtention,niveauEtude,niveauSpecialisation,identifiant,domaineEtude,organistion,dateDebut,dateFin,dateDelivrance|string|max:64',
                'domaineEtude' => 'required_without_all:statutObtention,niveauEtude,niveauSpecialisation,identifiant,intitule,organistion,dateDebut,dateFin,dateDelivrance|exists:emploi_domaine_etudes,id',
                'niveauEtude' => 'required_without_all:statutObtention,niveauSpecialisation,identifiant,intitule,domaineEtude,organistion,dateDebut,dateFin,dateDelivrance|exists:emploi_niveau_etudes,id',
                'niveauSpecialisation' => 'required_without_all:statutObtention,niveauEtude,identifiant,intitule,domaineEtude,organistion,dateDebut,dateFin,dateDelivrance|exists:emploi_niveau_specialisations,id',
                'organisation' => 'required_without_all:statutObtention,niveauSpecialisation,niveauEtude,identifiant,intitule,domaineEtude,dateDebut,dateFin,dateDelivrance|string|max:64',
                'dateDebut' => 'required_without_all:statutObtention,niveauSpecialisation,niveauEtude,identifiant,intitule,domaineEtude,organistion,dateFin,dateDelivrance|date_format:Y-m-d H:i:s',
                'dateFin' => 'required_without_all:statutObtention,niveauEtude,niveauSpecialisation,identifiant,intitule,domaineEtude,organistion,dateDebut,dateDelivrance|date_format:Y-m-d H:i:s',
                'dateDelivrance' => 'required_without_all:statutObtention,niveauSpecialisation,niveauEtude,identifiant,intitule,domaineEtude,organistion,dateDebut,dateFin|date_format:Y-m-d H:i:s',
            ]);

            if ($validateur->fails()) {
                return parent::ReponseJsonEchecValidation(erreurs: $validateur->errors()->toArray());
            }

            // Mettre à jour l'instance.
            $diplome->update($entrees);

			$diplome = CandidatDiplome::with([
                'domaineEtude',
                'niveauEtude',
                'niveauSpecialisation',
            ])->find($diplome->id);

            return parent::ReponseJsonSuccesMiseAJour(donnees: $diplome->toArray());
        } catch (ModelNotFoundException $e) {
            return parent::ReponseJsonEchecNonTrouve();
        } catch (UnauthorizedException $e) {
            return parent::ReponseJsonEchecAutorisation();
        } catch (Exception $e) {
            return parent::ReponseJsonEchecServeur(exception: $e);
        }
    }

    /**
     * Supprimer un diplôme.
     */
    public function supprimer(Request $requete, string $id): JsonResponse
    {
        try {

            // Rechercher l'instance.
            $diplome = CandidatDiplome::findOrFail($id);

            // Récupérer l'utilisateur.
            $utilisateur = $requete->utilisateur;

            // Vérifier les autorisations.
            $porte = Gate::forUser($utilisateur);

            if ($porte->denies('proprietaire-modele', $diplome)) {
                throw new UnauthorizedException();
            }

            $diplome->delete();

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
