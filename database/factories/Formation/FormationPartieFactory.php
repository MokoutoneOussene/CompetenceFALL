<?php

namespace Database\Factories\Formation;

use App\Models\Formation\Formation;
use App\Models\Formation\FormationPartie;
use Illuminate\Database\Eloquent\Factories\Factory;

class FormationPartieFactory extends Factory
{
    protected $model = FormationPartie::class;

    public function definition()
    {

        return [

            'formation' => Formation::inRandomOrder()->first(['id'])->id,
            'intitule' => $this->faker->word(),
            'resume' => $this->faker->paragraph(1, false),
        ];
    }
}
