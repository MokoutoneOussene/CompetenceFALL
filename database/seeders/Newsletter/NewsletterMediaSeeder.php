<?php

namespace Database\Seeders\Newsletter;

use App\Models\Newsletter\NewsletterArticle;
use App\Models\Newsletter\NewsletterMedia;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NewsletterMediaSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run()
    {

        $articles = NewsletterArticle::all(['id']);

        foreach ($articles as $article) {

            NewsletterMedia::factory(rand(1, 5))->create(['article' => $article->id]);
        }

        echo NewsletterMedia::count()." média(s) d'articles de newsletter créé(s).\n";
    }
}
