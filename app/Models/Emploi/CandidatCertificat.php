<?php

namespace App\Models\Emploi;

use App\Models\Systeme\Utilisateur;
use App\Traits\Pdf\PdfTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CandidatCertificat extends Model
{
    use HasFactory, PdfTrait;

    public $table = 'emploi_candidat_certificats';

    public $timestamps = false;

    protected $fillable = [
        'utilisateur',
        'identifiant',
        'intitule',
        'domaineEtude',
        'organisation',
        'dateDebut',
        'dateFin',
        'dateDelivrance',
        'slug'
    ];

    protected $guarded = [];

    protected $hidden = [];

	private function cheminDestination() : string {

		return "prive/utilisateurs/" . $this->utilisateur . "certificats/";
	}

    public function utilisateur()
    {
        return $this->belongsTo(Utilisateur::class, 'utilisateur', 'id');
    }

    public function domaineEtude()
    {
        return $this->belongsTo(DomaineEtude::class, 'domaineEtude', 'id');
    }

    public function candidatures()
    {

        return $this->belongsToMany(
            related: Candidature::class, // Modèle cible
            table: 'emploi_candidature_certificats', // Table intermédiare
            foreignPivotKey: 'certificat', // Clé étrangère du modèle principal sur le table intermédiaire
            relatedPivotKey: 'candidature', // Clé primaire du modèle cible sur la table intermédiaire
        )->withTimestamps();
    }
}
