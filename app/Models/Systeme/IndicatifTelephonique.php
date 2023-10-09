<?php

namespace App\Models\Systeme;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class IndicatifTelephonique extends Model
{
    use HasFactory;

    public $table = 'systeme_indicatif_telephoniques';

    public $timestamps = false;

    public $fillable = ['pays', 'valeur'];

    /**
     * Récupérer le pays.
     *
     * @return BelongsTo $pays
     */
    public function pays(): BelongsTo
    {
        return $this->belongsTo(Pays::class, 'pays', 'id');
    }
}
