<?php

namespace App\Models\Formation;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FormationProgramme extends Model
{
    use HasFactory;

    public $table = 'formation_programmes';

    public $fillable = [

        'formation',
        'intitule',
        'details',
        'dateDebut',
        'dateFin',
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
}
