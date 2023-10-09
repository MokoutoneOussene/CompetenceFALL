<?php

namespace App\Models\Formation;

use App\Models\Systeme\Pays;
use App\Models\Systeme\Utilisateur;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FormationPresentielle extends Model
{
    use HasFactory;

    public $table = 'formation_presentielles';

    public $fillable = [

        'formation',
        'formateur',
        'prerequis',
        'dateDebut',
        'dateFin',
        'lieu',
        'pays',
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
     * Récupérer le formateur.
     *
     * @return BelongsTo $formateur
     *
     * @throws Exception $e
     */
    public function formateur(): BelongsTo
    {

        try {

            return $this->belongsTo(
                related: Utilisateur::class,
                foreignKey: 'formateur',
                ownerKey: 'id'
            );

        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Récupérer le pays.
     *
     * @return BelongsTo $pays
     *
     * @throws Exception $e
     */
    public function pays(): BelongsTo
    {

        try {

            return $this->belongsTo(
                related: Pays::class,
                foreignKey: 'pays',
                ownerKey: 'id'
            );

        } catch (Exception $e) {
            throw $e;
        }
    }
}
