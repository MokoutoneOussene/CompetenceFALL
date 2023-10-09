<?php

namespace Database\Seeders\Formation;

use App\Models\Formation\Formation;
use App\Models\Formation\FormationMedia;
use Illuminate\Database\Seeder;

class FormationMediaSeeder extends Seeder
{
    public function run()
    {

        $formations = Formation::all(['id']);

        foreach ($formations as $formation) {
            FormationMedia::factory(rand(1, 2))->create(['formation' => $formation->id]);
        }

        echo FormationMedia::count()." média(s) pour les formations créé(s).\n";
    }
}
