<?php

namespace Database\Factories\Emploi;

use App\Models\Emploi\CandidatCv;
use App\Models\Systeme\Utilisateur;
use Illuminate\Database\Eloquent\Factories\Factory;

class CandidatCvFactory extends Factory
{
    protected $model = CandidatCv::class;

    public function definition()
    {
        return [
            'utilisateur' => Utilisateur::inRandomOrder()->first()->id,
            'intitule' => $this->faker->sentence,
            'slug' => $this->faker->filePath,
        ];
    }
}
