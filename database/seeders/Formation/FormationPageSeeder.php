<?php

namespace Database\Seeders\Formation;

use App\Models\Formation\FormationPage;
use App\Models\Formation\FormationPartie;
use Illuminate\Database\Seeder;

class FormationPageSeeder extends Seeder
{
    public function run()
    {

        $parties = FormationPartie::all(['id']);

        foreach ($parties as $partie) {
            FormationPage::factory(rand(1, 2))->create(['partie' => $partie->id]);
        }

        echo FormationPartie::count()." page(s) de parties créée(s).\n";
    }
}
