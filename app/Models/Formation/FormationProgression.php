<?php

namespace App\Models\Formation;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FormationProgression extends Model
{
    use HasFactory;

    public $table = 'formation_progressions';

    public $fillable = [

        'participant',
        'page',
    ];

    public $hidden = [];

    public $guarded = [];

    /**
     * Récupérer le participant.
     *
     * @return BelongsTo $participant
     *
     * @throws Exception $e
     */
    public function participant(): BelongsTo
    {

        try {

            return $this->belongsTo(
                related: Participant::class,
                foreignKey: 'participant',
                ownerKey: 'id'
            );

        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Récupérer la page.
     *
     * @return BelongsTo $page
     *
     * @throws Exception $e
     */
    public function page(): BelongsTo
    {

        try {

            return $this->belongsTo(
                related: FormationPage::class,
                foreignKey: 'page',
                ownerKey: 'id'
            );

        } catch (Exception $e) {
            throw $e;
        }
    }
}
