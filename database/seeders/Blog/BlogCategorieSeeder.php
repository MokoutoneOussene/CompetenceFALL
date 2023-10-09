<?php

namespace Database\Seeders\Blog;

use App\Models\Blog\BlogCategorie;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BlogCategorieSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run()
    {

        BlogCategorie::factory(rand(1, 3))->create();

        echo BlogCategorie::count()." catégorie(s) de blog créée(s).\n";
    }
}
