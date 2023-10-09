<?php

namespace Database\Factories\Finance;

use App\Models\Finance\Facture;
use App\Models\Systeme\Utilisateur;
use Illuminate\Database\Eloquent\Factories\Factory;

class FactureFactory extends Factory
{
    protected $model = Facture::class;

    public function definition()
    {

        $montantHT = $this->faker->randomNumber(4, false);
        $tauxTva = rand(1, 3);
        $montantTva = $montantHT * $tauxTva / 100;
        $montantTTC = $montantHT + $montantTva;

        return [

            'client' => Utilisateur::inRandomOrder()->first(['id'])->id,
            'numeroFacture' => now()->format('YmdHis').rand(0, 9),
            'statutTraitement' => $this->faker->randomElement([
                'enAttente', 'valide', 'paye', 'annule', 'EnLitige', 'echue',
            ]),
            'montantHT' => $montantHT,
            'statutApplicationTva' => $this->faker->boolean(),
            'tauxTva' => $tauxTva,
            'montantTva' => $montantTva,
            'montantTTC' => $montantTTC,
            'modePaiement' => $this->faker->randomElement([
                'especes', 'mobileMoney', 'virementBancaire', 'carteCredit', 'chequeBancaire',
            ]),
            'modalitesPaiement' => $this->faker->paragraph(1, false),
            'dateLimitePaiement' => $this->faker->dateTimeBetween('now', '+2 weeks'),
            'cheminSignature' => $this->faker->filePath(),
        ];
    }
}
