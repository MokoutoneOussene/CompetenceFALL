<?php

namespace Database\Factories\Systeme;

use App\Models\Systeme\IndicatifTelephonique;
use App\Models\Systeme\Pays;
use Illuminate\Database\Eloquent\Factories\Factory;

class IndicatifTelephoniqueFactory extends Factory
{
    protected $model = IndicatifTelephonique::class;

    public function definition()
    {
        return [

            'pays' => Pays::inRandomOrder()->first(['id'])->id,
            'valeur' => $this->faker->unique()->randomNumber(3, false),
        ];
    }
}
