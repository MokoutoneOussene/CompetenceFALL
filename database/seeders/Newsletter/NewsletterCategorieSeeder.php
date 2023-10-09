<?php

namespace Database\Seeders\Newsletter;

use App\Models\Newsletter\NewsletterCategorie;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NewsletterCategorieSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run()
    {

        NewsletterCategorie::factory(rand(1, 3))->create();

        echo NewsletterCategorie::count()." catégorie(s) de newsletter créée(s).\n";
    }
}
