<?php

namespace Database\Factories\Emploi;

use App\Models\Emploi\CandidatLangue;
use App\Models\Emploi\Candidature;
use App\Models\Emploi\CandidatureLangue;
use Illuminate\Database\Eloquent\Factories\Factory;

class CandidatureLangueFactory extends Factory
{
    protected $model = CandidatureLangue::class;

    public function definition()
    {
        return [
            'candidature' => Candidature::inRandomOrder()->first()->id,
            'langue' => CandidatLangue::inRandomOrder()->first()->id,
        ];
    }
}
