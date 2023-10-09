<?php

namespace App\Models\Emploi;

use App\Jobs\Emploi\CalculerNoteCandidatureJob;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CandidatureCentre extends Model
{
    use HasFactory;

    protected $table = 'emploi_candidature_centres';

    public $timestamps = false;

    protected $fillable = [
        'candidature',
        'centre',
    ];

    public function candidature()
    {
        return $this->belongsTo(Candidature::class, 'candidature', 'id');
    }

    public function centre()
    {
        return $this->belongsTo(CandidatCentre::class, 'centre', 'id');
    }
}
