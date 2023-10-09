<?php

namespace Database\Factories\Forum;

use App\Models\Forum\Avertissement;
use App\Models\Forum\Membre;
use App\Models\Forum\Post;
use Illuminate\Database\Eloquent\Factories\Factory;

class AvertissementFactory extends Factory
{
    protected $model = Avertissement::class;

    public function definition()
    {

        return [

            'membre' => Membre::inRandomOrder()->first(['id'])->id,
            'post' => Post::inRandomOrder()->first(['id'])->id,
            'motif' => $this->faker->paragraph(1, false),
        ];
    }
}
