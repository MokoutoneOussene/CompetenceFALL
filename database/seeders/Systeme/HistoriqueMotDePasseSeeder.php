<?php

namespace Database\Seeders\Systeme;

use App\Models\Systeme\HistoriqueMotDePasse;
use App\Models\Systeme\Utilisateur;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HistoriqueMotDePasseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {

        $utilisateurs = Utilisateur::all(['id']);

        foreach ($utilisateurs as $utilisateur) {
            HistoriqueMotDePasse::factory(rand(1, 2))->create(['utilisateur' => $utilisateur->id]);
        }

        echo HistoriqueMotDePasse::count()." mot(s) de passe créé(s).\n";
    }
}
