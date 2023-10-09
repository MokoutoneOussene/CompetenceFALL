<?php

namespace App\Models\Blog;

use App\Models\Systeme\Utilisateur;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BlogArticle extends Model
{
    use HasFactory;

    public $table = 'blog_articles';

    public $fillable = [

        'categorie',
        'intitule',
        'resume',
        'statutVisibilite',
        'auteurCreation',
        'auteurMiseAJour',
    ];

    public $guarded = [];

    public $hidden = [];

    /**
     * Récupérer la catégorie.
     *
     * @return BelongsTo $categorie
     *
     * @throws Exception $e
     */
    public function categorie(): BelongsTo
    {

        try {

            return $this->belongsTo(
                related: BlogCategorie::class,
                foreignKey: 'categorie',
                ownerKey: 'id'
            );

        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Récupérer les pages.
     *
     * @return HasMany $pages
     *
     * @throws Exception $e
     */
    public function pages(): HasMany
    {

        try {

            return $this->hasMany(
                related: BlogPage::class,
                foreignKey: 'article',
                localKey: 'id'
            );

        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Récupérer les médias.
     *
     * @return HasMany $medias
     *
     * @throws Exception $e
     */
    public function medias(): HasMany
    {

        try {

            return $this->hasMany(
                related: BlogMedia::class,
                foreignKey: 'article',
                localKey: 'id'
            );

        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Récupérer l'auteur de création.
     *
     * @return BelongsTo $auteurCreation
     *
     * @throws Exception $e
     */
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
     */
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
