<?php

namespace App\Models\Formation;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FormationPrerequis extends Model
{
    use HasFactory;

    public $table = 'formation_prerequis';

    public $timestamps = false;

    public $fillable = [

        'formation',
        'prerequis',
    ];

    public $hidden = [];

    public $guarded = [];

    /**
     * Récupérer la formation.
     *
     * @return BelongsTo $formation
     *
     * @throws Exception $e
     */
    public function formation(): BelongsTo
    {

        try {

            return $this->belongsTo(
                related: Formation::class,
                foreignKey: 'formation',
                ownerKey: 'id'
            );

        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Récupérer le prerequis.
     *
     * @return BelongsTo $prerequis
     *
     * @throws Exception $e
     */
    public function prerequis(): BelongsTo
    {

        try {

            return $this->belongsTo(
                related: Formation::class,
                foreignKey: 'prerequis',
                ownerKey: 'id'
            );

        } catch (Exception $e) {
            throw $e;
        }
    }
}
