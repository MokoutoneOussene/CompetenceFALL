<?php

namespace Database\Factories\Emploi;

use App\Models\Emploi\Candidature;
use App\Models\Emploi\CandidatureReponse;
use App\Models\Emploi\QuestionOffre;
use Illuminate\Database\Eloquent\Factories\Factory;

class CandidatureReponseFactory extends Factory
{
    protected $model = CandidatureReponse::class;

    public function definition()
    {
        return [
            'candidature' => Candidature::inRandomOrder()->first()->id,
            'question' => QuestionOffre::inRandomOrder()->first()->id,
            'reponse' => false,
            'contenu' => $this->faker->paragraph,
        ];
    }
}
