<?php

namespace App\Models\Forum;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Signalement extends Model
{
    use HasFactory;

    public $table = 'forum_signalements';

    public $fillable = [

        'membre',
        'post',
        'motif',
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
     * Récupérer le post.
     *
     * @return BelongsTo $forum
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
}
