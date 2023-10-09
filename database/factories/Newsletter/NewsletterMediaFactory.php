<?php

namespace Database\Factories\Newsletter;

use App\Models\Newsletter\NewsletterArticle;
use App\Models\Newsletter\NewsletterMedia;
use Illuminate\Database\Eloquent\Factories\Factory;

class NewsletterMediaFactory extends Factory
{
    protected $model = NewsletterMedia::class;

    public function definition()
    {

        return [

            'article' => NewsletterArticle::inRandomOrder()->first(['id'])->id,
            'nom' => $this->faker->word(),
            'typeMime' => $this->faker->mimeType(),
            'chemin' => $this->faker->filePath(),
            'taille' => $this->faker->randomNumber(3),
        ];
    }
}
