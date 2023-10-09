<?php

namespace App\Models\Emploi;

use App\Models\Systeme\Utilisateur;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CandidatLangue extends Model
{
    use HasFactory;

    protected $table = 'emploi_candidat_langues';

    public $timestamps = false;

    protected $fillable = [
        'utilisateur',
        'intitule',
        'niveau',
        'statutParle',
        'statutLu',
        'statutEcrit',
    ];

    public function utilisateur()
    {
        return $this->belongsTo(Utilisateur::class, 'utilisateur', 'id');
    }

    public function candidatures()
    {

        return $this->belongsToMany(
            related: Candidature::class, // Modèle cible
            table: 'emploi_candidature_langues', // Table intermédiare
            foreignPivotKey: 'langue', // Clé étrangère du modèle principal sur le table intermédiaire
            relatedPivotKey: 'candidature', // Clé primaire du modèle cible sur la table intermédiaire
        );
    }
}
