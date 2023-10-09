<?php

namespace App\Models\Formation;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Tirage extends Model
{
    use HasFactory;

    public $table = 'formation_tirages';

    public $fillable = [

        'composition',
        'question',
        'ordreTirage',
        'dateEnvoiQuestion',
        'dateRetourReponse',
        'reponseTexte',
        'reponseTrouvee',
    ];

    public $hidden = [];

    public $guarded = [];

    /**
     * Récupérer la composition.
     *
     * @return BelongsTo $composition
     *
     * @throws Exception $e
     */
    public function composition(): BelongsTo
    {

        try {

            return $this->belongsTo(
                related: Composition::class,
                foreignKey: 'composition',
                ownerKey: 'id'
            );

        } catch (Exception $e) {
            throw $e;
        }
    }

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
