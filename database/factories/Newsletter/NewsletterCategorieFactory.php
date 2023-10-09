<?php

namespace Database\Factories\Newsletter;

use App\Models\Newsletter\NewsletterCategorie;
use Illuminate\Database\Eloquent\Factories\Factory;

class NewsletterCategorieFactory extends Factory
{
    protected $model = NewsletterCategorie::class;

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
