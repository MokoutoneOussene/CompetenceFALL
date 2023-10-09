<?php

namespace Database\Factories\Forum;

use App\Models\Forum\Forum;
use App\Models\Forum\Membre;
use App\Models\Forum\Post;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    protected $model = Post::class;

    public function definition()
    {

        return [

            'membre' => Membre::inRandomOrder()->first(['id'])->id,
            'forum' => Forum::inRandomOrder()->first(['id'])->id,
            'contenu' => $this->faker->paragraph(1, false),
            'statutVisibilite' => $this->faker->boolean(),
        ];
    }
}
