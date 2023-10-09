<?php

namespace App\Models\Formation;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EvaluationMedia extends Model
{
    use HasFactory;

    public $table = 'formation_evaluation_medias';

    public $fillable = [

        'evaluation',
        'nom',
        'typeMime',
        'chemin',
        'taille',
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
}
