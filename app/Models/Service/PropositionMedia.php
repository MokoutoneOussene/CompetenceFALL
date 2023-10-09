<?php

namespace App\Models\Service;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PropositionMedia extends Model
{
    use HasFactory;

    public $table = 'service_proposition_medias';

    public $fillable = [

        'proposition',
        'nom',
        'chemin',
        'typeMime',
        'taille',
    ];

    public $hidden = [];

    public $guarded = [];

    /**
     * Récupérer la proposition.
     *
     * @return BelongsTo $proposition
     *
     * @throws Exception $e
     */
    public function proposition(): BelongsTo
    {

        try {

            return $this->belongsTo(
                related: Proposition::class,
                foreignKey: 'proposition',
                ownerKey: 'id'
            );

        } catch (Exception $e) {
            throw $e;
        }
    }
}
