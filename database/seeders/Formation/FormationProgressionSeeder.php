<?php

namespace Database\Seeders\Formation;

use App\Models\Formation\FormationProgramme;
use App\Models\Formation\FormationProgression;
use App\Models\Formation\Participant;
use Illuminate\Database\Seeder;

class FormationProgressionSeeder extends Seeder
{
    public function run()
    {

        $participants = Participant::all();

        foreach ($participants as $participant) {

            $formation = $participant->formation()->first();

            $partie = $formation->parties()->inRandomOrder()->first();

            $page = $partie->pages()->inRandomOrder()->first();

            FormationProgression::factory(1)->create([
                'participant' => $participant->id,
                'page' => $page->id,
            ]);
        }

        echo FormationProgramme::count()." progression(s) de formations créé(s).\n";
    }
}
