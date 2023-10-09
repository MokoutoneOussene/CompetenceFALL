<?php

namespace Database\Factories\Emploi;

use App\Models\Emploi\DomaineEtude;
use App\Models\Emploi\OffreEmploi;
use App\Models\Emploi\PrerequisCertificat;
use Illuminate\Database\Eloquent\Factories\Factory;

class PrerequisCertificatFactory extends Factory
{
    protected $model = PrerequisCertificat::class;

    public function definition()
    {

        return [

            'offre' => OffreEmploi::inRandomOrder()->first(['id'])->id,
            'domaineEtude' => DomaineEtude::inRandomOrder()->first(['id'])->id,
            'noteDomaine' => $this->faker->numberBetween(1, 20),
        ];
    }
}
