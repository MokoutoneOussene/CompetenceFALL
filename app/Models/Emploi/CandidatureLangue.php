<?php

namespace App\Models\Emploi;

use App\Jobs\Emploi\CalculerNoteCandidatureJob;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CandidatureLangue extends Model
{
    use HasFactory;

    protected $table = 'emploi_candidature_langues';

    public $timestamps = false;

    protected $fillable = [
        'candidature',
        'langue',
    ];

    public function candidature()
    {
        return $this->belongsTo(Candidature::class, 'candidature', 'id');
    }

    public function langue()
    {
        return $this->belongsTo(CandidatLangue::class, 'langue', 'id');
    }
}
