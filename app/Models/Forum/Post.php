<?php

namespace App\Models\Forum;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Post extends Model
{
    use HasFactory;

    public $table = 'forum_posts';

    public $fillable = [

        'membre',
        'forum',
        'contenu',
        'statutVisibilite',
        'auteurCreation',
        'auteurMiseAJour',
    ];

    public $guarded = [];

    public $hidden = [];

    /**
     * Récupérer le membre.
     *
     * @return BelongsTo $membre
     *
     * @throws Exception $e
     * */
    public function membre(): BelongsTo
    {

        try {

            return $this->belongsTo(
                related: Membre::class,
                foreignKey: 'membre',
                ownerKey: 'id'
            );

        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Récupérer le forum.
     *
     * @return BelongsTo $forum
     *
     * @throws Exception $e
     * */
    public function forum(): BelongsTo
    {

        try {

            return $this->belongsTo(
                related: Forum::class,
                foreignKey: 'forum',
                ownerKey: 'id'
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
