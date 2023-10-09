<?php

namespace Database\Factories\Forum;

use App\Models\Forum\Forum;
use Illuminate\Database\Eloquent\Factories\Factory;

class ForumFactory extends Factory
{
    protected $model = Forum::class;

    public function definition()
    {

        return [

            'intitule' => ucfirst($this->faker->word()),
            'theme' => ucfirst($this->faker->word()),
            'description' => $this->faker->paragraph(1, false),
            'regles' => $this->faker->paragraph(1, false),
        ];
    }
}
