<?php

namespace Database\Seeders\Formation;

use App\Models\Formation\Evaluation;
use App\Models\Formation\FormationQuestion;
use Illuminate\Database\Seeder;

class FormationQuestionSeeder extends Seeder
{
    public function run()
    {

        $evaluations = Evaluation::all(['id']);

        foreach ($evaluations as $evaluation) {

            FormationQuestion::factory(rand(1, 5))->create([
                'evaluation' => $evaluation->id,
            ]);
        }

        echo FormationQuestion::count()." question(s) d'évaluations créé(s).\n";
    }
}
