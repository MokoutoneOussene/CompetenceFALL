<?php

namespace Database\Factories\Emploi;

use App\Models\Emploi\CandidatCentre;
use App\Models\Systeme\Utilisateur;
use Illuminate\Database\Eloquent\Factories\Factory;

class CandidatCentreFactory extends Factory
{
    protected $model = CandidatCentre::class;

    public function definition()
    {
        return [
            'utilisateur' => Utilisateur::inRandomOrder()->first()->id,
            'intitule' => $this->faker->optional()->sentence,
        ];
    }
}
