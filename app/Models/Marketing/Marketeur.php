<?php

namespace App\Models\Marketing;

use App\Models\Systeme\Utilisateur;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Marketeur extends Model
{
    use HasFactory;

    public $table = 'marketing_marketeurs';

    public $fillable = [

        'utilisateur',
        'intitule',
        'description',
        'code',
        'statutActivation',
        'auteurCreation',
        'auteurMiseAJour',
    ];

    public $guarded = [];

    public $hidden = [];

    /**
     * Récupérer l'utilisateur.
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
     * Récupérer les ventes.
     *
     * @return HasMany $ventes
     *
     * @throws Exception $e
     */
    public function ventes(): HasMany
    {

        try {

            return $this->hasMany(
                related: MarketingVente::class,
                foreignKey: 'marketeur',
                localKey: 'id'
            );

        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Récupérer les paiements.
     *
     * @return HasMany $paiements
     *
     * @throws Exception $e
     */
    public function paiements(): HasMany
    {

        try {

            return $this->hasMany(
                related: MarketingPaiement::class,
                foreignKey: 'marketeur',
                localKey: 'id'
            );

        } catch (Exception $e) {
            throw $e;
        }
    }
}
