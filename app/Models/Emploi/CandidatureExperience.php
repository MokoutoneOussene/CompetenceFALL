<?php

namespace App\Models\Emploi;

use App\Jobs\Emploi\CalculerNoteCandidatureJob;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CandidatureExperience extends Model
{
    use HasFactory;

    protected $table = 'emploi_candidature_experiences';

    public $timestamps = false;

    protected $fillable = [
        'candidature',
        'experience',
    ];

    public function candidature()
    {
        return $this->belongsTo(Candidature::class, 'candidature', 'id');
    }

    public function experience()
    {
        return $this->belongsTo(CandidatExperience::class, 'experience', 'id');
    }
}
