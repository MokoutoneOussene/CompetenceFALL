<?php

namespace App\Models\Emploi;

use App\Jobs\Emploi\CalculerNoteCandidatureJob;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CandidaturePortfolio extends Model
{
    use HasFactory;

    protected $table = 'emploi_candidature_portfolios';

    public $timestamps = false;

    protected $fillable = [
        'candidature',
        'portfolio',
    ];

    public function candidature()
    {
        return $this->belongsTo(Candidature::class, 'candidature', 'id');
    }

    public function portfolio()
    {
        return $this->belongsTo(CandidatPortfolio::class, 'portfolio', 'id');
    }
}
