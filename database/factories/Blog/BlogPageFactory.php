<?php

namespace Database\Factories\Blog;

use App\Models\Blog\BlogArticle;
use App\Models\Blog\BlogPage;
use Illuminate\Database\Eloquent\Factories\Factory;

class BlogPageFactory extends Factory
{
    protected $model = BlogPage::class;

    public function definition()
    {

        return [

            'article' => BlogArticle::inRandomOrder()->first(['id'])->id,
            'intitule' => $this->faker->word(),
            'numeroOrdre' => $this->faker->randomNumber(1, 100),
            'resume' => $this->faker->paragraph(1, false),
            'contenu' => $this->faker->paragraph(3, false),
        ];
    }
}
