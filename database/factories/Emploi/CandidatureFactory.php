<?php

namespace Database\Factories\Emploi;

use App\Models\Emploi\Candidature;
use App\Models\Emploi\OffreEmploi;
use App\Models\Systeme\Utilisateur;
use Illuminate\Database\Eloquent\Factories\Factory;

class CandidatureFactory extends Factory
{
    protected $model = Candidature::class;

    public function definition()
    {
        return [
            'utilisateur' => Utilisateur::inRandomOrder()->first()->id,
            'offre' => OffreEmploi::inRandomOrder()->first()->id,
            'examinateur' => Utilisateur::inRandomOrder()->first()->id,
            'intitule' => $this->faker->word,
            'lettreMotivation' => $this->faker->text,
            'observations' => $this->faker->text,
            'auteurMiseAJour' => Utilisateur::inRandomOrder()->first()->id,
        ];
    }
}
