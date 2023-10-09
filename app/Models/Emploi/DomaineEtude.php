<?php

namespace App\Models\Emploi;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DomaineEtude extends Model
{
    use HasFactory;

    public $table = 'emploi_domaine_etudes';

    public $timestamps = false;

    protected $fillable = [
        'intitule',
        'description',
    ];

    public function prerequisDiplomes(): HasMany
    {
        return $this->hasMany(PrerequisDiplome::class, 'domaineEtude', 'id');
    }

    public function prerequisCertificats(): HasMany
    {
        return $this->hasMany(PrerequisCertificat::class, 'domaineEtude', 'id');
    }

    public function prerequisExperiences(): HasMany
    {
        return $this->hasMany(PrerequisExperience::class, 'domaineEtude', 'id');
    }

    public function candidatDiplomes(): HasMany
    {
        return $this->hasMany(CandidatDiplome::class, 'domaineEtude', 'id');
    }

    public function candidatCertificats(): HasMany
    {
        return $this->hasMany(CandidatCertificat::class, 'domaineEtude', 'id');
    }

    public function candidatExperiences(): HasMany
    {
        return $this->hasMany(CandidatExperience::class, 'domaineEtude', 'id');
    }
}
