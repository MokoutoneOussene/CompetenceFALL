<?php

namespace Database\Factories\Forum;

use App\Models\Forum\Membre;
use App\Models\Forum\Post;
use App\Models\Forum\Signalement;
use Illuminate\Database\Eloquent\Factories\Factory;

class SignalementFactory extends Factory
{
    protected $model = Signalement::class;

    public function definition()
    {

        return [

            'membre' => Membre::inRandomOrder()->first(['id'])->id,
            'post' => Post::inRandomOrder()->first(['id'])->id,
            'motif' => $this->faker->paragraph(1, false),
        ];
    }
}
