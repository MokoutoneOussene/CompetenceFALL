<?php

namespace Database\Factories\Systeme;

use App\Models\Systeme\Organisation;
use App\Models\Systeme\Pays;
use App\Models\Systeme\Utilisateur;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrganisationFactory extends Factory
{
    protected $model = Organisation::class;

    public function definition()
    {

        return [

            'utilisateur' => Utilisateur::inRandomOrder()->first(['id'])->id,
            'identifiant' => substr($this->faker->uuid(), 0, 14),
            'denomination' => $this->faker->unique(false, 10000)->company(),
            'statutJuridique' => $this->faker->randomElement(['sa', 'sarl', 'ei', 'ong']),
            'domaine' => $this->faker->randomElement(['education', 'commerce', 'industrie', 'transport']),
            'dateFondation' => $this->faker->dateTimeBetween('-4 years', '-3 years'),
            'capitalSocial' => $this->faker->randomNumber(2, false),
            'nombreEmploye' => $this->faker->randomNumber(2, false),
            'lieuSiege' => $this->faker->city(),
            'paysSiege' => Pays::inRandomOrder()->first(['id'])->id,
        ];
    }
}
