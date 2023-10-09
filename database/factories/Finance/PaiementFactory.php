<?php

namespace Database\Factories\Finance;

use App\Models\Finance\Facture;
use App\Models\Finance\Paiement;
use Illuminate\Database\Eloquent\Factories\Factory;

class PaiementFactory extends Factory
{
    protected $model = Paiement::class;

    public function definition()
    {

        $facture = Facture::inRandomOrder()->first(['id', 'montantTTC']);

        $montantRemise = $this->faker->numberBetween((int) $facture->montantTTC / 4, (int) $facture->montantTTC / 2);

        $montantPaye = (int) $facture->montantTTC - $montantRemise;

        return [

            'facture' => $facture->id,
            'mode' => $this->faker->randomElement(['especes', 'mobileMoney', 'virementBancaire', 'carteCredit', 'chequeBancaire']),
            'details' => $this->faker->paragraph(1, false),
            'montant' => $montantPaye,
            'statutAnnulation' => $this->faker->boolean(),
            'motifAnnulation' => $this->faker->paragraph(1, false),
        ];
    }
}
