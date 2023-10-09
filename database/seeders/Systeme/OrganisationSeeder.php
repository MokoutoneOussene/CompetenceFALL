<?php

namespace Database\Seeders\Systeme;

use App\Models\Systeme\Organisation;
use App\Models\Systeme\Utilisateur;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrganisationSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {

        $organisations = Utilisateur::where('typeUtilisateur', 'organisation')->get(['id']);

        foreach ($organisations as $organisation) {

            Organisation::factory()->create(['utilisateur' => $organisation->id]);
        }

        echo Organisation::count()." organistion(s) créée(s).\n";
    }
}
