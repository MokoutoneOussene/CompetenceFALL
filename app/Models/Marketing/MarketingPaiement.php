<?php

namespace App\Models\Marketing;

use App\Models\Systeme\Utilisateur;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MarketingPaiement extends Model
{
    use HasFactory;

    public $table = 'marketing_paiements';

    public $fillable = [

        'marketeur',
        'montant',
        'details',
        'statut',
        'auteurCreation',
        'auteurMiseAJour',
    ];

    public $guarded = [];

    public $hidden = [];

    /**
     * Récupérer le marketeur.
     *
     * @return BelongsTo $marketeur
     *
     * @throws Exception $e
     */
    public function marketeur(): BelongsTo
    {

        try {

            return $this->belongsTo(
                related: Marketeur::class,
                foreignKey: 'marketeur',
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
    public function ventes(): BelongsTo
    {

        try {

            return $this->belongsTo(
                related: MarketingVente::class,
                foreignKey: 'paiement',
                ownerKey: 'id'
            );

        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Récupérer l'auteur de la création.
     *
     * @return BelongsTo $auteurCreation
     *
     * @throws Exception $e
     */
    public function auteurCreation(): BelongsTo
    {

        try {

            return $this->belongsTo(
                related: Utilisateur::class,
                foreignKey: 'auteurCreation',
                ownerKey: 'id'
            );

        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Récupérer l'auteur de la mise à jour.
     *
     * @return BelongsTo $auteurMiseAJour
     *
     * @throws Exception $e
     */
    public function auteurMiseAJour(): BelongsTo
    {

        try {

            return $this->belongsTo(
                related: Utilisateur::class,
                foreignKey: 'auteurMiseAJour',
                ownerKey: 'id'
            );

        } catch (Exception $e) {
            throw $e;
        }
    }
}
