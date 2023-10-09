<?php

namespace App\Models\Formation;

use App\Models\Systeme\Utilisateur;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Formation extends Model
{
    use HasFactory;

    public $table = 'formation_lignes';

    public $fillable = [

        'intitule',
        'typeFormation',
        'description',
        'niveauDifficulte',
        'duree',
        'cout',
        'statutPublic',
        'statutActivation',
        'auteurCreation',
        'auteurMiseAJour',
    ];

    public $hidden = [];

    public $guarded = [];

    /**
     * Récupérer la formation présentielle.
     *
     * @return HasOne $presentielle
     *
     * @throws Exception $e
     */
    public function presentielle(): HasOne
    {

        try {

            return $this->hasOne(
                related: FormationPresentielle::class,
                foreignKey: 'formation',
                localKey: 'id'
            );

        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Récupérer les prerequis.
     *
     * @return hasManyThrough $prerequis
     *
     * @throws Exception $e
     */
    public function prerequis(): HasManyThrough
    {

        try {

            return $this->hasManyThrough(
                related: self::class, // Modèle cible
                through: Prerequis::class, // Modèle intermédiaire
                firstKey: 'formation', // Clé étrangère du modèle principal sur le modèle intermédiaire
                secondKey: 'id', // Clé primaire du modèle cible
                localKey: 'id', // Clé primaire du modèle principal
                secondLocalKey: 'prerequis' // Clé étrangère du modèle cible sur le modèle intermédiaire
            );

        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Récupérer les programmes.
     *
     * @return HasMany $programmes
     *
     * @throws Exception $e
     */
    public function programmes(): HasMany
    {

        try {

            return $this->hasMany(
                related: FormationProgramme::class,
                foreignKey: 'formation',
                localKey: 'id'
            );

        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Récupérer les inscriptions.
     *
     * @return HasMany $inscriptions
     *
     * @throws Exception $e
     */
    public function participants(): HasMany
    {

        try {

            return $this->hasMany(
                related: Participant::class,
                foreignKey: 'formation',
                localKey: 'id'
            );

        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Récupérer les certificats.
     *
     * @return HasMany $certificats
     *
     * @throws Exception $e
     */
    public function certificats(): HasMany
    {

        try {

            return $this->hasMany(
                related: FormationCertificat::class,
                foreignKey: 'formation',
                localKey: 'id'
            );

        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Récupérer les parties.
     *
     * @return HasMany $parties
     *
     * @throws Exception $e
     */
    public function parties(): HasMany
    {

        try {

            return $this->hasMany(
                related: FormationPartie::class,
                foreignKey: 'formation',
                localKey: 'id'
            );

        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Récupérer les progressions.
     *
     * @return HasMany $progressions
     *
     * @throws Exception $e
     */
    public function progressions(): HasMany
    {

        try {

            return $this->hasMany(
                related: FormationProgression::class,
                foreignKey: 'formation',
                localKey: 'id'
            );

        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Récupérer les evaluations.
     *
     * @return HasMany $evaluations
     *
     * @throws Exception $e
     */
    public function evaluations(): HasMany
    {

        try {

            return $this->hasMany(
                related: Evaluation::class,
                foreignKey: 'formation',
                localKey: 'id'
            );

        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Récupérer les medias.
     *
     * @return HasMany $medias
     *
     * @throws Exception $e
     */
    public function medias(): HasMany
    {

        try {

            return $this->hasMany(
                related: FormationMedia::class,
                foreignKey: 'formation',
                localKey: 'id'
            );

        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Récupérer les participants.
     *
     * @return hasManyThrough $participants
     *
     * @throws Exception $e
     */
    public function utilisateurs(): HasManyThrough
    {

        try {

            return $this->hasManyThrough(
                related: Utilisateur::class, // Modèle cible
                through: Participant::class, // Modèle intermédiaire
                firstKey: 'formation', // Clé étrangère du modèle principal sur le modèle intermédiaire
                secondKey: 'id', // Clé primaire du modèle cible
                localKey: 'id', // Clé primaire du modèle principal
                secondLocalKey: 'utilisateur' // Clé étrangère du modèle cible sur le modèle intermédiaire
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
