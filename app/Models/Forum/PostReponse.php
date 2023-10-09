<?php

namespace App\Models\Forum;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PostReponse extends Model
{
    use HasFactory;

    public $table = 'forum_post_reponses';

    public $fillable = [

        'post',
        'reponse',
    ];

    public $guarded = [];

    public $hidden = [];

    /**
     * Récupérer le post.
     *
     * @return BelongsTo $post
     *
     * @throws Exception $e
     * */
    public function post(): BelongsTo
    {

        try {

            return $this->belongsTo(
                related: Post::class,
                foreignKey: 'post',
                ownerKey: 'id'
            );

        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Récupérer la reponse.
     *
     * @return BelongsTo $reponse
     *
     * @throws Exception $e
     * */
    public function reponse(): BelongsTo
    {

        try {

            return $this->belongsTo(
                related: Post::class,
                foreignKey: 'reponse',
                ownerKey: 'id'
            );

        } catch (Exception $e) {
            throw $e;
        }
    }
}
