<?php

namespace Database\Factories\Systeme;

use App\Models\Systeme\Chiffre;
use Illuminate\Database\Eloquent\Factories\Factory;

class ChiffreFactory extends Factory
{
    protected $model = Chiffre::class;

    public function definition()
    {

        return [

            'intitule' => $this->faker->word(),
            'valeur' => $this->faker->randomNumber(4, false),
        ];
    }
}
