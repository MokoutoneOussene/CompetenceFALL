<?php

namespace App\Http\Controllers\Can;

use App\Http\Controllers\Controller;
use App\Models\Emploi\CandidatCertificat;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\UnauthorizedException;

class CanCertificatController extends Controller
{
    /**
     * Créer une certificat.
     */
    public function creer(Request $requete): JsonResponse
    {
        try {

            // Récupérer les entrées.
            $entrees = Arr::only($requete->json()->all(), [
                'identifiant',
                'intitule',
                'domaineEtude',
                'organisation',
                'dateDebut',
                'dateFin',
                'dateDelivrance',
            ]);

            // Valider les entrées.
            $validateur = Validator::make($entrees, [
                'identifiant' => 'nullable|string|max:64',
                'intitule' => 'required|string|max:64',
                'domaineEtude' => 'required|exists:emploi_domaine_etudes,id',
                'organisation' => 'required|string|max:64',
                'dateDebut' => [
                    'required',
                    'date_format:Y-m-d H:i:s',
                    'before:'.now()->format('Y-m-d H:i:s'),
                ],
                'dateFin' => [
                    'nullable',
                    'date_format:Y-m-d H:i:s',
                    'after:dateDebut',
                    'before:'.now()->format('Y-m-d H:i:s'),
                ],
                'dateDelivrance' => [
                    'nullable',
                    'date_format:Y-m-d H:i:s',
                    'after_or_equal:dateFin',
                ],
            ]);

            if ($validateur->fails()) {
                return parent::ReponseJsonEchecValidation(erreurs: $validateur->errors()->toArray());
            }

            // Ajouter l'utilisateur comme propriétaire.
            $entrees['utilisateur'] = $requete->utilisateur->id;

            // Créer un nouveau certificat.
            $certificat = CandidatCertificat::create($entrees);

            // Raffraichir le modèle.
            $certificat = CandidatCertificat::with(['domaineEtude'])->find($certificat->id);

            return parent::ReponseJsonSuccesCreation(donnees: $certificat->toArray());
        } catch (Exception $e) {
            return parent::ReponseJsonEchecServeur(exception: $e);
        }
    }

    /**
     * Voir un certificat.
     */
    public function voir(Request $requete, string $id): JsonResponse
    {
        try {

            // Rechercher l'instance à visualiser.
            $certificat = CandidatCertificat::with(['domaineEtude'])->findOrFail($id);

            // Récupérer l'utilisateur.
            $utilisateur = $requete->utilisateur;

            $porte = Gate::forUser($utilisateur);

            if ($porte->denies('proprietaire-modele', $certificat)) {
                throw new UnauthorizedException();
            }

            return parent::ReponseJsonSuccesVisualisation(donnees: $certificat->toArray());
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
			$certificat = CandidatCertificat::findOrFail($id);

			// Récupérer l'utilisateur.
			$utilisateur = $requete->utilisateur;

			// Vérifier les autorisations.
			$porte = Gate::forUser($utilisateur);

			if($porte->denies('proprietaire-modele', $certificat)) {
				throw new UnauthorizedException();
			}

			// Récéupérer les entrées.
            $entrees = $requete->only(['fichier']);

			// Valider les entrées.
            $validateur = Validator::make($entrees, [
                'fichier' => "required|file|max:10240|mimes:doc,docx,pdf",
            ]);

			if ($validateur->fails()) {
                return parent::ReponseJsonEchecValidation(erreurs: $validateur->errors()->toArray());
            }

			// Sauvegarder les fichier.
            if ($requete->hasFile('fichier')) {
                $chemin = $requete->file('fichier')->store('candidats/certificats');

				// Récupérer le chemin de l'ancien fichier.
				$cheminAncien = $certificat->chemin;

				// Mettre à jour le champs dans l'instance.
				$certificat->update(['chemin' => $chemin]);

				// Supprimer l'ancien fichier.
				if(Storage::exists($cheminAncien))  {
					Storage::delete(storage_path($cheminAncien));
				}
			} else {
				return parent::ReponseJsonEchecValidation();
			}

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
     * Lister ses certificats.
     *
     *
     * @return JsonResponse $reponse
     */
    public function lister(Request $requete): JsonResponse
    {

        try {

            // Récupérer l'utilisateur.
            $utilisateur = $requete->utilisateur;

            // Récupérer les certficats.
            $certificats = CandidatCertificat::where('utilisateur', $utilisateur->id)
                ->orderBy('dateDebut', 'desc')->get();

            // Vérifier l'effectif.
            if ($certificats->isEmpty()) {
                return parent::ReponseJsonEchecRessource();
            }

            return parent::ReponseJsonSucces(donnees: $certificats->toArray());
        } catch (Exception $e) {
            return parent::ReponseJsonEchecServeur(exception: $e);
        }
    }

    /**
     * Mettre à jour les détails d'un certificat.
     */
    public function mettreAJour(Request $requete, string $id): JsonResponse
    {
        try {

            // Rechercher l'instance à mettre à jour.
            $certificat = CandidatCertificat::findOrFail($id);

            // Récupérer l'utlisateur.
            $utilisateur = $requete->utilisateur;

            // Initialiser la porte de vérification.
            $porte = Gate::forUser($utilisateur);

            if ($porte->denies('proprietaire-modele', $certificat)) {
                throw new UnauthorizedException();
            }

            // Récupérer les entrées.
            $entrees = Arr::only($requete->json()->all(), [
                'identifiant',
                'intitule',
                'domaineEtude',
                'organisation',
                'dateDebut',
                'dateFin',
                'dateDelivrance',
            ]);

            // Valider les entrées.
            $validateur = Validator::make($entrees, [
                'identifiant' => 'required_without_all:identifiant,intitule,domaineEtude,organistion,dateDebut,dateFin,dateDelivrance|string|max:64',
                'intitule' => 'required_without_all:identifiant,intitule,domaineEtude,organistion,dateDebut,dateFin,dateDelivrance|string|max:64',
                'domaineEtude' => 'required_without_all:identifiant,intitule,domaineEtude,organistion,dateDebut,dateFin,dateDelivrance|exists:emploi_domaine_etudes,id',
                'organisation' => 'required_without_all:identifiant,intitule,domaineEtude,organistion,dateDebut,dateFin,dateDelivrance|string|max:64',
                'dateDebut' => 'required_without_all:identifiant,intitule,domaineEtude,organistion,dateDebut,dateFin,dateDelivrance|date_format:Y-m-d H:i:s',
                'dateFin' => 'required_without_all:identifiant,intitule,domaineEtude,organistion,dateDebut,dateFin,dateDelivrance|date_format:Y-m-d H:i:s',
                'dateDelivrance' => 'required_without_all:identifiant,intitule,domaineEtude,organistion,dateDebut,dateFin,dateDelivrance|date_format:Y-m-d H:i:s',
            ]);

            if ($validateur->fails()) {
                return parent::ReponseJsonEchecValidation(erreurs: $validateur->errors()->toArray());
            }

            // Mettre à jour l'instance.
            $certificat->update($entrees);

            // Raffraichir.
            $certificat = CandidatCertificat::with(['domaineEtude'])->find($certificat->id);

            return parent::ReponseJsonSuccesMiseAJour(donnees: $certificat->toArray());
        } catch (ModelNotFoundException $e) {
            return parent::ReponseJsonEchecNonTrouve();
        } catch (UnauthorizedException $e) {
            return parent::ReponseJsonEchecAutorisation();
        } catch (Exception $e) {
            return parent::ReponseJsonEchecServeur(exception: $e);
        }
    }

    /**
     * Supprimer une certificat.
     */
    public function supprimer(Request $requete, string $id): JsonResponse
    {
        try {

            // Recherhcer l'instance.
            $certificat = CandidatCertificat::findOrFail($id);

            // Récupérer l'utlisateur.
            $utilisateur = $requete->utilisateur;

            // Initialiser la porte de vérification.
            $porte = Gate::forUser($utilisateur);

            if ($porte->denies('proprietaire-modele', $certificat)) {
                throw new UnauthorizedException();
            }

            // Supprimer l'instance.
            $certificat->delete();

            return parent::ReponseJsonSuccesSuppression();
        } catch (ModelNotFoundException $e) {
            return parent::ReponseJsonEchecNonTrouve();
        } catch (ModelNotFoundException $e) {
            return parent::ReponseJsonEchecAutorisation();
        } catch (Exception $e) {
            return parent::ReponseJsonEchecServeur(exception: $e);
        }
    }
}
