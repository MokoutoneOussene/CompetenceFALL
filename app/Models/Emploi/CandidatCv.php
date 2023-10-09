<?php

namespace App\Models\Emploi;

use App\Models\Systeme\Utilisateur;
use App\Traits\Pdf\PdfTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CandidatCv extends Model
{
    use HasFactory, PdfTrait;

    public $table = 'emploi_candidat_cvs';

    public $timestamps = false;

    protected $fillable = [
        'utilisateur',
        'intitule',
        'slug'
    ];

	private function cheminDestination() : string {

		return "prive/utilisateurs/" . $this->utilisateur . "cvs/";
	}

    public function utilisateur(): BelongsTo
    {
        return $this->belongsTo(Utilisateur::class, 'utilisateur', 'id');
    }
}
