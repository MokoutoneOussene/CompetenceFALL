<?php

namespace Database\Factories\Emploi;

use App\Models\Emploi\CandidatDiplome;
use App\Models\Emploi\Candidature;
use App\Models\Emploi\CandidatureDiplome;
use Illuminate\Database\Eloquent\Factories\Factory;

class CandidatureDiplomeFactory extends Factory
{
    protected $model = CandidatureDiplome::class;

    public function definition()
    {
        return [
            'candidature' => Candidature::inRandomOrder()->first()->id,
            'diplome' => CandidatDiplome::inRandomOrder()->first()->id,
        ];
    }
}
