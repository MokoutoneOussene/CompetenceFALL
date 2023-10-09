<?php

namespace Database\Factories\Blog;

use App\Models\Blog\BlogArticle;
use App\Models\Blog\BlogMedia;
use Illuminate\Database\Eloquent\Factories\Factory;

class BlogMediaFactory extends Factory
{
    protected $model = BlogMedia::class;

    public function definition()
    {

        return [

            'article' => BlogArticle::inRandomOrder()->first(['id'])->id,
            'nom' => $this->faker->word(),
            'typeMime' => $this->faker->mimeType(),
            'chemin' => $this->faker->filePath(),
            'taille' => $this->faker->randomNumber(3),
        ];
    }
}
