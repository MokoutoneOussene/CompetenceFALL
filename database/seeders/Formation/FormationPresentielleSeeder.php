<?php

namespace Database\Seeders\Formation;

use App\Models\Formation\Formation;
use App\Models\Formation\FormationPresentielle;
use Illuminate\Database\Seeder;

class FormationPresentielleSeeder extends Seeder
{
    public function run()
    {

        $formations = Formation::where('typeFormation', 'presentielle')->get(['id']);

        foreach ($formations as $formation) {
            FormationPresentielle::factory(1)->create([
                'formation' => $formation->id,
            ]);
        }

        echo FormationPresentielle::count()." formation(s) présentielles créée(s).\n";
    }
}
