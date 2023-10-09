<?php

namespace App\Models\Emploi;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PrerequisDiplome extends Model
{
    use HasFactory;

    public $table = 'emploi_prerequis_diplomes';

    public $timestamps = false;

    protected $fillable = [
        'offre',
        'domaineEtude',
        'noteDomaine',
        'niveauEtude',
        'niveauSpecialisation',
    ];

    public function offreEmploi(): BelongsTo
    {
        return $this->belongsTo(OffreEmploi::class, 'offre', 'id');
    }

    public function domaineEtude(): BelongsTo
    {
        return $this->belongsTo(DomaineEtude::class, 'domaineEtude', 'id');
    }

    public function niveauEtude(): BelongsTo
    {
        return $this->belongsTo(NiveauEtude::class, 'niveauEtude', 'id');
    }

    public function niveauSpecialisation(): BelongsTo
    {
        return $this->belongsTo(NiveauSpecialisation::class, 'niveauSpecialisation', 'id');
    }
}
