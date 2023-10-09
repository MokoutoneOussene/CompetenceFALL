<?php

namespace App\Models\Formation;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Composition extends Model
{
    use HasFactory;

    public $table = 'formation_compositions';

    public $fillable = [

        'participant',
        'evaluation',
        'noteObtenue',
        'dateDebut',
        'dateFin',
        'auteurCreation',
        'auteurMiseAJour',
    ];

    public $hidden = [];

    public $guarded = [];

    /**
     * Récupérer le participant.
     *
     * @return BelongsTo $participant
     *
     * @throws Exception $e
     */
    public function participant(): BelongsTo
    {

        try {

            return $this->belongsTo(
                related: Participant::class,
                foreignKey: 'participant',
                ownerKey: 'id'
            );

        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Récupérer l'évaluation.
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
     * Récupérer les questions tirées.
     *
     * @return HasMany $questionsTirees
     *
     * @throws Exception $e
     */
    public function questionsTirees(): HasMany
    {

        try {

            return $this->hasMany(
                related: Tirage::class,
                foreignKey: 'composition',
                localKey: 'id'
            );

        } catch (Exception $e) {
            throw $e;
        }
    }
}
