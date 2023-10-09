<?php

namespace App\Models\Emploi;

use App\Jobs\Emploi\CalculerNoteCandidatureJob;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CandidatureCompetence extends Model
{
    use HasFactory;

    protected $table = 'emploi_candidature_competences';

    public $timestamps = false;

    protected $fillable = [
        'candidature',
        'competence',
    ];

    public function candidature()
    {
        return $this->belongsTo(Candidature::class, 'candidature', 'id');
    }

    public function competence()
    {
        return $this->belongsTo(CandidatCompetence::class, 'competence', 'id');
    }
}
