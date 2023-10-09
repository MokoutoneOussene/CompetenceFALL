<?php

namespace App\Models\Emploi;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CandidatureCv extends Model
{
    use HasFactory;

    protected $table = 'emploi_candidature_cvs';

    public $timestamps = false;

    protected $fillable = [
        'candidature',
        'cv'
    ];

    public function candidature()
    {
        return $this->belongsTo(Candidature::class, 'candidature', 'id');
    }

    public function cv()
    {
        return $this->belongsTo(CandidatCv::class, 'cv', 'id');
    }
}
