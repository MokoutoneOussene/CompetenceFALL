<?php

namespace Database\Factories\Emploi;

use App\Models\Emploi\CandidatReference;
use App\Models\Emploi\Candidature;
use App\Models\Emploi\CandidatureReference;
use Illuminate\Database\Eloquent\Factories\Factory;

class CandidatureReferenceFactory extends Factory
{
    protected $model = CandidatureReference::class;

    public function definition()
    {
        return [
            'candidature' => Candidature::inRandomOrder()->first()->id,
            'reference' => CandidatReference::inRandomOrder()->first()->id,
        ];
    }
}
