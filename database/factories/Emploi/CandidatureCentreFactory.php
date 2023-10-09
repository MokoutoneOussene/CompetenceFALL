<?php

namespace Database\Factories\Emploi;

use App\Models\Emploi\CandidatCentre;
use App\Models\Emploi\Candidature;
use App\Models\Emploi\CandidatureCentre;
use Illuminate\Database\Eloquent\Factories\Factory;

class CandidatureCentreFactory extends Factory
{
    protected $model = CandidatureCentre::class;

    public function definition()
    {
        return [
            'candidature' => Candidature::inRandomOrder()->first()->id,
            'centre' => CandidatCentre::inRandomOrder()->first()->id,
        ];
    }
}
