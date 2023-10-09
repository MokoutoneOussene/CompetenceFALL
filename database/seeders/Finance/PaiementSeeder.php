<?php

namespace Database\Seeders\Finance;

use App\Models\Finance\Facture;
use App\Models\Finance\Paiement;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaiementSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run()
    {

        $factures = Facture::all(['id']);

        foreach ($factures as $facture) {
            Paiement::factory(rand(1, 2))->create(['facture' => $facture->id]);
        }

        echo Paiement::count()." paiement(s) créé(s).\n";
    }
}
