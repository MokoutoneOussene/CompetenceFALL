<?php

namespace Database\Factories\Interface;

use Illuminate\Database\Eloquent\Factories\Factory;

class ApplicationFactory extends Factory
{
    public function definition(): array
    {

        return [

            'denomination' => $this->faker->word(),
            'jeton' => $this->faker->uuid(),
            'statutActivation' => $this->faker->boolean(),
            'dateExpiration' => $this->faker->dateTimeThisCentury('2050-12-31 00:00:00'),
        ];
    }
}
