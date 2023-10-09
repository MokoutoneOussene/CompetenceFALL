<?php

namespace Database\Factories\Blog;

use App\Models\Blog\BlogCategorie;
use Illuminate\Database\Eloquent\Factories\Factory;

class BlogCategorieFactory extends Factory
{
    protected $model = BlogCategorie::class;

    public function definition()
    {

        return [

            'intitule' => $this->faker->word(),
            'theme' => $this->faker->word(),
            'description' => $this->faker->paragraph(1, false),
            'statutVisibilite' => $this->faker->boolean(),
        ];
    }
}
