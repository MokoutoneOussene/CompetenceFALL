<?php

namespace Database\Factories\Service;

use App\Models\Service\Proposition;
use App\Models\Service\PropositionMedia;
use Illuminate\Database\Eloquent\Factories\Factory;

class PropositionMediaFactory extends Factory
{
    protected $model = PropositionMedia::class;

    public function definition(): array
    {

        return [

            'proposition' => Proposition::inRandomOrder()->first(['id'])->id,
            'nom' => $this->faker->word(),
            'chemin' => $this->faker->filePath(),
            'typeMime' => $this->faker->fileExtension(),
            'taille' => $this->faker->randomNumber(4, false),
        ];
    }
}
