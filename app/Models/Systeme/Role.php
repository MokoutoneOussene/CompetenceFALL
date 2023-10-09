<?php

namespace App\Models\Systeme;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Role extends Model
{
    use HasFactory;

    public $table = 'systeme_roles';

    public $timestamps = false;

    public $fillable = [

        'iconeRole',
        'intitule',
        'slug',
        'categorie',
        'description',
        'nombreUtilisateursLimite',
    ];

    public $guarded = [];

    public $hidden = [];

    /**
     * Récupérer tous les utilisateurs du role
     *
     * @return BelongsToMany $utilisateurs
     *
     * @throws Exception $e
     */
    public function utilisateurs(): BelongsToMany
    {

        try {

            return $this->belongsToMany(
                related: Utilisateur::class, // Modèle cible
                table: 'systeme_privileges', // Table intermédiare
                foreignPivotKey: 'role', // Clé étrangère du modèle principal sur le table intermédiaire
                relatedPivotKey: 'utilisateur', // Clé primaire du modèle cible sur la table intermédiaire
            )->withTimestamps();

        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Récupérer tous les privileges associés au role
     *
     * @return HasMany $privileges
     *
     * @throws Exception $e
     */
    public function privileges(): HasMany
    {

        try {

            return $this->hasMany(
                related: Utilisateur::class,
                foreignKey: Privilege::class,
                localKey: 'id',
            );

        } catch (Exception $e) {
            throw $e;
        }
    }
}
