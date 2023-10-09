<?php

namespace Database\Factories\Emploi;

use App\Models\Emploi\CandidatExperience;
use App\Models\Emploi\DomaineEtude;
use App\Models\Systeme\IndicatifTelephonique;
use App\Models\Systeme\Pays;
use App\Models\Systeme\Utilisateur;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class CandidatExperienceFactory extends Factory
{
    protected $model = CandidatExperience::class;

    public function definition()
    {
        $dateFin = $this->faker->dateTimeBetween('-3 months', 'now');
        $dateDebut = $this->faker->dateTimeBetween('-5 years', $dateFin);

        return [
            'utilisateur' => Utilisateur::inRandomOrder()->first()->id,
            'poste' => $this->faker->jobTitle,
            'domaineEtude' => DomaineEtude::inRandomOrder()->first()->id,
            'duree' => Carbon::parse($dateFin)->diffInMonths(Carbon::parse($dateDebut)),
            'dateDebut' => $dateDebut,
            'dateFin' => $dateFin,
            'taches' => $this->faker->paragraph,
            'contrat' => $this->faker->randomElement(['CDD', 'CDI', 'Interim', 'Alternance', 'Stage']),
            'organisation' => $this->faker->company,
            'lieu' => $this->faker->city,
            'pays' => Pays::inRandomOrder()->first()->id,
            'typeLieu' => $this->faker->randomElement(['surSite', 'teleTravail', 'hybride']),
            'nomSuperieur' => $this->faker->lastName,
            'prenomsSuperieur' => $this->faker->firstName,
            'posteSuperieur' => $this->faker->jobTitle,
            'indicatifTelephoniqueSuperieur' => IndicatifTelephonique::inRandomOrder()->first(['valeur'])->valeur,
            'telephoneSuperieur' => $this->faker->numerify('########'),
        ];
    }
}
