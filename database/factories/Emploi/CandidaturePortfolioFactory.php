<?php

namespace Database\Factories\Emploi;

use App\Models\Emploi\CandidatPortfolio;
use App\Models\Emploi\Candidature;
use App\Models\Emploi\CandidaturePortfolio;
use Illuminate\Database\Eloquent\Factories\Factory;

class CandidaturePortfolioFactory extends Factory
{
    protected $model = CandidaturePortfolio::class;

    public function definition()
    {
        return [
            'candidature' => Candidature::inRandomOrder()->first()->id,
            'portfolio' => CandidatPortfolio::inRandomOrder()->first()->id,
        ];
    }
}
