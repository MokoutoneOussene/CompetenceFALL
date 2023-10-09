<?php

namespace App\Models\Finance;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Bien extends Model
{
    use HasFactory;

    public $table = 'finance_biens';

    public $fillable = [

        'facture',
        'numeroOrdre',
        'designation',
        'unite',
        'quantite',
        'priUnitaire',
        'montant',
    ];

    public $guarded = [];

    public $hidden = [];

    /**
     * Récupérer la facture.
     *
     * @return BelongsTo $facture
     *
     * @throws Exception $e
     */
    public function facture(): BelongsTo
    {

        try {

            return $this->belongsTo(
                related: Facture::class,
                foreignKey: 'facture',
                ownerKey: 'id'
            );

        } catch (Exception $e) {
            throw $e;
        }
    }
}
