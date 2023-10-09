<?php

namespace Database\Factories\Emploi;

use App\Models\Emploi\OffreEmploi;
use App\Models\Emploi\QuestionOffre;
use Illuminate\Database\Eloquent\Factories\Factory;

class QuestionOffreFactory extends Factory
{
    protected $model = QuestionOffre::class;

    public function definition()
    {

        $typeQuestion = $this->faker->randomElement(['vraiFaux', 'reponseCourte']);

        return [

            'offre' => OffreEmploi::inRandomOrder()->first(['id'])->id,
            'ordre' => $this->faker->randomDigitNotNull(),
            'contenu' => $this->faker->paragraph,
            'typeQuestion' => $typeQuestion,
            'note' => $typeQuestion == 'vraiFaux' ? $this->faker->randomDigitNotNull() : null,
            'bonneReponse' => $typeQuestion == 'vraiFaux' ? $this->faker->boolean : null,
        ];
    }
}
