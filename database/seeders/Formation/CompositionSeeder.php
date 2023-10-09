<?php

namespace Database\Seeders\Formation;

use App\Models\Formation\Composition;
use App\Models\Formation\Evaluation;
use App\Models\Formation\Participant;
use Illuminate\Database\Seeder;

class CompositionSeeder extends Seeder
{
    public function run()
    {

        $evaluations = Evaluation::all(['id']);

        foreach ($evaluations as $evaluation) {

            Composition::factory(rand(1, 2))->create([
                'evaluation' => $evaluation->id,
                'participant' => Participant::inRandomOrder()->first(['id'])->id,
            ]);
        }

        echo Composition::count()." composition(s) d'évaluations créée(s).\n";
    }
}
