<?php

namespace Database\Factories\Emploi;

use App\Models\Emploi\DomaineEtude;
use App\Models\Emploi\OffreEmploi;
use App\Models\Emploi\PrerequisExperience;
use Illuminate\Database\Eloquent\Factories\Factory;

class PrerequisExperienceFactory extends Factory
{
    protected $model = PrerequisExperience::class;

    public function definition()
    {
        return [

            'offre' => OffreEmploi::inRandomOrder()->first(['id'])->id,
            'domaineEtude' => DomaineEtude::inRandomOrder()->first(['id'])->id,
            'noteDomaine' => $this->faker->numberBetween(1, 5),
            'duree' => $this->faker->numberBetween(1, 5),
        ];
    }
}
