<?php

namespace Database\Factories\Marketing;

use App\Models\Marketing\Marketeur;
use App\Models\Marketing\MarketingPaiement;
use Illuminate\Database\Eloquent\Factories\Factory;

class MarketingPaiementFactory extends Factory
{
    protected $model = MarketingPaiement::class;

    public function definition()
    {

        return [

            'marketeur' => Marketeur::inRandomOrder()->first(['id'])->id,
            'montant' => $this->faker->randomNumber(3),
            'details' => $this->faker->paragraph(),
            'statut' => $this->faker->boolean(),
        ];
    }
}
