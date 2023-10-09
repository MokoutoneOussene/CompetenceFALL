<?php

namespace App\Models\Systeme;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Log extends Model
{
    use HasFactory;

    public $table = 'systeme_logs';

    public $fillable = [

        'utilisateur',
        'action',
        'champs',
        'details',
    ];

    public $guarded = [];

    public $hidden = [];

    /**
     * Récupérer l'utilisateur d'une activité.
     *
     * @return BelongsTo $utilisateur
     *
     * @throws Exception $e
     */
    public function utilisateur(): BelongsTo
    {

        try {

            return $this->belongsTo(
                related: Utilisateur::class,
                foreignKey: 'utilisateur',
                ownerKey: 'id'
            );

        } catch (Exception $e) {
            throw $e;
        }
    }
}
