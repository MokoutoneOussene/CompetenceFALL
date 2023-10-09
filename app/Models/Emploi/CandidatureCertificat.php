<?php

namespace App\Models\Emploi;

use App\Jobs\Emploi\CalculerNoteCandidatureJob;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CandidatureCertificat extends Model
{
    use HasFactory;

    protected $table = 'emploi_candidature_certificats';

    public $timestamps = false;

    protected $fillable = [
        'candidature',
        'certificat',
    ];

    public function candidature()
    {
        return $this->belongsTo(Candidature::class, 'candidature', 'id');
    }

    public function certificat()
    {
        return $this->belongsTo(CandidatCertificat::class, 'certificat', 'id');
    }
}
