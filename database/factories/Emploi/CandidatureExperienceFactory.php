<?php

namespace Database\Factories\Emploi;

use App\Models\Emploi\CandidatExperience;
use App\Models\Emploi\Candidature;
use App\Models\Emploi\CandidatureExperience;
use Illuminate\Database\Eloquent\Factories\Factory;

class CandidatureExperienceFactory extends Factory
{
    protected $model = CandidatureExperience::class;

    public function definition()
    {
        return [
            'candidature' => Candidature::inRandomOrder()->first()->id,
            'experience' => CandidatExperience::inRandomOrder()->first()->id,
        ];
    }
}
