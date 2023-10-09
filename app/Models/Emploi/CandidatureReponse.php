<?php

namespace App\Models\Emploi;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CandidatureReponse extends Model
{
    use HasFactory;

    protected $table = 'emploi_candidature_reponses';

    public $timestamps = false;

    protected $fillable = [
        'candidature',
        'question',
        'reponse',
        'contenu',
    ];

    public function candidature()
    {
        return $this->belongsTo(Candidature::class, 'candidature', 'id');
    }

    public function question()
    {
        return $this->belongsTo(QuestionOffre::class, 'question', 'id');
    }
}
