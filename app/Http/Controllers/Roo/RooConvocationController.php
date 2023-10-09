<?php

namespace App\Http\Controllers\Roo;

use App\Http\Controllers\Controller;
use App\Models\Emploi\CandidatureConvocation;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;

class RooConvocationController extends Controller
{
    /**
     * Créer une nouvelle convocation.
     */
    public function creer(Request $requete): JsonResponse
    {
        try {

            // Récupération des entrées.
            $entrees = Arr::only($requete->json()->all(), [
                'candidature',
                'objet',
                'lieu',
                'pays',
                'adresse',
                'date',
                'consignes',
                'indicatifTelephonique',
                'telephone',
            ]);

            // Valider les entrées.
            $validateur = Validator::make($entrees, [
                'candidature' => 'required|exists:emploi_candidatures,id',
                'objet' => 'required|string|max:64',
                'lieu' => 'required|string|max:64',
                'pays' => 'required|exists:systeme_pays,id',
                'adresse' => 'required|string|max:255',
                'date' => 'required|date_format:Y-m-d H:i:s',
                'consignes' => 'nullable|string|max:255',
                'indicatifTelephonique' => 'nullable|int|min:1|max:196',
                'telephone' => 'nullable|string|min:8|max:12|regex:/^\d+$/',
            ]);

            // Retourner un réponse d'échec des validations.
            if ($validateur->fails()) {
                return parent::ReponseJsonEchecValidation(erreurs: $validateur->errors()->toArray());
            }

            // Récupérer l'utilisateur.
            $utilisateur = $requete->utilisateur;

            // Ajouter l'utilisateur comme auteurCreation.
            $entrees['auteurCreation'] = $utilisateur->id;

            // Créer une nouvelle convocation.
            $convocation = CandidatureConvocation::create($entrees);

            // Récupérer l'instances et ses rélations.
            $convocation = CandidatureConvocation::with([
                'candidature' => [
                    'utilisateur' => [
                        'personne' => [
                            'paysNaissance',
                            'paysResidence',
                        ],
                    ],
                ],
            ])->find($convocation->id);

            // Enregistrer l'activité.
            parent::enregistrerCreation($utilisateur, $entrees, CandidatureConvocation::class, $convocation->id);

            return parent::ReponseJsonSuccesCreation(donnees: $convocation->toArray());
        } catch (Exception $e) {
            return parent::ReponseJsonEchecServeur(exception: $e);
        }
    }

    /**
     * Voir une convocation.
     */
    public function voir(string $id): JsonResponse
    {
        try {

            // Rechercher l'instance et ses rélations.
            $convocation = CandidatureConvocation::with([
                'candidature' => [
                    'utilisateur' => [
                        'personne' => [
                            'paysNaissance',
                            'paysResidence',
                        ],
                    ],
                ],
                'pays',
                'auteurCreation' => [
                    'personne' => [
                        'paysNaissance',
                        'paysResidence',
                    ],
                ],
                'auteurMiseAJour' => [
                    'personne' => [
                        'paysNaissance',
                        'paysResidence',
                    ],
                ],
            ])->findOrFail($id);

            return parent::ReponseJsonSuccesVisualisation(donnees: $convocation->toArray());
        } catch (ModelNotFoundException $e) {
            return parent::ReponseJsonEchecNonTrouve();
        } catch (Exception $e) {
            return parent::ReponseJsonEchecServeur(exception: $e);
        }
    }

    /**
     * Lister les convations.
     *
     *
     * @return JsonResponse $reponse
     */
    public function lister(string $id): JsonResponse
    {
        try {

            // Rechercher les instances de convocations pour l'id de l'offre de l'offre fourni.
            $convocations = CandidatureConvocation::join('emploi_candidatures', 'emploi_convocations.candidature', '=', 'emploi_candidatures.id')
                ->where('emploi_candidatures.offre', $id)
                ->orderBy('date')
                ->get([
                    'emploi_convocations.id',
                    'emploi_convocations.candidature',
                    'emploi_convocations.objet',
                    'emploi_convocations.lieu',
                    'emploi_convocations.pays',
                    'emploi_convocations.date',
                    'emploi_convocations.auteurCreation',
                    'emploi_convocations.auteurMiseAJour',
                ]);

            // Vérifier l'effectif des instances.
            if ($convocations->isEmpty()) {
                return parent::ReponseJsonEchecRessource();
            }

            // Rétourner la liste des convocations.
            return parent::ReponseJsonSucces(donnees: $convocations->toArray());
        } catch (ModelNotFoundException $e) {
            return parent::ReponseJsonEchecNonTrouve();
        } catch (Exception $e) {
            return parent::ReponseJsonEchecServeur(exception: $e);
        }
    }

    /**
     * Mettre à jour une convocation.
     *
     *
     *
     * @return JsonResponse $reponse
     */
    public function mettreAJour(Request $requete, string $id): JsonResponse
    {
        try {

            // Rechercher l'instance à mettre à jour.
            $convocation = CandidatureConvocation::findOrFail($id);

            // Récupérer les entrées.
            $entrees = Arr::only($requete->json()->all(), [
                'objet',
                'lieu',
                'pays',
                'adresse',
                'date',
                'consignes',
                'indicatifTelephonique',
                'telephone',
            ]);

            // Valider les entrées.
            $validateur = Validator::make($requete->all(), [

                'objet' => 'required_without_all:candidature,objet,lieu,pays,adresse,date,consignes,indicatifTelephonique,telephone|string|max:64',
                'lieu' => 'required_without_all:candidature,objet,lieu,pays,adresse,date,consignes,indicatifTelephonique,telephone|string|max:64',
                'pays' => 'required_without_all:candidature,objet,lieu,pays,adresse,date,consignes,indicatifTelephonique,telephone|exists:systeme_pays,id',
                'adresse' => 'required_without_all:candidature,objet,lieu,pays,adresse,date,consignes,indicatifTelephonique,telephone|string|max:255',
                'date' => 'required_without_all:candidature,objet,lieu,pays,adresse,date,consignes,indicatifTelephonique,telephone|date_format:Y-m-d H:i:s',
                'consignes' => 'required_without_all:candidature,objet,lieu,pays,adresse,date,consignes,indicatifTelephonique,telephone|string|max:255',
                'indicatifTelephonique' => 'required_without_all:candidature,objet,lieu,pays,adresse,date,consignes,indicatifTelephonique,telephone|int|min:1|max:999',
                'telephone' => 'required_without_all:candidature,objet,lieu,pays,adresse,date,consignes,indicatifTelephonique,telephone|min:8|max:12|regex:/^\d+$/',
            ]);

            // Retourner un réponse d'échec des validations.
            if ($validateur->fails()) {
                return parent::ReponseJsonEchecValidation(erreurs: $validateur->errors()->toArray());
            }

            // Récupérer l'utilisateur.
            $utilisateur = $requete->utilisateur;

            // Ajouter l'utilisateur auteurMiseAJour
            $entrees['auteurMiseAJour'] = $utilisateur->id;

            // Mettre à jour de la convocation.
            $convocation->update($entrees);

            // Récupérer l'instance et ses rélations.
            $convocation = CandidatureConvocation::with([
                'candidature' => [
                    'utilisateur' => [
                        'personne' => [
                            'paysNaissance',
                            'paysResidence',
                        ],
                    ],
                ],
                'pays',
                'auteurCreation' => [
                    'personne' => [
                        'paysNaissance',
                        'paysResidence',
                    ],
                ],
                'auteurMiseAJour' => [
                    'personne' => [
                        'paysNaissance',
                        'paysResidence',
                    ],
                ],
            ])->find($id);

            // Enregistrer l'activité.
            parent::enregistrerMiseAJour($utilisateur, $entrees, CandidatureConvocation::class, $id);

            // Retourner une reponse de succès.
            return parent::ReponseJsonSuccesMiseAJour(donnees: $convocation->toArray());

        } catch (ModelNotFoundException $e) {
            return parent::ReponseJsonEchecNonTrouve();
        } catch (Exception $e) {
            return parent::ReponseJsonEchecServeur(exception: $e);
        }
    }

    /**
     * Supprimer une convocation.
     */
    public function supprimer(Request $requete, string $id): JsonResponse
    {
        try {

            // Rechercher l'instance à supprimer.
            $convocation = CandidatureConvocation::findOrFail($id);

            // Suppression de la convocation.
            $convocation->delete();

            // Récupérer l'utilisateur.
            $utilisateur = $requete->utilisateur;

            // Enregistrer l'activité.
            parent::enregistrerSuppression($utilisateur, CandidatureConvocation::class, $id);

            return parent::ReponseJsonSuccesSuppression();
        } catch (ModelNotFoundException $e) {
            return parent::ReponseJsonEchecNonTrouve();
        } catch (Exception $e) {
            return parent::ReponseJsonEchecServeur(exception: $e);
        }
    }
}
