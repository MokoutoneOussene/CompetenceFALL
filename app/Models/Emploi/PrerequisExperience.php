<?php

namespace App\Models\Emploi;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PrerequisExperience extends Model
{
    use HasFactory;

    public $table = 'emploi_prerequis_experiences';

    public $timestamps = false;

    protected $fillable = [
        'offre',
        'domaineEtude',
        'noteDomaine',
        'duree',
    ];

    protected $hidden = [];

    public function offreEmploi(): BelongsTo
    {
        return $this->belongsTo(OffreEmploi::class, 'offre', 'id');
    }

    public function domaineEtude(): BelongsTo
    {
        return $this->belongsTo(DomaineEtude::class, 'domaineEtude', 'id');
    }
}
