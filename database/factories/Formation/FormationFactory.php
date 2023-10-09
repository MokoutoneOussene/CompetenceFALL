<?php

namespace Database\Factories\Formation;

use App\Models\Formation\Formation;
use Illuminate\Database\Eloquent\Factories\Factory;

class FormationFactory extends Factory
{
    protected $model = Formation::class;

    public function definition()
    {

        return [

            'intitule' => $this->faker->word(),
            'typeFormation' => $this->faker->randomElement(['enLigne', 'presentielle']),
            'description' => $this->faker->paragraph(1, false),
            'niveauDifficulte' => $this->faker->randomElement(['facile', 'intermediaire', 'avance']),
            'duree' => $this->faker->randomNumber(2),
            'cout' => $this->faker->randomNumber(5),
            'statutPublic' => $this->faker->boolean(),
            'statutActivation' => $this->faker->boolean(),
        ];
    }
}
