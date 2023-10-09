<?php

namespace App\Models\Emploi;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QuestionOffre extends Model
{
    use HasFactory;

    protected $table = 'emploi_question_offres';

    public $timestamps = false;

    protected $fillable = [

        'offre',
        'ordre',
        'contenu',
        'typeQuestion',
        'note',
        'bonneReponse',
    ];

    public function toArray()
    {

        $donnees = parent::toArray();

        if (isset($donnees['bonneReponse'])) {
            $donnees['bonneReponse'] = (bool) $donnees['bonneReponse'];
        }

        return $donnees;
    }

    public function offreEmploi(): BelongsTo
    {
        return $this->belongsTo(OffreEmploi::class, 'offre', 'id');
    }
}
