<?php

namespace Database\Seeders\Systeme;

use App\Models\Systeme\CommentaireAnonyme;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CommentaireAnonymeSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {

        CommentaireAnonyme::factory(rand(1, 3))->create();

        echo CommentaireAnonyme::count()." commentaire(s) créé(s).\n";
    }
}
