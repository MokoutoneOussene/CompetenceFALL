<?php

namespace Database\Factories\Emploi;

use App\Models\Emploi\DomaineEtude;
use App\Models\Emploi\NiveauEtude;
use App\Models\Emploi\NiveauSpecialisation;
use App\Models\Emploi\OffreEmploi;
use App\Models\Emploi\PrerequisDiplome;
use Illuminate\Database\Eloquent\Factories\Factory;

class PrerequisDiplomeFactory extends Factory
{
    protected $model = PrerequisDiplome::class;

    public function definition()
    {

        return [

            'offre' => OffreEmploi::inRandomOrder()->first(['id'])->id,
            'domaineEtude' => DomaineEtude::inRandomOrder()->first(['id'])->id,
            'noteDomaine' => $this->faker->numberBetween(1, 20),
            'niveauEtude' => NiveauEtude::inRandomOrder()->first(['id'])->id,
            'niveauSpecialisation' => NiveauSpecialisation::inRandomOrder()->first(['id'])->id,
        ];
    }
}
