<?php

namespace App\Models\Newsletter;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NewsletterPage extends Model
{
    use HasFactory;

    public $table = 'newsletter_pages';

    public $fillable = [

        'article',
        'numeroOrdre',
        'intitule',
        'resume',
        'contenu',
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
                related: NewsletterArticle::class,
                foreignKey: 'article',
                ownerKey: 'id'
            );

        } catch (Exception $e) {
            throw $e;
        }
    }
}
