<?php

namespace App\Models\Marketing;

use App\Models\Finance\Paiement;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MarketingVente extends Model
{
    use HasFactory;

    public $table = 'marketing_ventes';

    public $fillable = [

        'marketeur',
        'paiement',
        'tauxCommission',
        'montantCommission',
        'details',
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
     * Récupérer le paiement.
     *
     * @return BelongsTo $paiement
     *
     * @throws Exception $e
     */
    public function paiement(): BelongsTo
    {

        try {

            return $this->belongsTo(
                related: Paiement::class,
                foreignKey: 'paiement',
                ownerKey: 'id'
            );

        } catch (Exception $e) {
            throw $e;
        }
    }
}
