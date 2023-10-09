<?php

namespace Database\Factories\Formation;

use App\Models\Formation\Formation;
use App\Models\Formation\FormationPrerequis;
use Illuminate\Database\Eloquent\Factories\Factory;

class FormationPrerequisFactory extends Factory
{
    protected $model = FormationPrerequis::class;

    public function definition()
    {

        return [

            'formation' => Formation::inRandomOrder()->first(['id'])->id,
            'prerequis' => Formation::inRandomOrder()->first(['id'])->id,
        ];
    }
}
