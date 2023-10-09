<?php

namespace Database\Factories\Newsletter;

use App\Models\Newsletter\NewsletterArticle;
use App\Models\Newsletter\NewsletterPage;
use Illuminate\Database\Eloquent\Factories\Factory;

class NewsletterPageFactory extends Factory
{
    protected $model = NewsletterPage::class;

    public function definition()
    {

        return [

            'article' => NewsletterArticle::inRandomOrder()->first(['id'])->id,
            'intitule' => $this->faker->word(),
            'numeroOrdre' => $this->faker->randomNumber(1, 100),
            'resume' => $this->faker->paragraph(1, false),
            'contenu' => $this->faker->paragraph(3, false),
        ];
    }
}
