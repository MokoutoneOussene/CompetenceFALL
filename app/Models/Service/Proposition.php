<?php

namespace App\Models\Service;

use App\Models\Finance\Facture;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Proposition extends Model
{
    use HasFactory;

    public $table = 'service_propositions';

    public $fillable = [

        'demande',
        'facture',
        'intitule',
        'contenu',
        'dateDebutProbable',
        'dateFinProbable',
        'auteurCreation',
        'auteurMiseAJour',
    ];

    public $hidden = [];

    public $guarded = [];

    /**
     * Récupérer le demande.
     *
     * @return BelongsTo $demande
     *
     * @throws Exception $e
     */
    public function demande(): BelongsTo
    {

        try {

            return $this->belongsTo(
                related: Demande::class,
                foreignKey: 'demande',
                ownerKey: 'id'
            );

        } catch (Exception $e) {
            throw $e;
        }
    }

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
     * Récupérer les pièce-jointes.
     *
     * @return HasMany $pieces
     *
     * @throws Exception $e
     */
    public function pieces(): HasMany
    {

        try {

            return $this->hasMany(
                related: PropositionMedia::class,
                foreignKey: 'proposition',
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
