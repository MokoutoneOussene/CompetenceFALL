<?php

namespace App\Models\Systeme;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FaqMedia extends Model
{
    use HasFactory;

    public $table = 'systeme_faq_medias';

    public $fillable = [

        'faq',
        'nom',
        'chemin',
        'typeMime',
        'taille',
    ];

    public $guarded = [];

    public $hidden = [];

    /**
     * Récupérer la foire aux questions associée
     *
     * @return BelongsTo $utilisateur
     *
     * @throws Exception $e
     */
    public function faq(): BelongsTo
    {

        try {

            return $this->belongsTo(
                related: Faq::class,
                foreignKey: 'faq',
                ownerKey: 'id'
            );

        } catch (Exception $e) {
            throw $e;
        }
    }
}
