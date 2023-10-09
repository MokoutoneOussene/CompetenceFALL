<?php

namespace App\Models\Emploi;

use App\Jobs\Emploi\CalculerNoteCandidatureJob;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CandidatureReference extends Model
{
    use HasFactory;

    protected $table = 'emploi_candidature_references';

    public $timestamps = false;

    protected $fillable = [
        'candidature',
        'reference',
    ];

    public function candidature()
    {
        return $this->belongsTo(Candidature::class, 'candidature', 'id');
    }

    public function reference()
    {
        return $this->belongsTo(CandidatReference::class, 'reference', 'id');
    }
}
