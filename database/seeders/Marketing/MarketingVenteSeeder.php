<?php

namespace Database\Seeders\Marketing;

use App\Models\Marketing\Marketeur;
use App\Models\Marketing\MarketingVente;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MarketingVenteSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run()
    {

        $marketeurs = Marketeur::all(['id']);

        foreach ($marketeurs as $marketeur) {

            $paiements = $marketeur->paiements()->get(['id']);

            MarketingVente::factory(rand(1, 2))->create([
                'marketeur' => $marketeur->id, 'paiement' => $paiements->random()->id,
            ]);
        }

        echo MarketingVente::count()." vente(s) marketing créée(s).\n";
    }
}
