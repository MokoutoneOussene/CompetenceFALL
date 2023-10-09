<?php

namespace Database\Factories\Formation;

use App\Models\Formation\FormationQuestion;
use App\Models\Formation\FormationReponse;
use Illuminate\Database\Eloquent\Factories\Factory;

class FormationReponseFactory extends Factory
{
    protected $model = FormationReponse::class;

    public function definition()
    {

        return [

            'question' => FormationQuestion::inRandomOrder()->first(['id'])->id,
            'contenu' => $this->faker->word(),
            'bonneReponse' => $this->faker->boolean(),
        ];
    }
}
