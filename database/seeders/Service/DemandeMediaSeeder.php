<?php

namespace Database\Seeders\Service;

use App\Models\Service\Demande;
use App\Models\Service\DemandeMedia;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DemandeMediaSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run()
    {

        $demandes = Demande::all(['id']);

        foreach ($demandes as $demande) {
            DemandeMedia::factory(rand(1, 2))->create(['demande' => $demande->id]);
        }

        echo DemandeMedia::count()." pièce-jointe(s) aux demandes de service créée(s).\n";
    }
}
