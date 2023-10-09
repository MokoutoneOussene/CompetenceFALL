<?php

namespace Database\Factories\Service;

use App\Models\Service\Demande;
use App\Models\Service\DemandeMedia;
use Illuminate\Database\Eloquent\Factories\Factory;

class DemandeMediaFactory extends Factory
{
    protected $model = DemandeMedia::class;

    public function definition(): array
    {

        return [

            'demande' => Demande::inRandomOrder()->first(['id'])->id,
            'nom' => $this->faker->word(),
            'chemin' => $this->faker->filePath(),
            'typeMime' => $this->faker->fileExtension(),
            'taille' => $this->faker->randomNumber(4, false),
        ];
    }
}
