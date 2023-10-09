<?php

namespace Database\Factories\Forum;

use App\Models\Forum\Membre;
use App\Models\Forum\Post;
use App\Models\Forum\PostReaction;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostReactionFactory extends Factory
{
    protected $model = PostReaction::class;

    public function definition()
    {

        return [

            'membre' => Membre::inRandomOrder()->first(['id'])->id,
            'post' => Post::inRandomOrder()->first(['id'])->id,
            'reaction' => $this->faker->randomElement(['aimer', 'nePasAimer']),
        ];
    }
}
