<?php

namespace Database\Seeders\Systeme;

use App\Models\Systeme\Utilisateur;
use App\Models\Systeme\UtilisateurBlocage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UtilisateurBlocageSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {

        $utilisateurs = Utilisateur::all(['id']);

        foreach ($utilisateurs as $utilisateur) {

            UtilisateurBlocage::factory(1)->create([

                'utilisateur' => $utilisateur->id,
                'statutActivation' => false,
                'statutDeblocable' => true,
            ]);
        }

        echo UtilisateurBlocage::count()." blocage(s) administrateur(s) créée(s).\n";
    }
}
