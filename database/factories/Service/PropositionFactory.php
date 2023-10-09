<?php

namespace Database\Factories\Service;

use App\Models\Finance\Facture;
use App\Models\Service\Demande;
use App\Models\Service\Proposition;
use Illuminate\Database\Eloquent\Factories\Factory;

class PropositionFactory extends Factory
{
    protected $model = Proposition::class;

    public function definition()
    {

        $dateDebut = $this->faker->dateTimeBetween('now', '+2 weeks');

        return [

            'demande' => Demande::inRandomOrder()->first(['id'])->id,
            'facture' => Facture::inRandomOrder()->first(['id'])->id,
            'intitule' => 'Proposition pour la demande de service '.$this->faker->word(),
            'contenu' => $this->faker->paragraph(1, false),
            'dateDebutProbable' => $dateDebut,
            'dateFinProbable' => $this->faker->dateTimeBetween($dateDebut, '+7 months'),
        ];
    }
}
