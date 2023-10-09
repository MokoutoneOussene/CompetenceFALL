<?php

namespace App\Models\Emploi;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CandidatureDiplome extends Model
{
    use HasFactory;

    protected $table = 'emploi_candidature_diplomes';

    public $timestamps = false;

    protected $fillable = [
        'candidature',
        'diplome',
    ];

    public function candidature()
    {
        return $this->belongsTo(Candidature::class, 'candidature', 'id');
    }

    public function diplome()
    {
        return $this->belongsTo(CandidatDiplome::class, 'diplome', 'id');
    }
}
