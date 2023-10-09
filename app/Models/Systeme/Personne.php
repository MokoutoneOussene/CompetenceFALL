<?php

namespace App\Models\Systeme;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Personne extends Model
{
    use HasFactory;

    public $table = 'systeme_personnes';

    public $fillable = [

        'utilisateur',
        'nom',
        'prenoms',
        'genre',
        'dateNaissance',
        'lieuNaissance',
        'paysNaissance',
        'lieuResidence',
        'paysResidence',
        'nationalites',
    ];

    public $guarded = [];

    public $hidden = [];

    /**
     * Récupérer l'utilisateur associé à la personne
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
     * Récupérer le pays de naissance de la personne.
     *
     * @return BelongsTo $pays
     *
     * @throws Exception $e
     */
    public function paysNaissance(): BelongsTo
    {

        try {

            return $this->belongsTo(
                related: Pays::class,
                foreignKey: 'paysNaissance',
                ownerKey: 'id'
            );

        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Récupérer le pays de résidence de la personne.
     *
     * @return BelongsTo $pays
     *
     * @throws Exception $e
     */
    public function paysResidence(): BelongsTo
    {

        try {

            return $this->belongsTo(
                related: Pays::class,
                foreignKey: 'paysResidence',
                ownerKey: 'id'
            );

        } catch (Exception $e) {
            throw $e;
        }
    }
}
