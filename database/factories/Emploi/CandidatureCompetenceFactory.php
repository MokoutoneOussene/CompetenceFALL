<?php

namespace Database\Factories\Emploi;

use App\Models\Emploi\CandidatCompetence;
use App\Models\Emploi\Candidature;
use App\Models\Emploi\CandidatureCompetence;
use Illuminate\Database\Eloquent\Factories\Factory;

class CandidatureCompetenceFactory extends Factory
{
    protected $model = CandidatureCompetence::class;

    public function definition()
    {
        return [
            'candidature' => Candidature::inRandomOrder()->first()->id,
            'competence' => CandidatCompetence::inRandomOrder()->first()->id,
        ];
    }
}
