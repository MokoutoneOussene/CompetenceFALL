<?php

namespace App\Models\Emploi;

use App\Models\Systeme\Utilisateur;
use App\Traits\Pdf\PdfTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class CandidatDiplome extends Model
{
    use HasFactory, PdfTrait;

    public $table = 'emploi_candidat_diplomes';

    public $timestamps = false;

    protected $fillable = [
        'utilisateur',
        'statutObtention',
        'identifiant',
        'intitule',
        'domaineEtude',
        'niveauEtude',
        'niveauSpecialisation',
        'organisation',
        'dateDebut',
        'dateFin',
        'dateDelivrance',
        'slug'
    ];
    protected $guarded = [];

    protected $hidden = [
		'slug'
	];

	private function cheminDestination() : string {

		return "prive/utilisateurs/" . $this->utilisateur . "diplomes/";
	}

    public function utilisateur()
    {
        return $this->belongsTo(Utilisateur::class, 'utilisateur', 'id');
    }

    public function domaineEtude()
    {
        return $this->belongsTo(DomaineEtude::class, 'domaineEtude', 'id');
    }

    public function niveauEtude()
    {
        return $this->belongsTo(NiveauEtude::class, 'niveauEtude', 'id');
    }

    public function niveauSpecialisation()
    {
        return $this->belongsTo(NiveauSpecialisation::class, 'niveauSpecialisation', 'id');
    }

    public function typeEtude()
    {
        return $this->belongsTo(TypeEtude::class, 'typeEtude', 'id');
    }

    public function candidatures()
    {

        return $this->belongsToMany(
            related: Candidature::class,
            table: 'emploi_candidature_diplomes',
            foreignPivotKey: 'diplome',
            relatedPivotKey: 'candidature'
        );
    }
}
