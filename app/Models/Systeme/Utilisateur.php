<?php

namespace App\Models\Systeme;

use App\Models\Emploi\Profil;
use App\Models\Finance\Facture;
use App\Models\Formation\Formation;
use App\Models\Formation\Participant;
use App\Models\Forum\Forum;
use App\Models\Service\Demande;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class Utilisateur extends Model
{
    use HasFactory;

    public $timestamps = true;

    public $table = 'systeme_utilisateurs';

    protected $fillable = [
        'cheminPhotoProfil',
        'cheminBanniere',
        'nomUtilisateur',
        'motDePasse',
        'email',
        'indicatifTelephonique',
        'telephone',
        'boitePostale',
        'siteWeb',
        'description',
        'typeUtilisateur',
        'statutDoubleAuthentification',
        'dateVerificationEmail',
        'statutNotificationEmail',
        'otp',
        'dateExpirationOtp',
        'dateProchaineTentativeOtp',
        'dateVerificationTelephone',
        'statutNotificationSms',
        'dateDerniereConnexion',
    ];

    public $guarded = [];

    protected $hidden = [
        'cheminPhotoProfil',
        'motDePasse',
        'otp',
        'dateExpirationOtp',
        'dateProchaineTentativeOtp',
    ];

    /**
     * Logique de création d'un utilisateur avec les entrées du controlleur.
     *
     *
     *
     * @throws Exception $e
     */
    public static function creerUtilisateur(array $entrees): self
    {

        try {

            // Formatter les données.
            $entrees['motDePasse'] = Hash::make($entrees['motDePasse']);

            // Créer l'utilisateur.
            $utilisateur = new self($entrees);

            // Générer un code à usage unique pour la vérification de l'email.
            $utilisateur->genererOtp();

            // Persister l'utilisateur et lui attribuer des privilèges de base.
            DB::beginTransaction();

            // Sauvegarder l'utilisateur.
            $utilisateur->save();
            $utilisateur->refresh();

            // Fournir des privilèges de base à l'utilisateur.
            $utilisateur->roles()->attach(Role::where('slug', 'cli')->first(['id'])->id, ['id' => Str::uuid()->toString()]);

            DB::commit();

            return $utilisateur;

        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Constante déterminant la durée (en minutes) de validité du code à usage unique.
     *
     * @var int DUREE_VALIDITE_OTP
     */
    public const DUREE_VALIDITE_OTP = 5;

    /**
     * Constante déterminant la durée (en minutes) pour reéssayer une demande de jeton à usage unique
     *
     * @var int DUREE_TENTATIVE_OTP
     */
    public const DUREE_TENTATIVE_OTP = 1;

    /**
     * Constante déterminant le nombre maximal de tentatives de connexion infructueuses avant blocage.
     *
     * @var int NOMBRE_MAX_TENTATIVE_CONNEXION
     */
    public const NOMBRE_MAX_TENTATIVE_CONNEXION = 3;

    /**
     * Vérifier le mot de passe.
     *
     *
     * @return bool $reponse
     */
    public function verifierMotDePasse(string $motDePasse): bool
    {
        return Hash::check($motDePasse, $this->motDePasse);
    }

    /**
     * Générer un code à usage unique.
     *
     * @return bool $reponse
     */
    public function genererOtp(): bool
    {

        try {

            if (
                $this->dateProchaineTentativeOtp == null ||
                Carbon::parse($this->dateProchaineTentativeOtp)->lt(Carbon::now())
            ) {

                for (
                    $otp = sprintf('%06d', mt_rand(10000, 999999));
                    (self::where('otp', $otp)->exists());
                    $otp = sprintf('%06d', mt_rand(10000, 999999))
                );

                $this->otp = $otp;
                $this->dateExpirationOtp = Carbon::now()->addMinutes(self::DUREE_VALIDITE_OTP)->format('Y-m-d H:i:s');
                $this->dateProchaineTentativeOtp = Carbon::now()->addMinutes(self::DUREE_TENTATIVE_OTP)->format('Y-m-d H:i:s');

                return true;

            } else {
                return false;
            }

        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Vérifier le numéro de téléphone.
     *
     *
     *
     * @return bool $reponse
     */
    public function verifierTelephone(string $indicatifTelephonique, string $telephone): bool
    {

        if (
            $this->indicatifTelephonique != $indicatifTelephonique ||
            $this->telephone != $telephone
        ) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * Vérifier la validité du code à usage unique.
     *
     *
     * @return bool $reponse
     */
    public function verifierOtp(string $otp): bool
    {

        try {

            if ($this->otp != $otp) {
                $this->annulerOtp();

                return false;
            } elseif (Carbon::parse($this->dateExpirationOtp)->gte(Carbon::now()) == false) {
                $this->annulerOtp();

                return false;
            } else {
                $this->annulerOtp();

                return true;
            }

        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Annuler le jeton sms.
     *
     * @return void $reponse
     */
    public function annulerOtp(): void
    {

        $this->otp = null;
        $this->dateExpirationOtp = null;
    }

    /**
     * Actualiser la date de la dernière connexion.
     */
    public function actualiserDateDerniereConnexion(): void
    {

        $this->dateDerniereConnexion = Carbon::now()->format('Y-m-d H:i:s');
    }

    /**
     * Récupérer les privilèges.
     *
     * @return HasMany $privileges
     *
     * @throws Exception $e
     */
    public function privileges(): HasMany
    {

        try {

            return $this->hasMany(
                related: Privilege::class,
                foreignKey: 'utilisateur',
                localKey: 'id'
            );

        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Récupérer les rôles.
     *
     * @return BelongsToMany $roles
     *
     * @throws Exception $e
     */
    public function roles(): BelongsToMany
    {

        try {

            return $this->belongsToMany(
                Role::class,			// Modèle cible (Role)
                'systeme_privileges',	// Nom de la table intermédiaire
                'utilisateur',			// Clé étrangère du modèle Utilisateur dans la table intermédiaire
                'role'					// Clé étrangère du modèle Role dans la table intermédiaire
            )->withTimestamps();		// Utilisation des timestamps pour les relations

        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Récupérer la personne.
     *
     * @return HasOne $personne
     *
     * @throws Exception $e
     */
    public function personne(): HasOne
    {

        try {

            return $this->hasOne(
                related: Personne::class,
                foreignKey: 'utilisateur',
                localKey: 'id'
            );

        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Récupérer l'organisation.
     *
     * @return HasOne $organisation
     *
     * @throws Exception $e
     */
    public function organisation(): HasOne
    {

        try {

            return $this->hasOne(
                related: Organisation::class,
                foreignKey: 'utilisateur',
                localKey: 'id'
            );

        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Récupérer les sessions.
     *
     * @return HasMany $sessions
     *
     * @throws Exception $e
     */
    public function sessions(): HasMany
    {

        try {

            return $this->hasMany(
                related: Session::class,
                foreignKey: 'utilisateur',
                localKey: 'id'
            );

        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Récupérer les anciens mots de passe.
     *
     * @return HasMany $motDePasses
     *
     * @throws Exception $e
     */
    public function motDePasses(): HasMany
    {

        try {

            return $this->hasMany(
                related: HistoriqueMotDePasse::class,
                foreignKey: 'utilisateur',
                localKey: 'id'
            );

        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Récupérer les  tentatives de connexion.
     *
     * @return HasMany $connexions
     *
     * @throws Exception $e
     */
    public function connexions(): HasMany
    {

        try {

            return $this->hasMany(
                related: TentativeConnexion::class,
                foreignKey: 'utilisateur',
                localKey: 'id'
            );

        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Récupérer les activités.
     *
     * @return HasMany $logs
     *
     * @throws Exception $e
     */
    public function logs(): HasMany
    {

        try {

            return $this->hasMany(
                related: Log::class,
                foreignKey: 'utilisateur',
                localKey: 'id'
            );

        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Récupérer les blocages administrateurs.
     *
     * @return HasMany $blocages
     *
     * @throws Exception $e
     */
    public function blocages(): HasMany
    {

        try {

            return $this->hasMany(
                related: UtilisateurBlocage::class,
                foreignKey: 'utilisateur',
                localKey: 'id'
            );

        } catch (Exception $e) {
            throw $e;
        }
    }

    //
    // OFFRES D'EMPLOI
    //

    /**
     * Récupérer les profils.
     *
     * @return HasMany $profils
     *
     * @throws Exception $e
     */
    public function profils(): HasMany
    {

        try {

            return $this->hasMany(
                related: Profil::class,
                foreignKey: 'utilisateur',
                localKey: 'id'
            );

        } catch (Exception $e) {
            throw $e;
        }
    }

    //
    // SERVICES
    //

    /**
     * Récupérer les demandes déposées.
     *
     * @return HasMany $demandes
     *
     * @throws Exception $e
     */
    public function demandes(): HasMany
    {

        try {

            return $this->hasMany(
                related: Demande::class,
                foreignKey: 'client',
                localKey: 'id'
            );

        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Récupérer les demandes examinées.
     *
     * @return HasMany $deamndesExaminees
     *
     * @throws Exception $e
     */
    public function demandesExaminees(): HasMany
    {

        try {

            return $this->hasMany(
                related: Demande::class,
                foreignKey: 'examinateur',
                localKey: 'id'
            );

        } catch (Exception $e) {
            throw $e;
        }
    }

    //
    // FINANCE
    //

    /**
     * Récupérer les factures propriétaires.
     *
     * @return HasMany $factures
     *
     * @throws Exception $e
     */
    public function factures(): HasMany
    {

        try {

            return $this->hasMany(
                related: Facture::class,
                foreignKey: 'client',
                localKey: 'id'
            );

        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Récupérer les factures émises.
     *
     * @return HasMany $facturesEmises
     *
     * @throws Exception $e
     */
    public function facturesEmises(): HasMany
    {

        try {

            return $this->hasMany(
                related: Facture::class,
                foreignKey: 'auteurCreation',
                localKey: 'id'
            );

        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Récupérer les factures examinées.
     *
     * @return HasMany $facturesExaminees
     *
     * @throws Exception $e
     */
    public function facturesExaminees(): HasMany
    {

        try {

            return $this->hasMany(
                related: Facture::class,
                foreignKey: 'auteurMiseAJour',
                localKey: 'id'
            );

        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Récupérer les paiments émis.
     *
     * @return HasMany $paiementsEmis
     *
     * @throws Exception $e
     */
    public function paiementsEmis(): HasMany
    {

        try {

            return $this->hasMany(
                related: Paiement::class,
                foreignKey: 'auteurCreation',
                localKey: 'id'
            );

        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Récupérer les paiments examinés.
     *
     * @return HasMany $paiementsExamines
     *
     * @throws Exception $e
     */
    public function paiementsExamines(): HasMany
    {

        try {

            return $this->hasMany(
                related: Paiement::class,
                foreignKey: 'auteurMiseAJour',
                localKey: 'id'
            );

        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Récupérer les remboursements émis.
     *
     * @return HasMany $remboursementsEmis
     *
     * @throws Exception $e
     */
    public function remboursementsEmis(): HasMany
    {

        try {

            return $this->hasMany(
                related: Remboursement::class,
                foreignKey: 'auteurCreation',
                localKey: 'id'
            );

        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Récupérer les remboursements examinés.
     *
     * @return HasMany $remboursementsExamines
     *
     * @throws Exception $e
     */
    public function remboursementsExamines(): HasMany
    {

        try {

            return $this->hasMany(
                related: Remboursement::class,
                foreignKey: 'auteurMiseAJour',
                localKey: 'id'
            );

        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Récupérer les rémises émises.
     *
     * @return HasMany $remisesEmises
     *
     * @throws Exception $e
     */
    public function remisesEmises(): HasMany
    {

        try {

            return $this->hasMany(
                related: Remise::class,
                foreignKey: 'auteurCreation',
                localKey: 'id'
            );

        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Récupérer les rémises examinées.
     *
     * @return HasMany $remisesExaminees
     *
     * @throws Exception $e
     */
    public function remisesExaminees(): HasMany
    {

        try {

            return $this->hasMany(
                related: Remise::class,
                foreignKey: 'auteurMiseAJour',
                localKey: 'id'
            );

        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Récupérer les formations.
     *
     * @return hasManyThrough $formations
     *
     * @throws Exception $e
     */
    public function formations(): HasManyThrough
    {

        try {

            return $this->hasManyThrough(
                related: Formation::class, // Modèle cible
                through: Participant::class, // Modèle intermédiaire
                firstKey: 'utilisateur', // Clé étrangère du modèle principal sur le modèle intermédiaire
                secondKey: 'id', // Clé primaire du modèle cible
                localKey: 'id', // Clé primaire du modèle principal
                secondLocalKey: 'formation' // Clé étrangère du modèle cible sur le modèle intermédiaire
            );

        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Récupérer les forums.
     *
     * @return HasManyThrough $forums
     *
     * @throws Exception $e
     */
    public function forums(): HasManyThrough
    {

        try {

            return $this->hasManyThrough(
                related: Forum::class, // Modèle cible
                through: Membre::class, // Modèle intermédiaire
                firstKey: 'utilisateur', // Clé étrangère du modèle principal sur le modèle intermédiaire
                secondKey: 'id', // Clé primaire du modèle cible
                localKey: 'id', // Clé primaire du modèle principal
                secondLocalKey: 'forum' // Clé étrangère du modèle cible sur le modèle intermédiaire
            );

        } catch (Exception $e) {
            throw $e;
        }
    }
}
