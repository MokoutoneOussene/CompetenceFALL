<?php

namespace App\Models\Emploi;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class NiveauEtude extends Model
{
    use HasFactory;

    protected $table = 'emploi_niveau_etudes';

    public $timestamps = false;

    protected $fillable = [
        'intitule',
        'niveau',
        'description',
    ];

    public function prerequisDiplomes(): HasMany
    {
        return $this->hasMany(PrerequisDiplome::class, 'niveauEtude', 'id');
    }

    public function candidatDiplomes(): HasMany
    {
        return $this->hasMany(CandidatDiplome::class, 'niveauEtude', 'id');
    }
}
