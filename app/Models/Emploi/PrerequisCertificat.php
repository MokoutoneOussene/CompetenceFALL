<?php

namespace App\Models\Emploi;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PrerequisCertificat extends Model
{
    use HasFactory;

    public $table = 'emploi_prerequis_certificats';

    public $timestamps = false;

    protected $fillable = [
        'offre',
        'domaineEtude',
        'noteDomaine',
    ];

    public function offreEmploi(): BelongsTo
    {
        return $this->belongsTo(OffreEmploi::class, 'offre', 'id');
    }

    public function domaineEtude(): BelongsTo
    {
        return $this->belongsTo(DomaineEtude::class, 'domaineEtude', 'id');
    }
}
