<?php

namespace Database\Factories\Systeme;

use App\Models\Systeme\Parametre;
use Illuminate\Database\Eloquent\Factories\Factory;

class ParametreFactory extends Factory
{
    protected $model = Parametre::class;

    public function definition()
    {

        return [

            'intitule' => $this->faker->word(),
            'valeur' => $this->faker->randomDigit(),
            'categorie' => $this->faker->randomElement(['systeme', 'finance', 'service', 'emploi', 'forum', 'blog', 'newsletter']),
            'description' => $this->faker->paragraph(1, false),
        ];
    }
}
