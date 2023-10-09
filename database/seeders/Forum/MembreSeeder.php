<?php

namespace Database\Seeders\Forum;

use App\Models\Forum\Forum;
use App\Models\Forum\Membre;
use App\Models\Systeme\Utilisateur;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MembreSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run()
    {

        $utilisateurs = Utilisateur::all(['id']);

        foreach ($utilisateurs as $utilisateur) {

            Membre::factory(1)->create([
                'utilisateur' => $utilisateur->id,
                'forum' => Forum::inRandomOrder()->first(['id'])->id,
            ]);
        }

        echo Membre::count()." membre(s) de forums créé(s).\n";
    }
}
