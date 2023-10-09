<?php

namespace App\Models\Systeme;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TentativeConnexion extends Model
{
    use HasFactory;

    public $table = 'systeme_tentative_connexions';

    public $fillable = [

        'utilisateur',
        'agent',
        'ipv4',
    ];

    public $guarded = [];

    public $hidden = [];

    /**
     * Récupérer l'utilisateur associé
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
}
