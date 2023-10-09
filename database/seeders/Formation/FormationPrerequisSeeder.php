<?php

namespace Database\Seeders\Formation;

use App\Models\Formation\Formation;
use App\Models\Formation\FormationPrerequis;
use Illuminate\Database\Seeder;

class FormationPrerequisSeeder extends Seeder
{
    public function run()
    {

        $formations = Formation::where('typeFormation', 'enLigne')->get(['id']);

        foreach ($formations as $formation) {
            FormationPrerequis::factory(rand(1, 2))->create([
                'formation' => $formation->id,
                'prerequis' => Formation::where('typeFormation', 'enLigne')->inRandomOrder()->first(['id'])->id,
            ]);
        }

        echo FormationPrerequis::count()." préréqui(s) de formations créé(s).\n";
    }
}
