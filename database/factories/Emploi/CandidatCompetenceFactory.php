<?php

namespace Database\Factories\Emploi;

use App\Models\Emploi\CandidatCompetence;
use App\Models\Systeme\Utilisateur;
use Illuminate\Database\Eloquent\Factories\Factory;

class CandidatCompetenceFactory extends Factory
{
    protected $model = CandidatCompetence::class;

    public function definition()
    {
        return [
            'utilisateur' => Utilisateur::inRandomOrder()->first()->id,
            'intitule' => $this->faker->sentence,
        ];
    }
}
