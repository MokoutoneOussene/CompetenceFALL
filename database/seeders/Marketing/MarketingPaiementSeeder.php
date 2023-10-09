<?php

namespace Database\Seeders\Marketing;

use App\Models\Marketing\Marketeur;
use App\Models\Marketing\MarketingPaiement;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MarketingPaiementSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run()
    {

        $marketeurs = Marketeur::all(['id']);

        foreach ($marketeurs as $marketeur) {

            MarketingPaiement::factory(rand(1, 2))->create(['marketeur' => $marketeur->id]);
        }

        echo MarketingPaiement::count()." paiement(s) de marketeurs créé(s).\n";
    }
}
