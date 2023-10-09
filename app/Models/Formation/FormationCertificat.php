<?php

namespace App\Models\Formation;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FormationCertificat extends Model
{
    use HasFactory;

    public $table = 'formation_certificats';

    public $fillable = [

        'participant',
        'identifiant',
        'intitule',
        'domaine',
        'cheminCertificat',
        'auteurCreation',
        'auteurMiseAJour',
    ];

    public $hidden = [];

    public $guarded = [];

    /**
     * Récupérer le participant.
     *
     * @return BelongsTo $participant
     *
     * @throws Exception $e
     */
    public function participant(): BelongsTo
    {

        try {

            return $this->belongsTo(
                related: Participant::class,
                foreignKey: 'participant',
                ownerKey: 'id'
            );

        } catch (Exception $e) {
            throw $e;
        }
    }
}
