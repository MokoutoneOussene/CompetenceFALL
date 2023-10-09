<?php

namespace Database\Factories\Systeme;

use App\Models\Systeme\Session;
use App\Models\Systeme\Utilisateur;
use Illuminate\Database\Eloquent\Factories\Factory;

class SessionFactory extends Factory
{
    protected $model = Session::class;

    public function definition()
    {

        return [

            'utilisateur' => Utilisateur::inRandomOrder()->first(['id'])->id,
            'agent' => $this->faker->userAgent(),
            'ipv4' => $this->faker->ipv4(),
            'jeton' => $this->faker->unique()->uuid(),
            'dateExpiration' => $this->faker->dateTimeThisYear(),
        ];
    }
}
