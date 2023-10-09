<?php

namespace Database\Seeders\Systeme;

use App\Models\Systeme\Session;
use App\Models\Systeme\Utilisateur;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SessionSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {

        $utilisateurs = Utilisateur::all(['id']);

        foreach ($utilisateurs as $utilisateur) {

            Session::factory(1)->create(['utilisateur' => $utilisateur->id]);
        }

        echo Session::count()." session(s) créée(s).\n";
    }
}
