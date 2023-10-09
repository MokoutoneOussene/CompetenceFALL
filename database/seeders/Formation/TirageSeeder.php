<?php

namespace Database\Seeders\Formation;

use App\Models\Formation\Composition;
use App\Models\Formation\Tirage;
use Illuminate\Database\Seeder;

class TirageSeeder extends Seeder
{
    public function run()
    {

        $compositions = Composition::all(['id', 'evaluation']);

        foreach ($compositions as $composition) {
            $evaluation = $composition->evaluation()->first();
            $questions = $evaluation->questions()->get(['id']);
            Tirage::factory(rand(1, 5))->create([
                'composition' => $composition->id,
                'question' => $questions->random()->id,
            ]);
        }

        echo Tirage::count()." tirage(s) de questions d'évaluations créé(s).\n";
    }
}
