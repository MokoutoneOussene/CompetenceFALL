<?php

namespace App\Models\Emploi;

use App\Models\Systeme\Pays;
use App\Models\Systeme\Utilisateur;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CandidatExperience extends Model
{
    use HasFactory;

    public $table = 'emploi_candidat_experiences';

    public $timestamps = false;

    protected $fillable = [
        'utilisateur',
        'poste',
        'domaineEtude',
        'duree',
        'dateDebut',
        'dateFin',
        'taches',
        'contrat',
        'organisation',
        'lieu',
        'pays',
        'typeLieu',
        'nomSuperieur',
        'prenomsSuperieur',
        'posteSuperieur',
        'indicatifTelephoniqueSuperieur',
        'telephoneSuperieur',
    ];

    protected $guarded = [];

    protected $hidden = [];

    // Relation avec Utilisateur
    public function utilisateur()
    {
        return $this->belongsTo(Utilisateur::class, 'utilisateur', 'id');
    }

    public function domaineEtude()
    {
        return $this->belongsTo(DomaineEtude::class, 'domaineEtude', 'id');
    }

    public function pays()
    {
        return $this->belongsTo(Pays::class, 'pays', 'id');
    }

    public function candidatures()
    {

        return $this->belongsToMany(
            related: Candidature::class, // Modèle cible
            table: 'emploi_candidature_experiences', // Table intermédiare
            foreignPivotKey: 'experience', // Clé étrangère du modèle principal sur le table intermédiaire
            relatedPivotKey: 'candidature', // Clé primaire du modèle cible sur la table intermédiaire
        )->withTimestamps();
    }
}
