<?php

namespace Database\Seeders\Blog;

use App\Models\Blog\BlogArticle;
use App\Models\Blog\BlogPage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BlogPageSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run()
    {

        $articles = BlogArticle::all(['id']);

        foreach ($articles as $article) {
            BlogPage::factory(rand(1, 2))->create(['article' => $article->id]);
        }

        echo BlogPage::count()." page(s) d'articles de blog créé(s).\n";
    }
}
