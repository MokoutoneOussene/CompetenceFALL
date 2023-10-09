<?php

namespace App\Models\Systeme;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Organisation extends Model
{
    use HasFactory;

    public $table = 'systeme_organisations';

    public $fillable = [

        'utilisateur',
        'identifiant',
        'denomination',
        'statutJuridique',
        'domaine',
        'dateFondation',
        'capitalSocial',
        'nombreEmploye',
        'lieuSiege',
        'paysSiege',
    ];

    public $guarded = [];

    public $hidden = [];

    /**
     * Récupérer l'utilisateur associé à l'organisation
     *
     * @return BelongsTo $utilisateur
     *
     * @throws Exception $e
     */
    public function utilisateur(): BelongsTo
    {

        try {

            return $this->belongsTo(
                related: Utilisateur::class,
                foreignKey: 'utilisateur',
                ownerKey: 'id'
            );

        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Récupérer le pays de siège de l'organisation.
     *
     * @return BelongsTo $pays
     *
     * @throws Exception $e
     */
    public function paysSiege(): BelongsTo
    {

        try {

            return $this->belongsTo(
                related: Pays::class,
                foreignKey: 'paysSiege',
                ownerKey: 'id'
            );

        } catch (Exception $e) {
            throw $e;
        }
    }
}
