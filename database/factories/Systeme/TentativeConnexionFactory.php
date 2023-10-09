<?php

namespace Database\Factories\Systeme;

use App\Models\Systeme\TentativeConnexion;
use App\Models\Systeme\Utilisateur;
use Illuminate\Database\Eloquent\Factories\Factory;

class TentativeConnexionFactory extends Factory
{
    protected $model = TentativeConnexion::class;

    public function definition()
    {

        return [
            'utilisateur' => Utilisateur::inRandomOrder()->first(['id'])->id,
            'agent' => $this->faker->userAgent,
            'ipv4' => $this->faker->ipv4,
        ];
    }
}
