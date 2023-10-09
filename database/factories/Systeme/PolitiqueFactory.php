<?php

namespace Database\Factories\Systeme;

use App\Models\Systeme\Politique;
use Illuminate\Database\Eloquent\Factories\Factory;

class PolitiqueFactory extends Factory
{
    protected $model = Politique::class;

    public function definition()
    {

        return [

            'intitule' => ucfirst($this->faker->word),
            'contenu' => $this->faker->paragraph(1, false),
        ];
    }
}
