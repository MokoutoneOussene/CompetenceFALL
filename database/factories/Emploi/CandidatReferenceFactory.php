<?php

namespace Database\Factories\Emploi;

use App\Models\Emploi\CandidatReference;
use App\Models\Systeme\IndicatifTelephonique;
use App\Models\Systeme\Utilisateur;
use Illuminate\Database\Eloquent\Factories\Factory;

class CandidatReferenceFactory extends Factory
{
    protected $model = CandidatReference::class;

    public function definition()
    {
        return [
            'utilisateur' => Utilisateur::inRandomOrder()->first()->id,
            'nom' => $this->faker->lastName,
            'prenoms' => $this->faker->firstName,
            'poste' => $this->faker->jobTitle,
            'organisation' => $this->faker->company,
            'email' => $this->faker->unique()->safeEmail,
            'indicatifTelephonique' => IndicatifTelephonique::inRandomOrder()->first(['valeur'])->valeur,
            'telephone' => $this->faker->numerify('########'),
            'relation' => $this->faker->randomElement(['subordonne', 'collegue', 'superieur']),
            'dateDebut' => $this->faker->dateTimeBetween('-5 years', 'now'),
            'dateFin' => $this->faker->optional()->dateTimeBetween('now', '+5 years'),
        ];
    }
}
