<?php

namespace Database\Seeders\Blog;

use App\Models\Blog\BlogArticle;
use App\Models\Blog\BlogMedia;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BlogMediaSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run()
    {

        $articles = BlogArticle::all(['id']);

        foreach ($articles as $article) {
            BlogMedia::factory(rand(1, 2))->create(['article' => $article->id]);
        }

        echo BlogMedia::count()." média(s) d'articles de blog créé(s).\n";
    }
}
