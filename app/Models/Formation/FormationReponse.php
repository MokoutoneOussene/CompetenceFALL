<?php

namespace App\Models\Formation;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FormationReponse extends Model
{
    use HasFactory;

    public $table = 'formation_reponses';

    public $fillable = [

        'question',
        'contenu',
        'bonneReponse',
    ];

    public $hidden = [];

    public $guarded = [];

    /**
     * Récupérer la question.
     *
     * @return BelongsTo $question
     *
     * @throws Exception $e
     */
    public function question(): BelongsTo
    {

        try {

            return $this->belongsTo(
                related: FormationQuestion::class,
                foreignKey: 'question',
                ownerKey: 'id'
            );

        } catch (Exception $e) {
            throw $e;
        }
    }
}
