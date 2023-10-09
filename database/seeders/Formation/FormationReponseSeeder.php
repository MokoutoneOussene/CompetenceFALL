<?php

namespace Database\Seeders\Formation;

use App\Models\Formation\FormationProgramme;
use App\Models\Formation\FormationQuestion;
use App\Models\Formation\FormationReponse;
use Illuminate\Database\Seeder;

class FormationReponseSeeder extends Seeder
{
    public function run()
    {

        $questions = FormationQuestion::all(['id']);

        foreach ($questions as $question) {

            FormationReponse::factory(rand(1, 5))->create(['question' => $question->id]);
        }

        echo FormationProgramme::count()." question(s) d'évaluations de formations créé(s).\n";
    }
}
