<?php

namespace Database\Factories\Service;

use App\Models\Service\Attestation;
use App\Models\Service\Demande;
use Illuminate\Database\Eloquent\Factories\Factory;

class AttestationFactory extends Factory
{
    protected $model = Attestation::class;

    public function definition()
    {

        $demandes = Demande::select(['id', 'client'])->distinct('client')->get();

        return [

            'client' => $demandes->random()->client,
            'numero' => substr($this->faker->unique()->md5(), 0, 10),
            'intitule' => 'Attestation de reconnaissance pour client'.$this->faker->randomElement([
                'bronze', 'argent', 'or', 'diamant',
            ]),
            'dateObtention' => $this->faker->dateTimeBetween('-2 years', 'now'),
            'cheminAttestation' => $this->faker->filePath(),
        ];
    }
}
