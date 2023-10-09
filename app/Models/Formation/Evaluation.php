<?php

namespace App\Models\Formation;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Evaluation extends Model
{
    use HasFactory;

    public $table = 'formation_evaluations';

    public $fillable = [

        'formation',
        'intitule',
        'description',
        'nombreQuestions',
        'nombreBonnesReponses',
        'duree',
        'dateDebutComposition',
        'dateFinComposition',
        'auteurCreation',
        'auteurMiseAJour',
    ];

    public $hidden = [];

    public $guarded = [];

    /**
     * Récupérer la formation.
     *
     * @return BelongsTo $formation
     *
     * @throws Exception $e
     */
    public function formation(): BelongsTo
    {

        try {

            return $this->belongsTo(
                related: Formation::class,
                foreignKey: 'formation',
                ownerKey: 'id'
            );

        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Récupérer les questions.
     *
     * @return HasMany $questions
     *
     * @throws Exception $e
     */
    public function questions(): HasMany
    {

        try {

            return $this->hasMany(
                related: FormationQuestion::class,
                foreignKey: 'evaluation',
                localKey: 'id'
            );

        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Récupérer les médias.
     *
     * @return HasMany $medias
     *
     * @throws Exception $e
     */
    public function medias(): HasMany
    {

        try {

            return $this->hasMany(
                related: EvaluationMedia::class,
                foreignKey: 'evaluation',
                localKey: 'id'
            );

        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Récupérer les compositions.
     *
     * @return HasMany $compositions
     *
     * @throws Exception $e
     */
    public function compositions(): HasMany
    {

        try {

            return $this->hasMany(
                related: Composition::class,
                foreignKey: 'evaluation',
                localKey: 'id'
            );

        } catch (Exception $e) {
            throw $e;
        }
    }
}
