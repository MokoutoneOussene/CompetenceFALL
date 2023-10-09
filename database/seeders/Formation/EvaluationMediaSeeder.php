<?php

namespace Database\Seeders\Formation;

use App\Models\Formation\Composition;
use App\Models\Formation\Evaluation;
use App\Models\Formation\EvaluationMedia;
use Illuminate\Database\Seeder;

class EvaluationMediaSeeder extends Seeder
{
    public function run()
    {

        $evaluations = Evaluation::all(['id']);

        foreach ($evaluations as $evaluation) {
            EvaluationMedia::factory(rand(1, 2))->create(['evaluation' => $evaluation->id]);
        }

        echo Composition::count()." média(s) d'évaluations créée(s).\n";
    }
}
