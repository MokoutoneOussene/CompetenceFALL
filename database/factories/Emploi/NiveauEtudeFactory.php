<?php

namespace Database\Factories\Emploi;

use App\Models\Emploi\NiveauEtude;
use Illuminate\Database\Eloquent\Factories\Factory;

class NiveauEtudeFactory extends Factory
{
    protected $model = NiveauEtude::class;

    public function definition()
    {

        $niveauxEtudes = [
            [
                'intitule' => 'Collège',
                'niveau' => 1,
                'description' => "Niveau d'études correspondant au cycle collégial.",
            ],
            [
                'intitule' => 'Lycée',
                'niveau' => 4,
                'description' => "Niveau d'études correspondant au cycle lycéen.",
            ],
            [
                'intitule' => 'Premier cycle universitaire',
                'niveau' => 7,
                'description' => "Niveau d'études du premier cycle universitaire.",
            ],
            [
                'intitule' => 'Second cycle universitaire',
                'niveau' => 10,
                'description' => "Niveau d'études du second cycle universitaire.",
            ],
            [
                'intitule' => 'Troisième cycle universitaire',
                'niveau' => 12,
                'description' => "Niveau d'études du troisième cycle universitaire.",
            ],
            [
                'intitule' => 'Post-universitaire',
                'niveau' => 15,
                'description' => "Niveau d'études post-universitaire ou de spécialisation.",
            ],
        ];

        $niveauEtude = $this->faker->randomElement($niveauxEtudes);

        return [

            'intitule' => $niveauEtude['intitule'],
            'niveau' => (int) $niveauEtude['niveau'],
            'description' => $niveauEtude['description'],
        ];
    }
}
