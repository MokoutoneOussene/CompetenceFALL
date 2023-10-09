<?php

namespace App\Models\Service;

use App\Models\Systeme\Utilisateur;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Attestation extends Model
{
    use HasFactory;

    public $table = 'service_attestations';

    public $fillable = [

        'client',
        'numero',
        'intitule',
        'dateObtention',
        'cheminAttestation',
        'auteurCreation',
        'auteurMiseAJour',
    ];

    public $hidden = [];

    public $guarded = [];

    /**
     * Récupérer le client.
     *
     * @return BelongsTo $client
     *
     * @throws Exception $e
     */
    public function client(): BelongsTo
    {

        try {

            return $this->belongsTo(
                related: Utilisateur::class,
                foreignKey: 'client',
                ownerKey: 'id'
            );

        } catch (Exception $e) {
            throw $e;
        }
    }
}
