<?php

namespace App\Models\Service;

use App\Models\Systeme\Utilisateur;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Demande extends Model
{
    use HasFactory;

    public $table = 'service_demandes';

    public $fillable = [

        'client',
        'domaine',
        'intitule',
        'contenu',
        'dateDebutSouhaitee',
        'dateFinSouhaitee',
        'statutExamination',
        'observations',
        'auteurCreation',
        'auteurMiseAJour',
    ];

    public $hidden = [];

    public $guarded = [];

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
     * Récupérer l'examinateur.
     *
     * @return BelongsTo $examinateur
     *
     * @throws Exception $e
     */
    public function examinateur(): BelongsTo
    {

        try {

            return $this->belongsTo(
                related: Utilisateur::class,
                foreignKey: 'examinateur',
                ownerKey: 'id'
            );

        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Récupérer les propositions.
     *
     * @return HasMany $propositions
     *
     * @throws Exception $e
     */
    public function propositions(): HasMany
    {

        try {

            return $this->hasMany(
                related: Proposition::class,
                foreignKey: 'demande',
                localKey: 'id'
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
                related: DemandeMedia::class,
                foreignKey: 'demande',
                localKey: 'id'
            );

        } catch (Exception $e) {
            throw $e;
        }
    }
}
