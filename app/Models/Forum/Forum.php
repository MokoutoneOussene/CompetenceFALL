<?php

namespace App\Models\Forum;

use App\Models\Systeme\Utilisateur;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Forum extends Model
{
    use HasFactory;

    public $table = 'forum_forums';

    public $fillable = [

        'intitule',
        'theme',
        'description',
        'regles',
        'auteurCreation',
        'auteurMiseAJour',
    ];

    public $guarded = [];

    public $hidden = [];

    /**
     * Récupérer les posts.
     *
     * @return HasMany $posts
     *
     * @throws Exception $e
     * */
    public function posts(): HasMany
    {

        try {

            return $this->hasMany(
                related: Post::class,
                foreignKey: 'forum',
                localKey: 'id'
            );

        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Récupérer les utilisateurs.
     *
     * @return HasManyThrough $utilisateurs
     *
     * @throws Exception $e
     */
    public function utilisateurs(): HasManyThrough
    {

        try {

            return $this->hasManyThrough(
                related: Utilisateur::class, // Modèle cible
                through: Membre::class, // Modèle intermédiaire
                firstKey: 'forum', // Clé étrangère du modèle principal sur le modèle intermédiaire
                secondKey: 'id', // Clé primaire du modèle cible
                localKey: 'id', // Clé primaire du modèle principal
                secondLocalKey: 'utilisateur' // Clé étrangère du modèle cible sur le modèle intermédiaire
            );

        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Récupérer l'auteur de la création.
     *
     * @return BelongsTo $auteurCreation
     *
     * @throws Exception $e
     * */
    public function auteurCreation(): BelongsTo
    {

        try {

            return $this->belongsTo(
                related: Utilisateur::class,
                foreignKey: 'auteurCreation',
                ownerKey: 'id'
            );

        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Récupérer l'auteur de la mise à jour.
     *
     * @return BelongsTo $auteurMiseAJour
     *
     * @throws Exception $e
     * */
    public function auteurMiseAJour(): BelongsTo
    {

        try {

            return $this->belongsTo(
                related: Utilisateur::class,
                foreignKey: 'auteurMiseAJour',
                ownerKey: 'id'
            );

        } catch (Exception $e) {
            throw $e;
        }
    }
}
