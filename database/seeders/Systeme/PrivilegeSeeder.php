<?php

namespace Database\Seeders\Systeme;

use App\Models\Systeme\Privilege;
use App\Models\Systeme\Role;
use App\Models\Systeme\Utilisateur;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PrivilegeSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run()
    {

        // Attribuer les privilèges aux utilisateurs de test.
        Privilege::factory()->createMany([
            [
                'utilisateur' => Utilisateur::where('nomUtilisateur', 'candidat-alpha')->first(['id'])->id,
                'role' => Role::where('slug', 'can')->first(['id'])->id,
            ],
            [
                'utilisateur' => Utilisateur::where('nomUtilisateur', 'candidat-beta')->first(['id'])->id,
                'role' => Role::where('slug', 'can')->first(['id'])->id,
            ],
            [
                'utilisateur' => Utilisateur::where('nomUtilisateur', 'candidat-gamma')->first(['id'])->id,
                'role' => Role::where('slug', 'can')->first(['id'])->id,
            ],
            [
                'utilisateur' => Utilisateur::where('nomUtilisateur', 'roo-alpha')->first(['id'])->id,
                'role' => Role::where('slug', 'roo')->first(['id'])->id,
            ],
            [
                'utilisateur' => Utilisateur::where('nomUtilisateur', 'roo-beta')->first(['id'])->id,
                'role' => Role::where('slug', 'roo')->first(['id'])->id,
            ],
        ]);

        /*$utilisateurs = Utilisateur::all(['id']);

        foreach ($utilisateurs as $utilisateur) {

            Privilege::factory(1)->create([
                'utilisateur' => $utilisateur->id,
                'role' => Role::inRandomOrder()->first(['id'])->id
            ]);
        }*/

        echo Privilege::count()." privilège(s) créé(s).\n";
    }
}
