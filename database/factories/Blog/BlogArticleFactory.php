<?php

namespace Database\Factories\Blog;

use App\Models\Blog\BlogArticle;
use App\Models\Blog\BlogCategorie;
use Illuminate\Database\Eloquent\Factories\Factory;

class BlogArticleFactory extends Factory
{
    protected $model = BlogArticle::class;

    public function definition()
    {

        return [

            'categorie' => BlogCategorie::inRandomOrder()->first(['id'])->id,
            'intitule' => $this->faker->word(),
            'resume' => $this->faker->paragraph(1, false),
            'statutVisibilite' => $this->faker->boolean(),
        ];
    }
}
