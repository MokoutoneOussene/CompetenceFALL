<?php

namespace Database\Factories\Finance;

use App\Models\Finance\Paiement;
use App\Models\Finance\Remboursement;
use Illuminate\Database\Eloquent\Factories\Factory;

class RemboursementFactory extends Factory
{
    protected $model = Remboursement::class;

    public function definition(): array
    {

        $paiement = Paiement::inRandomOrder()->first(['id', 'montant']);

        return [

            'paiement' => $paiement->id,
            'montant' => $paiement->montant / 2,
            'details' => $this->faker->paragraph(1, false),
            'statutAnnulation' => $this->faker->boolean(),
        ];
    }
}
