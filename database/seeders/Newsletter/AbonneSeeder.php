<?php

namespace Database\Seeders\Newsletter;

use App\Models\Newsletter\Abonne;
use App\Models\Newsletter\NewsletterCategorie;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AbonneSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run()
    {

        $categories = NewsletterCategorie::all(['id']);

        foreach ($categories as $categorie) {

            Abonne::factory(rand(1, 5))->create(['categorie' => $categorie->id]);
        }

        echo Abonne::count()." abonné(s) à la newsletter créé(s).\n";
    }
}
