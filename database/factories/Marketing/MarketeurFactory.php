<?php

namespace Database\Factories\Marketing;

use App\Models\Marketing\Marketeur;
use App\Models\Systeme\Utilisateur;
use Illuminate\Database\Eloquent\Factories\Factory;

class MarketeurFactory extends Factory
{
    protected $model = Marketeur::class;

    public function definition()
    {

        return [

            'utilisateur' => Utilisateur::inRandomOrder()->first(['id'])->id,
            'intitule' => $this->faker->word(),
            'description' => $this->faker->paragraph(1, false),
            'code' => substr($this->faker->md5(), 0, 6),
            'statutActivation' => $this->faker->boolean(),
        ];
    }
}
