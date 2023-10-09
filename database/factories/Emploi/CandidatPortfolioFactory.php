<?php

namespace Database\Factories\Emploi;

use App\Models\Emploi\CandidatPortfolio;
use App\Models\Systeme\Utilisateur;
use Illuminate\Database\Eloquent\Factories\Factory;

class CandidatPortfolioFactory extends Factory
{
    protected $model = CandidatPortfolio::class;

    public function definition()
    {
        return [
            'utilisateur' => Utilisateur::inRandomOrder()->first()->id,
            'intitule' => $this->faker->sentence,
            'date' => $this->faker->optional()->dateTimeBetween('-5 years', 'now'),
            'description' => $this->faker->paragraph,
            'lien' => $this->faker->url,
        ];
    }
}
