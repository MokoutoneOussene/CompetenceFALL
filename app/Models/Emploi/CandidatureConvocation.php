<?php

namespace App\Models\Emploi;

use App\Models\Systeme\Pays;
use App\Models\Systeme\Utilisateur;
use App\Traits\Pdf\PdfTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CandidatureConvocation extends Model
{
    use HasFactory, PdfTrait;

    protected $table = 'emploi_convocations';

    public $timestamps = false;

    protected $fillable = [
        'candidature',
        'objet',
        'lieu',
        'pays',
        'adresse',
        'date',
        'consignes',
        'indicatifTelephonique',
        'telephone',
        'auteurCreation',
        'auteurMiseAJour',
    ];

	public function retournerCheminPdf() : string {

		return "prive/emplois/" . $this->candidature()->first(['offre'])->offre . "/candidats/"
			. $this->utilisateur . "/convocations/";
	}

	public function retournerNomPdf() : string {

		return "convocation_" . date('Y') . '_' . date('m') . '_' . date('d') .
			'_' . date('H') . '_' . date('i') . '_' . date('s') . '.pdf';
	}

	private string $vueBlade = 'pdfs.emplois.convocations.test-convocation';

    public function candidature()
    {
        return $this->belongsTo(Candidature::class, 'candidature', 'id');
    }

    public function pays()
    {
        return $this->belongsTo(Pays::class, 'pays', 'id');
    }

    public function auteurCreation()
    {
        return $this->belongsTo(Utilisateur::class, 'auteurCreation', 'id');
    }

    public function auteurMiseAJour()
    {
        return $this->belongsTo(Utilisateur::class, 'auteurMiseAJour', 'id');
    }
}
