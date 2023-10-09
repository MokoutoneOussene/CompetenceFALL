<?php

namespace Database\Seeders\Service;

use App\Models\Finance\Facture;
use App\Models\Service\Demande;
use App\Models\Service\Proposition;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PropositionSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run()
    {

        $demandes = Demande::all(['id', 'client']);

        foreach ($demandes as $demande) {

            $facture = Facture::factory(1)->create(['client' => $demande->client])->first();

            Proposition::factory(1)->create(['demande' => $demande->id, 'facture' => $facture->id]);
        }

        echo Proposition::count()." proposition(s) aux demandes de services créée(s).\n";
    }
}
