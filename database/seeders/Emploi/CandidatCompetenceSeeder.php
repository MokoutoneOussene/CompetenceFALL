<?php

namespace Database\Seeders\Emploi;

use App\Models\Emploi\CandidatCompetence;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CandidatCompetenceSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run()
    {
        CandidatCompetence::factory()->createMany([

            ['intitule' => 'Gestion du temps'],
            ['intitule' => 'Résolution de problèmes'],
            ['intitule' => 'Communication efficace'],
            ['intitule' => "Travail d'équipe"],
            ['intitule' => 'Leadership'],
            ['intitule' => 'Compétences en informatique'],
            ['intitule' => 'Analyse de données'],
            ['intitule' => 'Gestion de projet'],
            ['intitule' => 'Adaptabilité'],
            ['intitule' => 'Créativité'],
            ['intitule' => 'Prise de décision'],
            ['intitule' => 'Compétences en négociation'],
            ['intitule' => 'Rédaction professionnelle'],
            ['intitule' => 'Compétences en présentation'],
            ['intitule' => 'Gestion du stress'],
            ['intitule' => 'Pensée critique'],
            ['intitule' => 'Compétences en recherche'],
            ['intitule' => 'Compétences interpersonnelles'],
            ['intitule' => 'Compétences en planification'],
            ['intitule' => 'Compétences en résolution de conflits'],
        ]);
    }
}
