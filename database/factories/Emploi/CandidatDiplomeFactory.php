<?php

namespace Database\Factories\Emploi;

use App\Models\Emploi\CandidatDiplome;
use App\Models\Emploi\DomaineEtude;
use App\Models\Emploi\NiveauEtude;
use App\Models\Emploi\NiveauSpecialisation;
use App\Models\Systeme\Utilisateur;
use Illuminate\Database\Eloquent\Factories\Factory;

class CandidatDiplomeFactory extends Factory
{
    protected $model = CandidatDiplome::class;

    public function definition()
    {
        return [
            'utilisateur' => Utilisateur::inRandomOrder()->first()->id,
            'identifiant' => $this->faker->unique()->isbn10,
            'intitule' => $this->faker->sentence(2),
            'domaineEtude' => DomaineEtude::inRandomOrder()->first()->id,
            'niveauEtude' => NiveauEtude::inRandomOrder()->first()->id,
            'niveauSpecialisation' => NiveauSpecialisation::inRandomOrder()->first()->id,
            'organisation' => $this->faker->company,
            'dateDebut' => $this->faker->dateTimeThisCentury,
            'dateFin' => $this->faker->dateTimeThisDecade,
            'dateDelivrance' => $this->faker->dateTimeThisDecade,
        ];
    }
}
