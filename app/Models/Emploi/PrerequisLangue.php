<?php

namespace App\Models\Emploi;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PrerequisLangue extends Model
{
    use HasFactory;

    protected $table = 'emploi_prerequis_langues';

    public $timestamps = false;

    protected $fillable = [

        'offre',
        'intitule',
        'noteLangue',
        'niveau',
        'noteNiveau',
        'statutParle',
        'noteStatutParle',
        'statutLu',
        'noteStatutLu',
        'statutEcrit',
        'noteStatutEcrit',
    ];

    public function offreEmploi(): BelongsTo
    {
        return $this->belongsTo(OffreEmploi::class, 'offre', 'id');
    }
}
