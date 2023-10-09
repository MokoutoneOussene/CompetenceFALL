<?php

namespace App\Models\Interface;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Application extends Model
{
    use HasFactory;

    public $table = 'interface_applications';

    public $timestamps = true;

    const CREATED_AT = 'created_at';

    const UPDATED_AT = 'updated_at';

    public $fillable = [
        'denomination',
        'jeton',
        'statutActivation',
        'dateExpiration',
        'auteurCreation',
        'auteurMiseAJour',
    ];

    public $guarded = [];

    public $hidden = [];

    /**
     * Nom de l'API Key dans l'application Laravel pour les interface.
     *
     * @const NOM_CLE_API
     */
    public const NOM_CLE_API = 'cle_api_cfai';

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
}
