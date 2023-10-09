<?php

namespace Database\Factories\Formation;

use App\Models\Formation\FormationPage;
use App\Models\Formation\FormationPartie;
use Illuminate\Database\Eloquent\Factories\Factory;

class FormationPageFactory extends Factory
{
    protected $model = FormationPage::class;

    public function definition()
    {

        return [

            'partie' => FormationPartie::inRandomOrder()->first(['id'])->id,
            'intitule' => $this->faker->word(),
            'numeroOrdre' => $this->faker->randomNumber(3),
            'contenu' => $this->faker->paragraph(1, false),
        ];
    }
}
