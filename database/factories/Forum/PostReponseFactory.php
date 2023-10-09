<?php

namespace Database\Factories\Forum;

use App\Models\Forum\Post;
use App\Models\Forum\PostReponse;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostReponseFactory extends Factory
{
    protected $model = PostReponse::class;

    public function definition()
    {

        return [

            'post' => Post::inRandomOrder()->first(['id'])->id,
            'reponse' => Post::inRandomOrder()->first(['id'])->id,
        ];
    }
}
