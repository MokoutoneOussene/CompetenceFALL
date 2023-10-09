<?php

namespace App\Models\Formation;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FormationQuestion extends Model
{
    use HasFactory;

    public $table = 'formation_questions';

    public $fillable = [

        'evaluation',
        'contenu',
        'typeQuestion',
    ];

    public $guarded = [];

    public $hidden = [];

    /**
     * Récupérer l'evaluation.
     *
     * @return BelongsTo $evaluation
     *
     * @throws Exception $e
     */
    public function evaluation(): BelongsTo
    {

        try {

            return $this->belongsTo(
                related: Evaluation::class,
                foreignKey: 'evaluation',
                ownerKey: 'id'
            );

        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Récupérer les reponses.
     *
     * @return HasMany $reponses
     *
     * @throws Exception $e
     */
    public function reponses(): HasMany
    {

        try {

            return $this->hasMany(
                related: FormationReponse::class,
                foreignKey: 'question',
                localKey: 'id'
            );

        } catch (Exception $e) {
            throw $e;
        }
    }
}
