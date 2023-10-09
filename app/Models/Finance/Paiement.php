<?php

namespace App\Models\Finance;

use App\Models\Systeme\Utilisateur;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Paiement extends Model
{
    use HasFactory;

    public $table = 'finance_paiements';

    public $fillable = [

        'facture',
        'mode',
        'details',
        'montant',
        'statutAnnulation',
        'motifAnnulation',
        'auteurCreation',
        'auteurMiseAJour',
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

    /**
     * Récupérer l'auteur de création.
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
