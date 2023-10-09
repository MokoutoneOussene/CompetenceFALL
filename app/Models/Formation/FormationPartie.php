<?php

namespace App\Models\Formation;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FormationPartie extends Model
{
    use HasFactory;

    public $table = 'formation_parties';

    public $fillable = [

        'formation',
        'intitule',
        'resume',
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
                related: FormationPage::class,
                foreignKey: 'partie',
                localKey: 'id'
            );

        } catch (Exception $e) {
            throw $e;
        }
    }
}
