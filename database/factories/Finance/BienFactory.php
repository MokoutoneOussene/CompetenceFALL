<?php

namespace Database\Factories\Finance;

use App\Models\Finance\Bien;
use App\Models\Finance\Facture;
use Illuminate\Database\Eloquent\Factories\Factory;

class BienFactory extends Factory
{
    protected $model = Bien::class;

    public function definition(): array
    {

        $prixUnitaire = $this->faker->numberBetween(1000, 5000);
        $quantite = rand(1, 10);

        return [

            'facture' => Facture::inRandomOrder()->first(['id'])->id,
            'numeroOrdre' => rand(1, 1000),
            'designation' => $this->faker->word(),
            'unite' => $this->faker->randomElement(['m', 'l', '-', 'kg']),
            'quantite' => $quantite,
            'priUnitaire' => $prixUnitaire,
            'montant' => $prixUnitaire * $quantite,
        ];
    }
}
