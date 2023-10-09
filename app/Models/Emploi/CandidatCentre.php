<?php

namespace App\Models\Emploi;

use App\Models\Systeme\Utilisateur;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CandidatCentre extends Model
{
    use HasFactory;

    protected $table = 'emploi_candidat_centres';

    public $timestamps = false;

    protected $fillable = [
        'utilisateur',
        'description',
        'intitule',
    ];

    public function utilisateur()
    {
        return $this->belongsTo(Utilisateur::class, 'utilisateur', 'id');
    }

    public function candidatures()
    {

        return $this->belongsToMany(
            related: Candidature::class, // Modèle cible
            table: 'emploi_candidature_centres', // Table intermédiare
            foreignPivotKey: 'centre', // Clé étrangère du modèle principal sur le table intermédiaire
            relatedPivotKey: 'candidature', // Clé primaire du modèle cible sur la table intermédiaire
        )->withTimestamps();
    }
}
