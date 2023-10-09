<?php

namespace Database\Seeders\Emploi;

use App\Models\Emploi\CandidatCentre;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CandidatCentreSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run()
    {
        CandidatCentre::factory()->createMany([

            ['intitule' => 'Musique'],
            ['intitule' => 'Lecture'],
            ['intitule' => 'Sports'],
            ['intitule' => 'Voyages'],
            ['intitule' => 'Cuisine'],
            ['intitule' => 'Cinéma'],
            ['intitule' => 'Randonnée'],
            ['intitule' => 'Photographie'],
            ['intitule' => 'Jardinage'],
            ['intitule' => 'Bénévolat'],
        ]);
    }
}
