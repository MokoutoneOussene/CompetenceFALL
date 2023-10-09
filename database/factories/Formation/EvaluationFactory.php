<?php

namespace Database\Factories\Formation;

use App\Models\Formation\Evaluation;
use App\Models\Formation\Formation;
use Illuminate\Database\Eloquent\Factories\Factory;

class EvaluationFactory extends Factory
{
    protected $model = Evaluation::class;

    public function definition()
    {

        $nombreQuestions = $this->faker->numberBetween(1, 100);
        $nombreBonnesReponses = $this->faker->numberBetween($nombreQuestions / 2, $nombreQuestions);
        $dateDebutComposition = $this->faker->dateTimeBetween('now', '+2 weeks');
        $dateFinComposition = $this->faker->dateTimeBetween($dateDebutComposition, '+2 weeks');

        return [

            'formation' => Formation::inRandomOrder()->first(['id'])->id,
            'intitule' => $this->faker->word(),
            'description' => $this->faker->paragraph(1, false),
            'nombreQuestions' => $nombreQuestions,
            'nombreBonnesReponses' => $nombreBonnesReponses,
            'duree' => $this->faker->numberBetween(1, 3),
            'dateDebutComposition' => $dateDebutComposition,
            'dateFinComposition' => $dateFinComposition,
        ];
    }
}
