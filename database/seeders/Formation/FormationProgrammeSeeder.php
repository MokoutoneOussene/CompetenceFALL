<?php

namespace Database\Seeders\Formation;

use App\Models\Formation\Formation;
use App\Models\Formation\FormationProgramme;
use Illuminate\Database\Seeder;

class FormationProgrammeSeeder extends Seeder
{
    public function run()
    {

        $formations = Formation::all(['id']);

        foreach ($formations as $formation) {
            FormationProgramme::factory(rand(1, 2))->create([
                'formation' => $formation->id,
            ]);
        }

        echo FormationProgramme::count()." programmes(s) de formations créé(s).\n";
    }
}
