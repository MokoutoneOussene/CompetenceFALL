<?php

namespace Database\Factories\Systeme;

use App\Models\Systeme\Banniere;
use Illuminate\Database\Eloquent\Factories\Factory;

class BanniereFactory extends Factory
{
    protected $model = Banniere::class;

    public function definition()
    {

        return [

            'intitule' => $this->faker->word(),
            'contenu' => $this->faker->paragraph(1, false),
            'statutActivation' => $this->faker->boolean(),
            'dateDebutDiffusion' => now()->format('Y-m-d H:i:s'),
            'dateFinDiffusion' => $this->faker->dateTimeBetween('now', '+2 months')->format('Y-m-d H:i:s'),
        ];
    }
}
