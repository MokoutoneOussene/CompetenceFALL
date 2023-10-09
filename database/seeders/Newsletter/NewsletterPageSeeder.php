<?php

namespace Database\Seeders\Newsletter;

use App\Models\Newsletter\NewsletterArticle;
use App\Models\Newsletter\NewsletterPage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NewsletterPageSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run()
    {

        $articles = NewsletterArticle::all(['id']);

        foreach ($articles as $article) {

            NewsletterPage::factory(rand(1, 5))->create(['article' => $article->id]);
        }

        echo NewsletterPage::count()." page(s) d'articles de newsletter créée(s).\n";
    }
}
