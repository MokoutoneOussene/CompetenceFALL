<?php

namespace App\Models\Systeme;

use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class Session extends Model
{
    use HasFactory;

    public $table = 'systeme_sessions';

    public $fillable = [
        'utilisateur',
        'agent',
        'ipv4',
        'jeton',
        'dateExpiration',
    ];

    public $guarded = [];

    public $hidden = [];

    public static function creerSession(Utilisateur $utilisateur, Request $requete): self
    {

        try {

            // Persister une session pour l'utilisateur.
            DB::beginTransaction();
            $utilisateur->sessions()->orderBy('dateExpiration', 'desc')->offset(2)->limit(100)->get()->each->delete();
            $session = new Session([
                'utilisateur' => $utilisateur->id,
                'agent' => $requete->userAgent(),
                'ipv4' => $requete->getClientIp(),
            ]);
            $session->genererJeton();
            $session->save();
            $session->refresh();
            $utilisateur->dateDerniereConnexion = Carbon::now()->format('Y-m-d H:i:s');
            $utilisateur->save();
            $utilisateur->connexions()->delete();
            DB::commit();

            return $session;

        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Nom du jeton d'authentification.
     *
     * @const NOM_CLE_SESSION
     */
    public const NOM_CLE_SESSION = 'cle_uti_cfai';

    /**
     * Récupérer l'utilisateur d'une session.
     *
     * @return BelongsTo $utilisateur
     *
     * @throws Exception $e
     */
    public function utilisateur(): BelongsTo
    {

        try {

            return $this->belongsTo(
                related: Utilisateur::class,
                foreignKey: 'utilisateur',
                ownerKey: 'id'
            );

        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Générer un jeton d'authentification
     */
    public function genererJeton(): void
    {

        try {

            for (
                $uuid = Str::uuid();
                (self::where('jeton', $uuid->toString())->exists());
                $uuid = Str::uuid()
            );

            $this->jeton = $uuid->toString();
            $this->dateExpiration = Carbon::now()->addWeeks(2)->format('Y-m-d H:i:s');

        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Vérifier la validité du jeton d'authentifiication
     *
     * @return bool $reponse
     */
    public function verifierJeton(): bool
    {

        if (Carbon::parse($this->dateExpiration)->gte(Carbon::now())) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Raffraichir la session de l'utilisateur
     *
     * @return void $reponse
     */
    public function raffraichirSession(): void
    {

        try {

            $this->dateExpiration = Carbon::now()->addWeeks($this->DUREE_JETON)->format('Y-m-d H:i:s');
            $this->dateDerniereConnexion = Carbon::now()->format('Y-m-d H:i:s');
            $this->save();

        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Recupérer la date de la dernière connexion de l'utilisateur
     *
     * @return Carbon $dateDerniereConnexion
     */
    public function dateDerniereConnexion(): Carbon
    {

        try {

            $session = self::where('utilisateur', $this->utilisateur)->orderBy('dateDerniereConnexion', 'desc')->first();

            return Carbon::parse($session->dateDerniereConnexion);

        } catch (Exception $e) {
            throw $e;
        }
    }
}
