<?php

namespace Database\Factories\Formation;

use App\Models\Formation\Evaluation;
use App\Models\Formation\FormationQuestion;
use Illuminate\Database\Eloquent\Factories\Factory;

class FormationQuestionFactory extends Factory
{
    protected $model = FormationQuestion::class;

    public function definition()
    {

        return [

            'evaluation' => Evaluation::inRandomOrder()->first(['id'])->id,
            'contenu' => $this->faker->paragraph(1, false),
            'typeQuestion' => $this->faker->randomElement([
                'vraiFaux', 'choixUnique', 'choixMultiple', 'reponseCourte',
            ]),
        ];
    }
}
