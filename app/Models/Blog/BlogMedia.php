<?php

namespace App\Models\Blog;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BlogMedia extends Model
{
    use HasFactory;

    public $table = 'blog_medias';

    public $fillable = [

        'article',
        'nom',
        'typeMime',
        'chemin',
        'taille',
    ];

    public $guarded = [];

    public $hidden = [];

    /**
     * Récupérer l'article.
     *
     * @return BelongsTo $article
     *
     * @throws Exception $e
     */
    public function article(): BelongsTo
    {

        try {

            return $this->belongsTo(
                related: BlogArticle::class,
                foreignKey: 'article',
                ownerKey: 'id'
            );

        } catch (Exception $e) {
            throw $e;
        }
    }
}
