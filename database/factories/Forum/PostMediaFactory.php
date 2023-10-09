<?php

namespace Database\Factories\Forum;

use App\Models\Forum\Post;
use App\Models\Forum\PostMedia;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostMediaFactory extends Factory
{
    protected $model = PostMedia::class;

    public function definition()
    {

        return [

            'post' => Post::inRandomOrder()->first(['id'])->id,
            'nom' => $this->faker->word(),
            'typeMime' => $this->faker->mimeType(),
            'chemin' => $this->faker->filePath(),
            'taille' => $this->faker->randomNumber(3),
        ];
    }
}
