<?php

namespace Database\Factories\Formation;

use App\Models\Formation\Formation;
use App\Models\Formation\FormationMedia;
use Illuminate\Database\Eloquent\Factories\Factory;

class FormationMediaFactory extends Factory
{
    protected $model = FormationMedia::class;

    public function definition()
    {

        return [

            'formation' => Formation::inRandomOrder()->first(['id'])->id,
            'nom' => $this->faker->word(),
            'typeMime' => $this->faker->mimeType(),
            'chemin' => $this->faker->filePath(),
            'taille' => $this->faker->randomNumber(3),
        ];
    }
}
