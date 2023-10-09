<?php

namespace Database\Factories\Emploi;

use App\Models\Emploi\Candidature;
use App\Models\Emploi\CandidatureConvocation;
use App\Models\Systeme\IndicatifTelephonique;
use App\Models\Systeme\Pays;
use App\Models\Systeme\Utilisateur;
use Illuminate\Database\Eloquent\Factories\Factory;

class CandidatureConvocationFactory extends Factory
{
    protected $model = CandidatureConvocation::class;

    public function definition()
    {
        return [
            'candidature' => Candidature::inRandomOrder()->first()->id,
            'objet' => 'Entretien '.$this->faker->word(),
            'lieu' => $this->faker->city,
            'pays' => Pays::inRandomOrder()->first()->id,
            'adresse' => $this->faker->address,
            'date' => $this->faker->dateTimeThisMonth,
            'consignes' => $this->faker->text,
            'indicatifTelephonique' => IndicatifTelephonique::inRandomOrder()->first(['valeur'])->valeur,
            'telephone' => $this->faker->phoneNumber,
            'auteurCreation' => Utilisateur::inRandomOrder()->first()->id,
            'auteurMiseAJour' => Utilisateur::inRandomOrder()->first()->id,
        ];
    }
}
