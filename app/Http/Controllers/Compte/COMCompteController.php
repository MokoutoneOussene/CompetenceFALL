<?php

namespace App\Http\Controllers\Compte;

use App\Http\Controllers\Controller;
use App\Jobs\Systeme\Utilisateur\EmailBienvenuJob;
use App\Jobs\Systeme\Utilisateur\PhotoProfilJob;
use App\Models\Systeme\Organisation;
use App\Models\Systeme\Personne;
use App\Models\Systeme\Session;
use App\Models\Systeme\Utilisateur;
use App\Rules\Systeme\Organisation\DenominationUniqueRule;
use App\Rules\Systeme\Organisation\IdentifiantUniqueRule;
use App\Rules\Systeme\Utilisateur\TelephoneExisteRule;
use App\Rules\Systeme\Utilisateur\TelephoneUniqueRule;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class COMCompteController extends Controller
{
    /**
     * Créer un compte utilisateur.
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
                'nomUtilisateur',
                'motDePasse',
                'email',
                'indicatifTelephonique',
                'telephone',
                'boitePostale',
                'siteWeb',
                'description',
                'typeUtilisateur'
            ]);

			// Valider les entrées.
            $validateur = Validator::make($entrees, [
                'nomUtilisateur' => [
					"required",
					"alpha_dash",
					"min:4",
					"max:64",
					"unique:systeme_utilisateurs,nomUtilisateur"
				],
                'motDePasse' => [
					"required",
					"string",
					"min:8",
					"max:32",
					"regex:/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d).+$/"
				],
                'email' => [
					"required",
					"email",
					"lowercase",
					"max:255",
					"unique:systeme_utilisateurs,email"
				],
                'indicatifTelephonique' => [
					"required_with:telephone",
					"prohibited_if:telephone,null",
					"int",
					"min:1",
					"max:999",
					"exists:systeme_indicatif_telephoniques,valeur"
				],
                'telephone' => [
					"nullable",
					"string",
					"min:8",
					"max:12",
					"regex:/^\d+$/",
					new TelephoneUniqueRule
				],
                "boitePostale" => [
					"nullable",
					"string",
					"max:255",
					"regex:/^\d{2} BP \d{4} \d{5} [\p{L}\s\-]+,\s+[\p{L}\s\-]+$/u",
                    "unique:systeme_utilisateurs,boitePostale"
				],
                'siteWeb' => [
					"nullable",
					"url",
					"max:255",
					"unique:systeme_utilisateurs,siteWeb"
				],
                'description' => [
					"nullable",
					"string",
					"max:255"
				],
                'typeUtilisateur' => [
					"nullable",
					"in:personne,organisation"
				]
            ]);

            if ($validateur->fails()) {
                return parent::ReponseJsonEchecValidation(erreurs: $validateur->errors()->toArray());
            }

			// Créer l'instance.
            $utilisateur = Utilisateur::create($entrees);

            // Masquer les informations sensibles de ce modèle.
            $utilisateur = $utilisateur->makeHidden([
                'cheminPhotoProfil',
                'cheminBanniere',
                'motDePasse',
                'statutDoubleAuthentification',
                'dateVerificationEmail',
                'otp',
                'dateExpirationOtp',
                'dateProchaineTentativeOtp',
                'dateVerificationTelephone',
                'statutNotificationSms',
                'dateDerniereConnexion',
            ]);

            // Envoyer email de bienvenu en différé
            EmailBienvenuJob::dispatch($utilisateur);

            return parent::ReponseJsonSucces(donnees: $utilisateur->toArray());
        } catch (Exception $e) {
            return parent::ReponseJsonEchecServeur(exception: $e);
        }
    }

    /**
     * Se connecter à un compte utilisateur.
     *
     *
     * @return JsonResponse $reponse
     */
    public function connecter(Request $requete): JsonResponse
    {
        try {

            // Valider les entrées.
            $entrees = Arr::only($requete->json()->all(), [
                'email',
                'indicatifTelephonique',
                'telephone',
                'motDePasse',
                'otp',
            ]);

            $validateur = Validator::make($entrees, [

                'email' => 'required_without_all:telephone|email|max:255|exists:systeme_utilisateurs,email',
                'indicatifTelephonique' => 'required_with:telephone|prohibited_if:telephone,null|'.
                    'exists:systeme_indicatif_telephoniques,valeur',
                'telephone' => ['required_without_all:email', "regex:/^\d+$/", 'min:8', 'max:12', new TelephoneExisteRule],
                'motDePasse' => 'required|min:8|max:32',
                'otp' => "nullable|regex:/^\d+$/|size:6",
            ]);

            // Rétouner une réponse d'échec lorsque les validations échouent.
            if ($validateur->fails()) {
                return parent::ReponseJsonEchecValidation();
            }

            // Récupérer l'utilisateur.
            if (isset($entrees['email'])) {
                $utilisateur = Utilisateur::with(['blocages'])->where('email', $entrees['email'])->first();

            } else {

                $utilisateur = Utilisateur::with(['blocages'])->where([
                    ['telephone', $entrees['telephone']],
                    ['indicatifTelephonique', $entrees['indicatifTelephonique']],
                ])->first();
            }

            // Vérifier l'état de blocage de l'utilisateur.
            if ($utilisateur->blocages()->where('statutActivation', true)->count()) {

                $blocagesAdministrateurs = $utilisateur->blocages()->where([
                    ['statutActivation', true],
                    ['statutDeblocable', false],
                ])->get(['id']);

                if ($blocagesAdministrateurs->count()) {

                    $utilisateur->sessions()->delete();

                    return response()->json([

                        'message' => "Compte utilisateur bloqué par l'administration.",
                        'erreurs' => [],

                    ], Response::HTTP_UNAUTHORIZED);
                }

                $blocageStandard = $utilisateur->blocages()->where([
                    ['statutActivation', true],
                    ['statutDeblocable', true],
                ])->get();

                if ($blocageStandard->count()) {

                    $utilisateur->sessions()->delete();

                    return response()->json([

                        'message' => 'Compte utilisateur bloqué.',
                        'erreurs' => [
                            'compteBloque' => 'Nombre de tentatives infructueuses élévé.',
                            'deblocage' => 'Vous pouvez débloquer votre compte en confirmant votre identité.',
                        ],

                    ], Response::HTTP_UNAUTHORIZED);
                }
            }

            // Vérifier le mot de passe.
            if ($utilisateur->verifierMotDePasse($entrees['motDePasse']) == false) {

                $utilisateur->connexions()->create([
                    'ipv4' => $requete->getClientIp(),
                    'agent' => $requete->userAgent(),
                ]);

                if ($utilisateur->connexions()->count() >= 3) {

                    $utilisateur->blocages()->create(['motif' => 'Trop de tentatives infructueuses de connexion.']);

                }

                return response()->json([
                    'statut' => 'Echec',
                    'message' => 'Le mot de passe est incorrect.',
                    'erreurs' => [
                        'blocage' => 'Il vous reste '.(3 - $utilisateur->connexions()->count()).' tentative(s) avant le blocage.',
                    ],
                ], Response::HTTP_UNAUTHORIZED);
            }

            // Vérifier si la double authentification est activée.
            if ($utilisateur->statutDoubleAuthentification == true) {

                if (isset($entrees['otp'])) {

                    if ($utilisateur->verifierOtp($entrees['otp']) == false) {

                        $utilisateur->connexions()->create([
                            'ipv4' => $requete->getClientIp(),
                            'agent' => $requete->userAgent(),
                        ]);

                        if ($utilisateur->connexions()->count() >= 3) {

                            $utilisateur->blocages()->create(['motif' => 'Trop de tentatives infructueuses de connexion.']);
                        }

                        return response()->json([

                            'message' => 'La double authentification a échoué.',
                            'erreurs' => [
                                'otp' => 'Le code a usage unique fourni est invalide.',
                                'blocage' => 'Il vous reste '.(3 - $utilisateur->connexions()->count()).' tentative(s) avant le blocage.',
                            ],
                        ], Response::HTTP_UNAUTHORIZED);
                    }
                } else {

                    return response()->json([
                        'message' => 'Un code à usage unique est requis pour se connecter à ce compte.',
                    ], Response::HTTP_ACCEPTED);
                }
            }

            $session = Session::creerSession($utilisateur, $requete);

            return parent::ReponseJsonSucces(donnees: $session->toArray());
        } catch (Exception $e) {
            return parent::ReponseJsonEchecServeur(exception: $e);
        }
    }

    /**
     * Ajouter des informations personnelles.
     *
     *
     * @return JsonResponse $reponse
     */
    public function ajouterPersonne(Request $requete): JsonResponse
    {

        try {

            // Valider les entrées.
            $entrees = Arr::only($requete->json()->all(), [
                'nom',
                'prenoms',
                'genre',
                'dateNaissance',
                'lieuNaissance',
                'paysNaissance',
                'lieuResidence',
                'paysResidence',
                'nationalites',
            ]);

            $validateur = Validator::make($entrees, [

                'nom' => 'required|alpha_dash|max:64',
                'prenoms' => 'required|alpha_dash|max:128',
                'genre' => 'required|in:masculin,feminin,non precise',
                'dateNaissance' => 'required|date_format:Y-m-d H:i:s|after_or_equal:1923-01-01 00:00:00'.
                    'before_or_equal:2013-01-01 00:00:00',
                'lieuNaissance' => 'required|string|max:64',
                'paysNaissance' => 'required|uuid|exists:systeme_pays,id',
                'lieuResidence' => 'required|string|max:64',
                'paysResidence' => 'required|uuid|exists:systeme_pays,id',
                'nationalites' => 'nullable|string|max:128',
            ]);

            // Rétouner une réponse d'échec lorsque les validations échouent.
            if ($validateur->fails()) {
                return parent::ReponseJsonEchecValidation(erreurs: $validateur->errors()->toArray());
            }

            // Récupérer l'utilisateur.
            $utilisateur = $requete->utilisateur;

            // Vérifier si l'utilisateur ne possède pas déjà des information personnelles.
            if ($utilisateur->personne()->count()) {
                return parent::ReponseJsonEchecAutorisation();
            }

            // Persister les informations personnelles.
            $entrees['nom'] = ucfirst($entrees['nom']);
            $entrees['prenoms'] = ucfirst($entrees['prenoms']);
            $entrees['lieuNaissance'] = ucfirst($entrees['lieuNaissance']);
            $entrees['lieuResidence'] = ucfirst($entrees['lieuResidence']);
            $entrees['utilisateur'] = $utilisateur->id;
            $personne = Personne::create($entrees);

            $personne = Personne::with([
                'utilisateur',
                'paysNaissance',
                'paysResidence',
            ])->find($personne->id);

            return parent::ReponseJsonSucces(donnees: $personne->toArray());
        } catch (Exception $e) {
            return parent::ReponseJsonEchecServeur(exception: $e);
        }
    }

    /**
     * Ajouter des informations d'entreprise (organisation).
     *
     *
     * @return JsonResponse $reponse
     */
    public function ajouterOrganisation(Request $requete): JsonResponse
    {

        try {

            // Valider les entrées.
            $entrees = Arr::only($requete->json()->all(), [
                'identifiant',
                'denomination',
                'statutJuridique',
                'domaine',
                'dateFondation',
                'capitalSocial',
                'nombreEmploye',
                'lieuSiege',
                'paysSiege',
            ]);

            $validateur = Validator::make($entrees, [
                'identifiant' => ['nullable', 'string', 'max:64', new IdentifiantUniqueRule],
                'denomination' => ['required', 'string', 'max:64', new DenominationUniqueRule],
                'statutJuridique' => 'required|string|max:64',
                'domaine' => 'required|string|max:64',
                'dateFondation' => 'required|date_format:Y-m-d H:i:s',
                'capitalSocial' => 'required|int|min:0',
                'nombreEmploye' => 'required|int|min:0',
                'lieuSiege' => 'required|string|max:64',
                'paysSiege' => 'required|uuid|exists:systeme_pays,id',
            ]);

            // Rétouner une réponse d'échec lorsque les validations échouent.
            if ($validateur->fails()) {
                return parent::ReponseJsonEchecValidation(erreurs: $validateur->errors()->toArray());
            }

            // Récupérer l'utilisateur.
            $utilisateur = $requete->utilisateur;

            // Vérifier si l'utilisateur ne possède pas déjà des information personnelles.
            if ($utilisateur->organisation()->count()) {
                return parent::ReponseJsonEchecAutorisation();
            }

            // Persister les informations personnelles.
            $entrees['denomination'] = ucfirst($entrees['denomination']);
            $entrees['domaine'] = ucfirst($entrees['domaine']);
            $entrees['lieuSiege'] = ucfirst($entrees['lieuSiege']);
            $entrees['utilisateur'] = $utilisateur->id;
            $organisation = Organisation::create($entrees);

            $organisation = Organisation::with([
                'utilisateur',
                'paysSiege',
            ])->find($organisation->id);

            return parent::ReponseJsonSucces(donnees: $organisation->toArray());
        } catch (Exception $e) {
            return parent::ReponseJsonEchecServeur(exception: $e);
        }
    }

    /**
     * Demander à recevoir un code à usage unique.
     *
     *
     * @return JsonResponse $reponse
     */
    public function demanderOtp(Request $requete): JsonResponse
    {

        try {

            // Valider les entrées.
            $entrees = Arr::only($requete->json()->all(), [
                'email',
                'indicatifTelephonique',
                'telephone',
            ]);

            $validateur = Validator::make($entrees, [
                'email' => 'required_without_all:telephone|email|max:255|exists:systeme_utilisateurs,email',
                'indicatifTelephonique' => 'required_with:telephone|prohibited_if:telephone,null|'.
                    'int|min:1|exists:systeme_indicatif_telephoniques,valeur',
                'telephone' => ['required_without_all:email', 'string', 'min:8', 'max:12', new TelephoneExisteRule],
            ]);

            // Rétouner une réponse d'échec lorsque les validations échouent.
            if ($validateur->fails()) {
                return parent::ReponseJsonEchecValidation(erreurs: $validateur->errors()->toArray());
            }

            // Récupérer l'utilisateur.
            if (isset($entrees['email'])) {
                $utilisateur = Utilisateur::where('email', $entrees['email'])->first();
            } else {

                $utilisateur = Utilisateur::where('telephone', $entrees['telephone'])
                    ->where('indicatifTelephonique', $entrees['indicatifTelephonique'])
                    ->first();
            }

            // Vérifier si l'utilisateur peut demander un  code à usage unique.
            if (Carbon::parse($utilisateur->dateProchaineTentativeOtp)->gte(Carbon::now())) {
                return parent::ReponseJsonEchecAutorisation();
            }

            // Persister un code à usage unique pour l'utilisateur.
            $utilisateur->genererOtp();
            $utilisateur->save();
            $utilisateur->refresh();

            // Envoyer un code à usage unique par email pour vérification.
            EmailBienvenuJob::dispatch($utilisateur);

            // Retourner une réponse de succès.
            return parent::ReponseJsonSucces(donnees: [
                'dateEpirationOtp' => $utilisateur->dateExpirationOtp,
            ]);
        } catch (Exception $e) {
            return parent::ReponseJsonEchecServeur(exception: $e);
        }
    }

    /**
     * Voir son profil utilisateur.
     *
     *
     * @return JsonResponse $reponse
     */
    public function voir(Request $requete): JsonResponse
    {

        try {

            // Récupérer l'utilisateur
            $utilisateur = $requete->utilisateur;

            $donnees = ['utilisateur' => $utilisateur->toArray()];

            if ($utilisateur->typeUtilisateur == 'personne') {

                $personne = $utilisateur->personne()->first();

                if ($personne) {

                    $personne = $personne->makeHidden([
                        'id',
                        'utilisateur',
                        'auteurCreation',
                        'auteurMiseAJour',
                    ]);

                    $donnees['personne'] = $personne->toArray();
                }
            } else {

                $organisation = $utilisateur->organisation()->first();

                if ($organisation) {

                    $organisation = $organisation->makeHidden([
                        'id',
                        'utilisateur',
                        'auteurCreation',
                        'auteurMiseAJour',
                    ]);

                    $donnees['organisation'] = $organisation->toArray();
                }
            }

            return response()->json([
                'message' => 'Un compte utilisateur a été récupéré avec succès.',
                'donnees' => $donnees,
            ], Response::HTTP_OK);
        } catch (Exception $e) {

            Log::error($e);

            return response()->json([
                'message' => 'Le serveur a rencontré des erreurs lors du traitement de la requête.',
                'erreurs' => env('APP_DEBUG') == true ? [
                    'code' => $e->getCode(),
                    'message' => $e->getMessage(),
                    'trace' => $e->getTrace(),
                ] : [],
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Télécharger sa photo de profil.
     *
     *
     * @return Response $reponse
     */
    public function telechargerPhotoProfil(Request $requete): Response
    {

        try {

            // Récupérer l'utilisateur
            $utilisateur = $requete->utilisateur;

            // Vérifier l'existence du fichier
            if (Storage::exists($utilisateur->cheminPhotoProfil) == false) {

                return response()->json([
                    'message' => 'Le fichier est introuvable.',
                ], Response::HTTP_NOT_FOUND);
            }

            return Storage::download($utilisateur->cheminPhotoProfil);
        } catch (Exception $e) {

            Log::error($e);

            return response()->json([
                'message' => 'Le serveur a rencontré des erreurs lors du traitement de la requête.',
                'erreurs' => /*env("APP_DEBUG") == TRUE ?*/ [
                    'code' => $e->getCode(),
                    'message' => $e->getMessage(),
                    'trace' => $e->getTrace(),
                ], /*: []*/
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Voir ses sessions de connexion.
     *
     *
     * @return JsonResponse $reponse
     */
    public function voirSessions(Request $requete): JsonResponse
    {

        try {

            // Récupérer les sessions.
            $utilisateur = $requete->utilisateur;

            $sessions = $utilisateur->sessions()->get();

            foreach ($sessions as $session) {
                if ($session->verifierJeton() == false) {
                    $session->delete();
                }
            }

            // Récupérer les sessions valides.
            $session = Session::where('utilisateur', $utilisateur->id)->get([
                'id',
                'agent',
                'ipv4',
                'created_at',
                'dateExpiration',
            ]);

            return response()->json([
                'message' => 'Les sessions actives ont été récupérées avec succès.',
                'donnees' => ['sessions' => $sessions->toArray()],
            ], Response::HTTP_OK);

        } catch (Exception $e) {
            Log::error($e);

            return response()->json([
                'message' => 'Le serveur a rencontré des erreurs lors du traitement de la requête.',
                'erreurs' => env('APP_DEBUG') == true ? [
                    'code' => $e->getCode(),
                    'message' => $e->getMessage(),
                    'trace' => $e->getTrace(),
                ] : [],
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Mettre à jour son compte utilisateur.
     *
     *
     * @return JsonResponse $reponse
     */
    public function mettreAJour(Request $requete): JsonResponse
    {

        try {

            // Valider les entrées.
            $entrees = Arr::only($requete->json()->all(), [
                'nomUtilisateur',
                'email',
                'indicatifTelephonique',
                'telephone',
                'boitePostale',
                'siteWeb',
                'description',
            ]);

            $validateur = Validator::make($entrees, [

                'nomUtilisateur' => ['required_without_all:email, telephone, boitePostale, siteWeb, description',
                    'alpha_dash', 'lowercase', 'min:4', 'max:32', 'unique:systeme_utilisateurs,nomUtilisateur'],
                'email' => 'required_without_all:nomUtilisateur, indicatifTelephonique, telephone, boitePostale, siteWeb, description|'.
                    'email|max:255|unique:systeme_utilisateurs,email',
                'indicatifTelephonique' => 'required_with:telephone|prohibited_if:telephone,null|'.
                    "regex:/^\d+$/|max:999|exists:systeme_indicatif_telephoniques,valeur",
                'telephone' => ['required_without_all:nomUtilisateur, email, boitePostale, siteWeb, description',
                    "regex:/^\d+$/", 'min:8', 'max:12', new TelephoneUniqueRule],
                'boitePostale' => 'required_without_all:nomUtilisateur, email, telephone, siteWeb, description|'.
                    "regex:/^\d{2} BP \d{4} \d{5} [\p{L}\s\-]+,\s+[\p{L}\s\-]+$/u|max:255|unique:systeme_utilisateurs,boitePostale",
                'siteWeb' => 'required_without_all:nomUtilisateur, email, telephone, boitePostale, description|'.
                    'url|max:255|unique:systeme_utilisateurs,siteWeb',
                'description' => 'required_without_all:nomUtilisateur, email, telephone, boitePostale, siteWeb|'.
                    'string|max:255',
            ]);

            // Vérifier l'état des validations.
            if ($validateur->fails()) {
                return response()->json([
                    'message' => 'Des erreurs dans la validation des données sont survenues.',
                    'erreurs' => $validateur->errors()->toArray(),
                ], Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            $utilisateur = $requete->utilisateur;

            // La double authentification doit être désactivée lorsque le téléphone et l'email changent.
            if (isset($entrees['email'])) {

                $entrees['dateVerificationEmail'] = null;

                if (isset($entrees['telephone'])) {
                    $entrees['dateVerificationTelephone'] = null;
                }
            }

            $utilisateur->update($entrees);
            $utilisateur->refresh();

            return response()->json([
                'message' => 'Le compte utilisateur a été mis à jour avec succès.',
                'donnees' => ['utilisateur' => $utilisateur->toArray()],
            ], Response::HTTP_OK);

        } catch (Exception $e) {
            Log::error($e);

            return response()->json([
                'message' => 'Le serveur a rencontré des erreurs lors du traitement de la requête.',
                'erreurs' => env('APP_DEBUG') == true ? [
                    'code' => $e->getCode(),
                    'message' => $e->getMessage(),
                    'trace' => $e->getTrace(),
                ] : [],
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Mettre à jour à photo de profil.
     *
     *
     * @return JsonResponse $reponse
     */
    public function mettre(Request $requete): JsonResponse
    {

        try {

            // Valider les entrées.
            $entrees = $requete->only(['photoProfil']);

            $validateur = Validator::make($entrees, [
                'photoProfil' => 'required|file|max:10240|mimes:jpeg,jpg,png,webp,avif',
            ]);

            // Vérifier l'état des validations.
            if ($validateur->fails()) {
                return response()->json([
                    'message' => 'Des erreurs sont survenues lors de la validation des données.',
                    'erreurs' => $validateur->errors()->toArray(),
                ], Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            if ($requete->hasFile('photoProfil')) {

                $entrees['cheminPhotoProfil'] = $requete->file('photoProfil')->store('utilisateurs/photoProfils');

                PhotoProfilJob::dispatch(storage_path('app/'.$entrees['cheminPhotoProfil']));
            }

            // Récupérer l'utilisateur.
            $utilisateur = $requete->utilisateur;
            $cheminAnciennePhotoProfil = $utilisateur->cheminPhotoProfil;

            $utilisateur->update($entrees); // Mettre à jour l'utilisateur.

            // Supprimer l'ancienne photo de profil.
            if ($cheminAnciennePhotoProfil != 'utilisateurs/photoProfils/defaut.png') {
                Storage::delete($cheminAnciennePhotoProfil);
            }

            return response()->json([
                'message' => 'La photo de profil a été mise à jour avec succès.',
            ], Response::HTTP_OK);
        } catch (Exception $e) {

            Log::error($e);

            return response()->json([
                'message' => 'Le serveur a rencontré des erreurs lors du traitement de la requête.',
                'erreurs' => env('APP_DEBUG') == true ? [
                    'code' => $e->getCode(),
                    'message' => $e->getMessage(),
                    'trace' => $e->getTrace(),
                ] : [],
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Mettre à jour ses informations personnelles.
     *
     *
     * @return JsonResponse $reponse
     */
    public function mettreAJourPersonne(Request $requete): JsonResponse
    {

        try {

            // Récupérer les entrées
            $entrees = Arr::only($requete->json()->all(), [

                'nom',
                'prenoms',
                'genre',
                'dateNaissance',
                'lieuNaissance',
                'paysNaissance',
                'lieuResidence',
                'paysResidence',
                'nationalites',
            ]);

            $regles = [

                'nom' => 'required_without_all:prenoms,genre,dateNaissance,lieuNaissance,paysNaissance,lieuResidence,paysResidence,nationalites|'.
                    'string|max:64',
                'prenoms' => 'required_without_all:nom,genre,dateNaissance,lieuNaissance,paysNaissance,lieuResidence,paysResidence,nationalites|'.
                    'string|max:128',
                'genre' => 'required_without_all:nom,prenoms,dateNaissance,lieuNaissance,paysNaissance,lieuResidence,paysResidence,nationalites|'.
                    'in:masculin,feminin,non precise',
                'dateNaissance' => 'required_without_all:nom,prenoms,genre,lieuNaissance,paysNaissance,lieuResidence,paysResidence,nationalites|'.
                    'date_format:Y-m-d H:i:s|after_or_equal:1923-01-01 00:00:00|before_or_equal:2013-01-01 00:00:00',
                'lieuNaissance' => 'required_without_all:nom,prenoms,genre,dateNaissance,paysNaissance,lieuResidence,paysResidence,nationalites|'.
                    'string|max:64',
                'paysNaissance' => 'required_without_all:nom,prenoms,genre,dateNaissance,lieuNaissance,lieuResidence,paysResidence,nationalites|'.
                    'uuid|exists:systeme_pays,id',
                'lieuResidence' => 'required_without_all:nom,prenoms,genre,dateNaissance,lieuNaissance,paysNaissance,paysResidence,nationalites|'.
                    'string|max:64',
                'paysResidence' => 'required_without_all:nom,prenoms,genre,dateNaissance,lieuNaissance,paysNaissance,lieuResidence,nationalites|'.
                    'uuid|exists:systeme_pays,id',
                'nationalites' => 'required_without_all:nom,prenoms,genre,dateNaissance,lieuNaissance,paysNaissance,lieuResidence,paysResidence|'.
                    'string|max:128',
            ];

            $validateur = Validator::make($entrees, $regles);

            // Rétouner une réponse d'échec lorsque les validations échouent.
            if ($validateur->fails()) {

                // Retourner une réponse de succès.
                return response()->json([
                    'message' => 'Des erreurs erreurs sont survenues lors de la validation des entrées.',
                    'erreurs' => $validateur->errors()->toArray(),
                ], Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            // Récupérer l'utilisateur.
            $utilisateur = $requete->utilisateur;

            // Vérifier si l'utilisateur est une personne.
            if ($utilisateur->typeUtilisateur != 'personne') {

                // Retourner une réponse de succès.
                return response()->json([
                    'message' => 'Des erreurs erreurs sont survenues lors de la validation des entrées.',
                    'erreurs' => [
                        'typeUtilisateur' => 'Cet utilisateur est une organisation.',
                    ],
                ], Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            // Vérifier si l'utilisateur ne possède pas déjà des information personnelles.
            if (! $utilisateur->personne()->count()) {

                // Retourner une réponse de succès.
                return response()->json([
                    'message' => 'Des erreurs erreurs sont survenues lors de la validation des entrées.',
                    'erreurs' => [
                        'personne' => "Cet utilisateur ne possède pas d'informations personnelles.",
                    ],
                ], Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            // Persister les informations personnelles.
            if (isset($entrees['nom'])) {
                $entrees['nom'] = ucfirst($entrees['nom']);
            }
            if (isset($entrees['prenoms'])) {
                $entrees['prenoms'] = ucfirst($entrees['prenoms']);
            }
            if (isset($entrees['lieuNaissance'])) {
                $entrees['lieuNaissance'] = ucfirst($entrees['lieuNaissance']);
            }
            if (isset($entrees['lieuResidence'])) {
                $entrees['lieuResidence'] = ucfirst($entrees['lieuResidence']);
            }
            if (isset($entrees['nationalites'])) {
                $entrees['nationalites'] = ucfirst($entrees['nationalites']);
            }
            $personne = $utilisateur->personne()->first();
            $personne->update($entrees);
            $personne->refresh();

            $personne = $personne->makeHidden([
                'id',
                'utilisateur',
                'auteurCreation',
                'auteurMiseAJour',
            ]);

            // Retourner une réponse de succès.
            return response()->json([
                'message' => 'Les informations personnelles ont été mises à jour avec succès.',
                'donnees' => ['personne' => $personne->toArray()],
            ], Response::HTTP_OK);

        } catch (Exception $e) {
            Log::error($e);

            return response()->json([
                'message' => 'Le serveur a rencontré des erreurs lors du traitement de la requête.',
                'erreurs' => env('APP_DEBUG') == true ? [
                    'code' => $e->getCode(),
                    'message' => $e->getMessage(),
                    'trace' => $e->getTrace(),
                ] : [],
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Mettre à jour ses informations d'organisation.
     *
     *
     * @return JsonResponse $reponse
     */
    public function mettreAJourOrganisation(Request $requete): JsonResponse
    {

        try {

            // Valider les entrées.
            $entrees = Arr::only($requete->json()->all(), [

                'identifiant',
                'denomination',
                'statutJuridique',
                'domaine',
                'dateFondation',
                'capitalSocial',
                'nombreEmploye',
                'lieuSiege',
                'paysSiege',
            ]);

            $validateur = Validator::make($entrees, [

                'identifiant' => ['required_without_all:denomination, statutJuridique, domaine, dateFondation, capitalSocial, nombreEmploye, lieuSiege, paysSiege',
                    'string', 'max:64', 'unique:systeme_organisations,identifiant', new IdentifiantUniqueRule],
                'denomination' => ['required_without_all:identifiant, statutJuridique, domaine, dateFondation, capitalSocial, nombreEmploye, lieuSiege, paysSiege',
                    'string', 'max:64', new DenominationUniqueRule],
                'statutJuridique' => 'required_without_all:identifiant, denomination, domaine, dateFondation, capitalSocial, nombreEmploye, lieuSiege, paysSiege|'.
                    'string|max:64',
                'domaine' => 'required_without_all:identifiant, denomination, statutJuridique, dateFondation, capitalSocial, nombreEmploye, lieuSiege, paysSiege|'.
                    'string|max:64',
                'dateFondation' => 'required_without_all:identifiant, denomination, statutJuridique, domaine, capitalSocial, nombreEmploye, lieuSiege, paysSiege|'.
                    'date_format:Y-m-d H:i:s',
                'capitalSocial' => 'required_without_all:identifiant, denomination, statutJuridique, domaine, dateFondation, nombreEmploye, lieuSiege, paysSiege|'.
                    'int|min:0',
                'nombreEmploye' => 'required_without_all:identifiant, denomination, statutJuridique, domaine, dateFondation, capitalSocial, lieuSiege, paysSiege|'.
                    'int|min:0',
                'lieuSiege' => 'required_without_all:identifiant, denomination, statutJuridique, domaine, dateFondation, capitalSocial, nombreEmploye, paysSiege|'.
                    'string|max:64',
                'paysSiege' => 'required_without_all:identifiant, denomination, statutJuridique, domaine, dateFondation, capitalSocial, nombreEmploye, lieuSiege|'.
                    'uuid|exists:systeme_pays,id',
            ]);

            // Rétouner une réponse d'échec lorsque les validations échouent.
            if ($validateur->fails()) {

                // Retourner une réponse de succès.
                return response()->json([
                    'message' => 'Des erreurs erreurs sont survenues lors de la validation des entrées.',
                    'erreurs' => $validateur->errors()->toArray(),
                ], Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            // Récupérer l'utilisateur.
            $utilisateur = $requete->utilisateur;

            // Vérifier si l'utilisateur est une organisation.
            if ($utilisateur->typeUtilisateur != 'organisation') {

                // Retourner une réponse d'échec.
                return response()->json([
                    'message' => 'Des erreurs erreurs sont survenues lors de la validation des entrées.',
                    'erreurs' => [
                        'typeUtilisateur' => 'Cet utilisateur est une personne.',
                    ],
                ], Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            // Vérifier si l'utilisateur ne possède pas déjà des information personnelles.
            if ($utilisateur->organisation()->count() == 0) {

                // Retourner une réponse d'échec.
                return response()->json([
                    'message' => 'Des erreurs erreurs sont survenues lors de la validation des entrées.',
                    'erreurs' => ['organisation' => "Cet utilisateur ne possède pas d'informations d'organisation"],
                ], Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            // Persister les informations personnelles.
            if (isset($entrees['denomination'])) {
                $entrees['denomination'] = ucfirst($entrees['denomination']);
            }
            if (isset($entrees['statutJuridique'])) {
                $entrees['statutJuridique'] = ucfirst($entrees['statutJuridique']);
            }
            if (isset($entrees['domaine'])) {
                $entrees['domaine'] = ucfirst($entrees['domaine']);
            }
            if (isset($entrees['lieuSiege'])) {
                $entrees['lieuSiege'] = ucfirst($entrees['lieuSiege']);
            }
            $organisation = $utilisateur->organisation()->first();
            $organisation->update($entrees);
            $organisation->refresh();

            if ($organisation) {
                $organisation = $organisation->makeHidden([
                    'id',
                    'utilisateur',
                    'auteurCreation',
                    'auteurMiseAJour',
                ]);
            }

            // Retourner une réponse de succès.
            return response()->json([
                'message' => "Les informations d'organisation ont été mises à jour avec succès.",
                'donnees' => ['organisation' => $organisation->toArray()],
            ], status: 200);
        } catch (Exception $e) {
            Log::error($e);

            // Retourner une reponse d'erreurs.
            return response()->json([
                'message' => 'Le serveur a rencontré des erreurs lors du traitement de la requête.',
                'erreurs' => env('APP_DEBUG') == true ? [
                    'code' => $e->getCode(),
                    'message' => $e->getMessage(),
                    'trace' => $e->getTrace(),
                ] : [],
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Confirmer son adresse email.
     *
     *
     * @return JsonResponse $reponse
     */
    public function verifierEmail(Request $requete): JsonResponse
    {

        try {

            // Valider les entrées.
            $entrees = Arr::only($requete->json()->all(), ['email', 'otp']);

            $validateur = Validator::make($entrees, [

                'email' => 'required|email|max:255|exists:systeme_utilisateurs,email',
                'otp' => "required|size:6|regex:/^\d+$/|exists:systeme_utilisateurs,otp",
            ]);

            // Rétouner une réponse d'échec lorsque les validations échouent.
            if ($validateur->fails()) {

                // Retourner une réponse de succès.
                return response()->json([
                    'message' => 'Des erreurs erreurs sont survenues lors de la validation des entrées.',
                    'erreurs' => $validateur->errors()->toArray(),
                ], Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            // Récupérer l'utilisateur.
            $utilisateur = Utilisateur::where('email', $entrees['email'])->first();

            if (! $utilisateur->verifierOtp($entrees['otp'])) {

                // Retourner une réponse de succès.
                return response()->json([
                    'message' => 'Des erreurs erreurs sont survenues lors de la validation des entrées.',
                    'erreurs' => ['otp' => 'Le code à usage unique fourni est invalide.'],
                ], Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            $utilisateur->update(['dateVerificationEmail' => Carbon::now()->format('Y-m-d H:i:s')]);

            // Retourner une réponse de succès.
            return response()->json([
                'message' => "L'email a été vérifié avec succès.",
                'donnees' => [],
            ], Response::HTTP_OK);

        } catch (Exception $e) {
            Log::error($e);

            return response()->json([
                'message' => 'Le serveur a rencontré des erreurs lors du traitement de la requête.',
                'erreurs' => env('APP_DEBUG') == true ? [
                    'code' => $e->getCode(),
                    'message' => $e->getMessage(),
                    'trace' => $e->getTrace(),
                ] : [],
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Confirmer son numéro de téléphone.
     *
     *
     * @return JsonResponse $reponse
     */
    public function verifierTelephone(Request $requete): JsonResponse
    {

        try {

            // Valider les entrées.
            $entrees = Arr::only($requete->json()->all(), ['indicatifTelephonique', 'telephone', 'otp']);

            $validateur = Validator::make($entrees, [

                'indicatifTelephonique' => 'required|int|min:1|max:999|exists:systeme_indicatif_telephoniques,valeur',
                'telephone' => ['required', "regex:/^\d+$/", 'min:8', 'max:12', 'exists:systeme_utilisateurs,telephone',
                    new TelephoneExisteRule,
                ],
                'otp' => "required|size:6|regex:/^\d+$/|exists:systeme_utilisateurs,otp",
            ]);

            // Rétouner une réponse d'échec lorsque les validations échouent.
            if ($validateur->fails()) {

                // Retourner une réponse de succès.
                return response()->json([
                    'message' => 'Des erreurs erreurs sont survenues lors de la validation des entrées.',
                    'erreurs' => $validateur->errors()->toArray(),
                ], Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            // Récupérer l'utilisateur.
            $utilisateur = Utilisateur::where('indicatifTelephonique', $entrees['indicatifTelephonique'])
                ->where('indicatifTelephonique', $entrees['indicatifTelephonique'])->first();

            if (! $utilisateur->verifierOtp($entrees['otp'])) {

                // Retourner une réponse de succès.
                return response()->json([
                    'statut' => 'Echec',
                    'message' => 'Des erreurs erreurs sont survenues lors de la validation des entrées.',
                    'erreurs' => ['otp' => 'Le code à usage unique fourni est invalide.'],
                ], Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            $utilisateur->update(['dateVerificationTelephone' => Carbon::now()->format('Y-m-d H:i:s')]);

            // Retourner une réponse de succès.
            return response()->json([
                'message' => 'Le numéro de téléphone a été vérifié avec succès.',
            ], Response::HTTP_OK);

        } catch (Exception $e) {
            Log::error($e);

            // Retourner une reponse d'erreurs.
            return response()->json([
                'message' => 'Le serveur a rencontré des erreurs lors du traitement de la requête.',
                'erreurs' => env('APP_DEBUG') == true ? [
                    'code' => $e->getCode(),
                    'message' => $e->getMessage(),
                    'trace' => $e->getTrace(),
                ] : [],
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Mettre à jour le statut de l'authentification à deux facteurs.
     *
     *
     * @return JsonResponse $reponse
     */
    public function mettreAJourAuthentification(Request $requete): JsonResponse
    {

        try {

            // Récupérer et filter les entrées.
            $entrees = Arr::only($requete->json()->all(), ['otp', 'statutDoubleAuthentification']);

            // Valider les entrées.
            $validateur = Validator::make($entrees, [
                'otp' => "required|regex:/^\d+$/size:6|exists:systeme_utilisateurs,otp",
                'statutDoubleAuthentification' => 'required|boolean',
            ]);

            if ($validateur->fails()) {

                return response()->json([
                    'message' => 'Erreurs dans la validation des entrées.',
                    'erreurs' => $validateur->errors()->toArray(),
                ], status: Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            // Récupérer l'utilisateur.
            $utilisateur = $requete->utilisateur;

            // Vérifier le code à usage unique.
            if (! $utilisateur->verifierOtp($entrees['otp'])) {

                return response()->json([
                    'message' => 'Erreurs dans la validation des entrées.',
                    'erreurs' => ['otp' => 'Le code à usage unique fourni est invalide.'],
                ], status: Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            // Faire cette vérification sur l'état de la double authentification.
            if ($utilisateur->statutDoubleAuthentification == true) {

                if ($entrees['statutDoubleAuthentification'] == true) {

                    return response()->json([
                        'message' => 'La double authentification est déjà active sur ce compte.',
                    ], Response::HTTP_ACCEPTED);
                }
            } else {

                if ($entrees['statutDoubleAuthentification'] == false) {

                    return response()->json([
                        'message' => 'La double authentification est déjà désactivé sur ce compte.',
                    ], Response::HTTP_ACCEPTED);
                }
            }

            $utilisateur->update(['statutDoubleAuthentification' => $entrees['statutDoubleAuthentification']]);

            return response()->json([
                'message' => $entrees['statutDoubleAuthentification'] == true ?
                    'La double authentification a été activée avec succès.' :
                    'La double authentification a étté désactivée avec succès.',
            ], Response::HTTP_OK);

        } catch (Exception $e) {
            Log::error($e);

            return response()->json([
                'message' => 'Le serveur a rencontré des erreurs lors du traitement de la requête.',
                'erreurs' => env('APP_DEBUG') == true ? [
                    'code' => $e->getCode(),
                    'message' => $e->getMessage(),
                    'trace' => $e->getTrace(),
                ] : [],
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Mettre à jour son mot de passe.
     *
     *
     * @return JsonResponse $reponse
     */
    public function mettreAJourMotDePasse(Request $requete): JsonResponse
    {

        try {

            // Valider les entrées.
            $entrees = Arr::only($requete->json()->all(), [
                'ancienMotDePasse',
                'nouveauMotDePasse',
                'confirmationMotDePasse',
                'otp',
            ]);

            $validateur = Validator::make($entrees, [
                'ancienMotDePasse' => 'required|min:8|max:32',
                'nouveauMotDePasse' => 'required|min:8|max:32',
                'confirmationMotDePasse' => 'required|same:motDePasse',
                'otp' => "nullable|regex:/^\d+$/|size:6|exists:systeme_utilisateurs,otp",
            ]);

            // Vérifier l'état des validations.
            if ($validateur->fails()) {
                return response()->json([
                    'message' => 'Des erreurs sont survenues lors de la validation des données.',
                    'erreurs' => $validateur->errors()->toArray(),
                ], Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            // Récupérer l'utilisateur.
            $utilisateur = $requete->utilisateur;

            // Vérifier l'ancien mot de passe.
            if ($utilisateur->verifierMotDePasse($entrees['ancienMotDePasse']) == false) {

                return response()->json([
                    'message' => "L'ancien mot de passe fourni est incorrecte.",
                ], Response::HTTP_FORBIDDEN);
            }

            // Vérifier la double authentification.
            if ($utilisateur->statutDoubleAuthentification == true) {

                if (isset($entrees['otp'])) {

                    if ($utilisateur->verifierOtp($entrees['otp']) == false) {

                        return response()->json([
                            'message' => "L'ancien mot de passe fourni est incorrecte.",
                        ], Response::HTTP_FORBIDDEN);
                    }
                } else {

                    return response()->json([
                        'message' => 'La double authentification est activée sur ce compte. Fournir le code à usage unique pour vérification',
                    ], Response::HTTP_ACCEPTED);
                }
            }

            $utilisateur->update(['motDePasse' => Hash::make($entrees['motDePasse'])]); // Mettre à jour l'utilisateur.

            return response()->json([
                'message' => 'Le mot de passe a été mis à jour avec succès.',
            ], Response::HTTP_OK);

        } catch (Exception $e) {
            Log::error($e);

            return response()->json([
                'message' => 'Le serveur a rencontré des erreurs lors du traitement de la requête.',
                'erreurs' => env('APP_DEBUG') == true ? [
                    'code' => $e->getCode(),
                    'message' => $e->getMessage(),
                    'trace' => $e->getTrace(),
                ] : [],
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Mettre à jour son mot de passe.
     *
     *
     * @return JsonResponse $reponse
     */
    public function mettreAJourMotDePasseOublie(Request $requete): JsonResponse
    {

        try {

            // Valider les entrées.
            $entrees = Arr::only($requete->json()->all(), [
                'email',
                'indicatifTelephonique',
                'telephone',
                'otp',
                'nouveauMotDePasse',
                'confirmationMotDePasse',
            ]);

            $validateur = Validator::make($entrees, [
                'email' => 'required_without_all:telephone|email|max:255|exists:systeme_utilisateurs,email',
                'indicatifTelephonique' => 'required_with:telephone|prohibited_if:telephone,null|int|min:1|max:999',
                'telephone' => ['required_without_all:email', "regex:/^\d+$/", 'min:8', 'max:12',
                    new TelephoneExisteRule,
                ],
                'otp' => "required|regex:/^\d+$/|size:6|exists:systeme_utilisateurs,otp",
                'nouveauMotDePasse' => 'required|min:8|max:32',
                'confirmationMotDePasse' => 'required|same:nouveauMotDePasse',
            ]);

            // Vérifier l'état des validations.
            if ($validateur->fails()) {
                return response()->json([
                    'message' => 'Des erreurs sont survenues lors de la validation des données.',
                    'erreurs' => $validateur->errors()->toArray(),
                ], Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            // Récupérer l'utilisateur.
            if (isset($entrees['email'])) {
                $utilisateur = Utilisateur::where('email', $entrees['email'])->first();
            } else {
                $utilisateur = Utilisateur::where('telephone', $entrees['telephone'])
                        ->where('indicatifTelephonique', $entrees['indicatifTelephonique'])->first();
            }

            // Vérifier le code à usage unique.
            if (! $utilisateur->verifierOtp($entrees['otp'])) {

                return response()->json([
                    'message' => 'Des erreurs sont survenues lors de la validation des données.',
                    'erreurs' => ['otp' => 'Le code à usage unique fourni est invalide.'],
                ], Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            // Persister un code à usage unique pour l'utilisateur.
            $utilisateur->update([
                'motDePasse' => Hash::make($entrees['nouveauMotDePasse']),
            ]);
            $utilisateur->blocages()->where('statutDeblocable', true)->delete();
            $utilisateur->connexions()->delete();

            // Retourner une réponse de succès.
            return response()->json([
                'message' => 'Le mot de passe a été mis à jour avec succès.',
            ], Response::HTTP_OK);

        } catch (Exception $e) {
            Log::error($e);

            return response()->json([
                'message' => 'Le serveur a rencontré des erreurs lors du traitement de la requête.',
                'erreurs' => env('APP_DEBUG') == true ? [
                    'code' => $e->getCode(),
                    'message' => $e->getMessage(),
                    'trace' => $e->getTrace(),
                ] : [],
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Débloquer son compte suite à un blocage dû à des tentatives de connexion infructueuses.
     *
     *
     * @return JsonResponse $reponse
     */
    public function debloquer(Request $requete): JsonResponse
    {

        try {

            // Valider les entrées.
            $entrees = Arr::only($requete->json()->all(), [
                'email',
                'indicatifTelephonique',
                'telephone',
                'otp',
            ]);

            $validateur = Validator::make($entrees, [
                'email' => 'required_without_all:telephone|email|max:255|exists:systeme_utilisateurs,email',
                'indicatifTelephonique' => 'required_with:telephone|prohibited_if:telephone,null|string|min:8|max:12|exists:systeme_indicatif_telephoniques,valeur',
                'telephone' => 'required_without_all:email|string|min:8|max:12|exists:systeme_utilisateurs,telephone',
                'otp' => 'required|string|size:6|exists:systeme_utilisateurs,otp',
            ]);

            // Vérifier l'état des validations.
            if ($validateur->fails()) {
                return response()->json([
                    'statut' => 'Echec',
                    'message' => 'Des erreurs sont survenues lors de la validation des données.',
                    'erreurs' => $validateur->errors()->toArray(),
                ], Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            // Valider la concaténation de l'indicatif téléphonique et du numéro de téléphone.
            if (isset($entrees['indicatifTelephonique'])) {
                if (! Utilisateur::validerIndicatifTelephone($entrees['indicatifTelephonique'], $entrees['telephone'])) {

                    // Retourner une réponse de succès.
                    return response()->json([
                        'statut' => 'Echec',
                        'message' => 'Des erreurs erreurs sont survenues lors de la validation des entrées.',
                        'erreurs' => [
                            'telephone' => "Le valeur sélectionnée pour telephone n'existe pas.",
                        ],
                    ], Response::HTTP_UNPROCESSABLE_ENTITY);
                }
            }

            // Récupérer l'utilisateur.
            if (isset($entrees['email'])) {
                $utilisateur = Utilisateur::where('email', $entrees['email'])->first();
            } else {
                $utilisateur = Utilisateur::where('telephone', $entrees['telephone'])
                        ->where('indicatifTelephonique', $entrees['indicatifTelephonique'])->first();
            }

            // Vérifier le code à usage unique.
            if (! $utilisateur->verifierOtp($entrees['otp'])) {

                return response()->json([
                    'statut' => 'Echec',
                    'message' => 'Des erreurs sont survenues lors de la validation des données.',
                    'erreurs' => ['otp' => 'Le code à usage unique fourni est invalide.'],
                ], Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            // Annuler le blocage de l'utilisateur.
            $utilisateur->blocages()->where('statutDeblocable', true)->delete();
            $utilisateur->connexions()->delete();

            // Envoyer un code à usage unique par email pour vérification.

            // Retourner une réponse de succès.
            return response()->json([
                'statut' => 'Succes',
                'message' => 'Votre compte a été débloqué avec succès.',
                'donnees' => [],
            ], Response::HTTP_OK);
        } catch (Exception $e) {

            // Enregister les erreurs dans les logs.
            Log::error($e);

            // Retourner une reponse d'erreurs.
            return response()->json([
                'statut' => 'Echec',
                'message' => 'Le serveur a rencontré des erreurs lors du traitement de la requête.',
                'erreurs' => env('APP_DEBUG') == true ? [
                    'code' => $e->getCode(),
                    'message' => $e->getMessage(),
                    'trace' => $e->getTrace(),
                ] : [],
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Se deconnecter de la session courante.
     *
     *
     * @return JsonResponse $reponse
     */
    public function deconnecter(Request $requete): JsonResponse
    {

        try {

            Session::where('jeton', $requete->header(Session::NOM_CLE_SESSION))->delete();

            // Retourner une réponse de succès.
            return response()->json([
                'message' => 'Votre session a été déconnecter avec succès.',
                'donnees' => [],
            ], status: 200);
        } catch (Exception $e) {

            // Enregister les erreurs dans les logs.
            Log::error($e);

            // Retourner une reponse d'erreurs.
            return response()->json([
                'statut' => 'Echec',
                'message' => 'Le serveur a rencontré des erreurs lors du traitement de la requête.',
                'erreurs' => env('APP_DEBUG') == true ? [
                    'code' => $e->getCode(),
                    'message' => $e->getMessage(),
                    'trace' => $e->getTrace(),
                ] : [],
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Déconnecter toutes ses sessions de connexion.
     *
     *
     * @return JsonResponse $reponse
     */
    public function deconnecterSessions(Request $requete): JsonResponse
    {

        try {

            $utilisateur = $requete->utilisateur;

            $utilisateur->sessions()->delete();

            // Retourner une réponse de succès.
            return response()->json([
                'message' => 'Toutes vos sessions ont été déconnectées.',
                'donnees' => [],
            ], Response::HTTP_OK);

        } catch (Exception $e) {
            Log::error($e);

            // Retourner une reponse d'erreurs.
            return response()->json([
                'message' => 'Le serveur a rencontré des erreurs lors du traitement de la requête.',
                'erreurs' => env('APP_DEBUG') == true ? [
                    'code' => $e->getCode(),
                    'message' => $e->getMessage(),
                    'trace' => $e->getTrace(),
                ] : [],
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Supprimer son compte utilisateur.
     *
     *
     * @return JsonResponse $reponse
     */
    public function supprimer(Request $requete): JsonResponse
    {

        try {

            $requete->utilisateur->delete();

            // Retourner une réponse de succès.
            return response()->json([
                'message' => '',
                'donnees' => [],
            ], Response::HTTP_OK);

        } catch (Exception $e) {
            Log::error($e);

            // Retourner une reponse d'erreurs.
            return response()->json([
                'message' => 'Le serveur a rencontré des erreurs lors du traitement de la requête.',
                'erreurs' => env('APP_DEBUG') == true ? [
                    'code' => $e->getCode(),
                    'message' => $e->getMessage(),
                    'trace' => $e->getTrace(),
                ] : [],
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
