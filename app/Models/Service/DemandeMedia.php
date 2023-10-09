<?php

namespace App\Models\Service;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DemandeMedia extends Model
{
    use HasFactory;

    public $table = 'service_demande_medias';

    public $fillable = [

        'demande',
        'nom',
        'chemin',
        'typeMime',
        'taille',
    ];

    public $hidden = [];

    public $guarded = [];

    /**
     * Récupérer la demande.
     *
     * @return BelongsTo $demande
     *
     * @throws Exception $e
     */
    public function demande(): BelongsTo
    {

        try {

            return $this->belongsTo(
                related: Demande::class,
                foreignKey: 'demande',
                ownerKey: 'id'
            );

        } catch (Exception $e) {
            throw $e;
        }
    }
}
