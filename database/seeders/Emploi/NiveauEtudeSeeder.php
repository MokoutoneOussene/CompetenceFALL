<?php

namespace Database\Seeders\Emploi;

use App\Models\Emploi\NiveauEtude;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NiveauEtudeSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run()
    {

        $niveauxEtudes = [
            [
                'intitule' => 'Collège',
                'niveau' => 1,
                'description' => "Niveau d'études correspondant au cycle collégial.",
            ],
            [
                'intitule' => 'Lycée',
                'niveau' => 4,
                'description' => "Niveau d'études correspondant au cycle lycéen.",
            ],
            [
                'intitule' => 'Premier cycle universitaire',
                'niveau' => 7,
                'description' => "Niveau d'études du premier cycle universitaire.",
            ],
            [
                'intitule' => 'Second cycle universitaire',
                'niveau' => 10,
                'description' => "Niveau d'études du second cycle universitaire.",
            ],
            [
                'intitule' => 'Troisième cycle universitaire',
                'niveau' => 12,
                'description' => "Niveau d'études du troisième cycle universitaire.",
            ],
            [
                'intitule' => 'Post-universitaire',
                'niveau' => 15,
                'description' => "Niveau d'études post-universitaire ou de spécialisation.",
            ],
        ];

        NiveauEtude::factory()->createMany($niveauxEtudes);
    }
}
