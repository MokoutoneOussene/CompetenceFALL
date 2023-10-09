<?php

namespace App\Models\Emploi;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class NiveauSpecialisation extends Model
{
    use HasFactory;

    protected $table = 'emploi_niveau_specialisations';

    public $timestamps = false;

    protected $fillable = [
        'intitule',
        'niveau',
        'abreviation',
        'description',
    ];

    public function prerequisDiplomes(): HasMany
    {
        return $this->hasMany(PrerequisDiplome::class, 'niveauSpecialisation', 'id');
    }

    public function candidatDiplomes(): HasMany
    {
        return $this->hasMany(CandidatDiplome::class, 'niveauSpecialisation', 'id');
    }
}
