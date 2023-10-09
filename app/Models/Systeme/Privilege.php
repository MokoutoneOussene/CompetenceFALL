<?php

namespace App\Models\Systeme;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Privilege extends Model
{
    use HasFactory;

    public $table = 'systeme_privileges';

    public $fillable = [

        'utilisateur',
        'role',
        'statutActivation',
    ];

    public $guarded = [];

    public $hidden = [];

    /**
     * Récupérer l'utilisateur lié au privilège.
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
     * Récupérer le rôle lié au privilège.
     *
     * @return BelongsTo $role
     *
     * @throws Exception $e
     */
    public function role(): BelongsTo
    {

        try {

            return $this->belongsTo(
                related: Role::class,
                foreignKey: 'role',
                ownerKey: 'id'
            );

        } catch (Exception $e) {
            throw $e;
        }
    }
}
