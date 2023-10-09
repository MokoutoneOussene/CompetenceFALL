<?php

namespace Database\Seeders\Systeme;

use App\Models\Systeme\Log;
use App\Models\Systeme\Utilisateur;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LogSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run()
    {

        $utilisateurs = Utilisateur::all(['id']);

        foreach ($utilisateurs as $utilisateur) {
            Log::factory(1)->create(['utilisateur' => $utilisateur->id]);
        }

        echo Log::count()." activité(s) créée(s).\n";
    }
}
