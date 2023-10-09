<?php

namespace Database\Factories\Systeme;

use App\Models\Systeme\Faq;
use App\Models\Systeme\FaqMedia;
use Illuminate\Database\Eloquent\Factories\Factory;

class FaqMediaFactory extends Factory
{
    protected $model = FaqMedia::class;

    public function definition(): array
    {

        return [

            'faq' => Faq::inRandomOrder()->first(['id'])->id,
            'nom' => $this->faker->word(),
            'chemin' => $this->faker->filePath(),
            'typeMime' => $this->faker->fileExtension(),
            'taille' => $this->faker->randomNumber(4, false),
        ];
    }
}
