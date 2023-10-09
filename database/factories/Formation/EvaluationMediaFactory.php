<?php

namespace Database\Factories\Formation;

use App\Models\Formation\Evaluation;
use App\Models\Formation\EvaluationMedia;
use Illuminate\Database\Eloquent\Factories\Factory;

class EvaluationMediaFactory extends Factory
{
    protected $model = EvaluationMedia::class;

    public function definition()
    {

        return [

            'evaluation' => Evaluation::inRandomOrder()->first(['id'])->id,
            'nom' => $this->faker->word(),
            'typeMime' => $this->faker->mimeType(),
            'chemin' => $this->faker->filePath(),
            'taille' => $this->faker->randomNumber(3),
        ];
    }
}
