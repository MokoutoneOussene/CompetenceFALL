<?php

namespace Database\Seeders\Formation;

use App\Models\Formation\Evaluation;
use App\Models\Formation\Formation;
use Illuminate\Database\Seeder;

class EvaluationSeeder extends Seeder
{
    public function run()
    {

        $formations = Formation::all(['id']);

        foreach ($formations as $formation) {

            Evaluation::factory(rand(1, 2))->create(['formation' => $formation->id]);
        }

        echo Evaluation::count()." évaluation(s) créé(s).\n";
    }
}
