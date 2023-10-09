<?php

namespace Database\Seeders\Emploi;

use App\Models\Emploi\CandidatDiplome;
use App\Models\Emploi\Candidature;
use App\Models\Emploi\CandidatureDiplome;
use App\Models\Emploi\DomaineEtude;
use App\Models\Emploi\NiveauEtude;
use App\Models\Emploi\NiveauSpecialisation;
use App\Models\Emploi\OffreEmploi;
use App\Models\Emploi\PrerequisDiplome;
use App\Models\Systeme\Utilisateur;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TestCalculNoteSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {

        // Créer une offre d'emploi.
        $offre = OffreEmploi::factory(1)->create([
            'poste' => 'TestCalcul',
        ])->first();

        // Choisir les attributs du diplome.
        $domaineEtude = DomaineEtude::where('intitule', "Sciences de l'ingénieur")->first();
        $niveauEtude = NiveauEtude::where('intitule', 'Enseignement supérieur -  Deuxième cycle')->first();
        $niveauSpecialisation = NiveauSpecialisation::where('intitule', 'Doctorat (Ph.D.) - Niveau BAC+8')->first();

        // Créer un préréquis pour l'offre d'emploi.
        PrerequisDiplome::factory(1)->create([

            'offre' => $offre->id,
            'domaineEtude' => $domaineEtude->id,
            'noteDomaine' => 10,
            'niveauEtude' => $niveauEtude->id,
            'noteNiveauEtude' => 10,
            'niveauSpecialisation' => $niveauSpecialisation->id,
            'noteSpecialisation' => 10,
        ])->first();

        // Choisir un candidat.
        $candidat = Utilisateur::inRandomOrder()->first();

        // Ajouter un diplome pour le candidat.
        $diplome = CandidatDiplome::factory(1)->create([

            'utilisateur' => $candidat->id,
            'intitule' => 'Doctorat en cybersécurité',
            'domaineEtude' => $domaineEtude->id,
            'niveauEtude' => NiveauEtude::where('intitule', 'Enseignement supérieur - Troisième cycle')->first()->id,
            'niveauSpecialisation' => NiveauSpecialisation::where('intitule', 'Lycée technique')->first()->id,
        ])->first();

        // Postuler à l'offre.
        $candidature = Candidature::factory(1)->create([

            'utilisateur' => $candidat->id,
            'offre' => $offre->id,
        ])->first();

        // Ajouter le diplome du candidat à la candidature.
        $diplomeCandidature = CandidatureDiplome::factory(1)->create([

            'candidature' => $candidature->id,
            'diplome' => $diplome->id,
        ])->first();

        // Calculer la note de la candidature.
        $candidature->calculerNote();

        // Afficher la note de la candidature après le calcul.
        echo "\n\n\nNote globale de la candidature après l'évaluation: ".$candidature->note;
    }
}
