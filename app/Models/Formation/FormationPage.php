<?php

namespace App\Models\Formation;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FormationPage extends Model
{
    use HasFactory;

    public $table = 'formation_pages';

    public $fillable = [

        'partie',
        'intitule',
        'numeroOrdre',
        'contenu',
    ];

    public $guarded = [];

    public $hidden = [];

    /**
     * Récupérer la partie.
     *
     * @return BelongsTo $partie
     *
     * @throws Exception $e
     */
    public function partie(): BelongsTo
    {

        try {

            return $this->belongsTo(
                related: FormationPartie::class,
                foreignKey: 'partie',
                ownerKey: 'id'
            );

        } catch (Exception $e) {
            throw $e;
        }
    }
}
