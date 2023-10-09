<?php

namespace App\Models\Finance;

use App\Models\Systeme\Utilisateur;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Facture extends Model
{
    use HasFactory;

    public $table = 'finance_factures';

    public $fillable = [

        'client',
        'numeroFacture',
        'statutTraitement',
        'montantHT',
        'statutApplicationTva',
        'tauxTva',
        'montantTva',
        'montantTTC',
        'modePaiement',
        'modalitesPaiement',
        'dateLimitePaiement',
        'cheminSignature',
        'auteurCreation',
        'auteurMiseAJour',
    ];

    public $guarded = [];

    public $hidden = [];

    /**
     * Récupérer le client.
     *
     * @return BelongsTo $client
     *
     * @throws Exception $e
     */
    public function client(): BelongsTo
    {

        try {

            return $this->belongsTo(
                related: Utilisateur::class,
                foreignKey: 'client',
                ownerKey: 'id'
            );

        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Récupérer les biens.
     *
     * @return HasMany $biens
     *
     * @throws Exception $e
     */
    public function biens(): HasMany
    {

        try {

            return $this->hasMany(
                related: Bien::class,
                foreignKey: 'facture',
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
                related: Paiement::class,
                foreignKey: 'facture',
                localKey: 'id'
            );

        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Récupérer les remises.
     *
     * @return HasMany $remises
     *
     * @throws Exception $e
     */
    public function remises(): HasMany
    {

        try {

            return $this->hasMany(
                related: Remise::class,
                foreignKey: 'facture',
                localKey: 'id'
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
