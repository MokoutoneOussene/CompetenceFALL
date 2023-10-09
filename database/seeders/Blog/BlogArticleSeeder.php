<?php

namespace Database\Seeders\Blog;

use App\Models\Blog\BlogArticle;
use App\Models\Blog\BlogCategorie;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BlogArticleSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run()
    {

        $categories = BlogCategorie::all(['id']);

        foreach ($categories as $categorie) {
            BlogArticle::factory(rand(1, 2))->create(['categorie' => $categorie->id]);
        }

        echo BlogArticle::count()." article(s) de blog créé(s).\n";
    }
}
