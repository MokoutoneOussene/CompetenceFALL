<?php

namespace Database\Seeders\Systeme;

use App\Models\Systeme\TentativeConnexion;
use App\Models\Systeme\Utilisateur;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TentativeConnexionSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run()
    {

        $utilisateurs = Utilisateur::all(['id']);

        foreach ($utilisateurs as $utilisateur) {
            TentativeConnexion::factory(1)->create(['utilisateur' => $utilisateur->id]);
        }

        echo TentativeConnexion::count()." tentative(s) de connexion(s) créée(s).\n";
    }
}
