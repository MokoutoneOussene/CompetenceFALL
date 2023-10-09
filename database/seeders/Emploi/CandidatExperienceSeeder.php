<?php

namespace Database\Seeders\Emploi;

use App\Models\Emploi\CandidatExperience;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CandidatExperienceSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run()
    {
        CandidatExperience::factory()->createMany([

            ['poste' => 'Infirmier(ère) en soins de santé'],
            ['poste' => 'Enseignant(e) de maternelle'],
            ['poste' => 'Ingénieur(e) civil(e)'],
            ['poste' => 'Comptable'],
            ['poste' => 'Conseiller(ère) financier(ère)'],
            ['poste' => 'Avocat(e)'],
            ['poste' => 'Analyste de marché'],
            ['poste' => 'Architecte'],
            ['poste' => 'Chef cuisinier(ère)'],
            ['poste' => 'Pharmacien(ne)'],
            ['poste' => 'Agent immobilier'],
            ['poste' => 'Psychologue clinicien(ne)'],
            ['poste' => "Enseignant(e) d'éducation physique"],
            ['poste' => 'Agent de voyages'],
            ['poste' => 'Mécanicien(ne) automobile'],
            ['poste' => 'Gestionnaire de projet de construction'],
            ['poste' => 'Infirmier(ère) pédiatrique'],
            ['poste' => 'Artiste peintre'],
            ['poste' => 'Journaliste'],
            ['poste' => 'Responsable des ressources humaines'],
        ]);
    }
}
