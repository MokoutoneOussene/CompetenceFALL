<?php

namespace Database\Factories\Formation;

use App\Models\Formation\Formation;
use App\Models\Formation\FormationProgramme;
use Illuminate\Database\Eloquent\Factories\Factory;

class FormationProgrammeFactory extends Factory
{
    protected $model = FormationProgramme::class;

    public function definition()
    {

        return [

            'formation' => Formation::inRandomOrder()->first(['id'])->id,
            'intitule' => $this->faker->word(),
            'details' => $this->faker->paragraph(1, false),
            'dateDebut' => $this->faker->dateTimeBetween('now', '+2 weeks'),
            'dateFin' => $this->faker->dateTimeBetween('+2 weeks', '+4 weeks'),
        ];
    }
}
