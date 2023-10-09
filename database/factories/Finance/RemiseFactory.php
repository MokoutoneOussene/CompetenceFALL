<?php

namespace Database\Factories\Finance;

use App\Models\Finance\Facture;
use App\Models\Finance\Remise;
use Illuminate\Database\Eloquent\Factories\Factory;

class RemiseFactory extends Factory
{
    protected $model = Remise::class;

    public function definition(): array
    {

        $facture = Facture::inRandomOrder()->first(['id'], 'montantTTC');
        $pourcentage = rand(2, 5);
        $montantRemise = $facture->montantTTC * $pourcentage / 100;

        return [

            'facture' => $facture->id,
            'intitule' => $this->faker->word(),
            'description' => $this->faker->paragraph(1, false),
            'pourcentage' => $pourcentage,
            'montant' => $montantRemise,
            'dateLimite' => $this->faker->dateTimeBetween('now', '+6 days'),
        ];
    }
}
