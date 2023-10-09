<?php

namespace Database\Factories\Newsletter;

use App\Models\Newsletter\NewsletterArticle;
use App\Models\Newsletter\NewsletterCategorie;
use Illuminate\Database\Eloquent\Factories\Factory;

class NewsletterArticleFactory extends Factory
{
    protected $model = NewsletterArticle::class;

    public function definition()
    {

        return [

            'categorie' => NewsletterCategorie::inRandomOrder()->first(['id'])->id,
            'intitule' => $this->faker->word(),
            'resume' => $this->faker->paragraph(1, false),
            'dateEnvoiePrevue' => $this->faker->dateTimeThisYear(),
            'dateEnvoie' => $this->faker->dateTimeThisYear(),
        ];
    }
}
