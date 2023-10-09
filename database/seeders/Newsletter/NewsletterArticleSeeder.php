<?php

namespace Database\Seeders\Newsletter;

use App\Models\Newsletter\NewsletterArticle;
use App\Models\Newsletter\NewsletterCategorie;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NewsletterArticleSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run()
    {

        $categories = NewsletterCategorie::all(['id']);

        foreach ($categories as $categorie) {

            NewsletterArticle::factory(rand(1, 3))->create(['categorie' => $categorie->id]);
        }

        echo NewsletterArticle::count()." créé(s).\n";
    }
}
