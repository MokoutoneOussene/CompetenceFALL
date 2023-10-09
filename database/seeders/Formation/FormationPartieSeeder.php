<?php

namespace Database\Seeders\Formation;

use App\Models\Formation\Formation;
use App\Models\Formation\FormationPartie;
use Illuminate\Database\Seeder;

class FormationPartieSeeder extends Seeder
{
    public function run()
    {

        $formations = Formation::all(['id']);

        foreach ($formations as $formation) {
            FormationPartie::factory(rand(1, 2))->create(['formation' => $formation->id]);
        }

        echo FormationPartie::count()." partie(s) de formations créée(s).\n";
    }
}
