<?php

namespace Database\Seeders\Finance;

use App\Models\Finance\Bien;
use App\Models\Finance\Facture;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BienSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run()
    {

        $factures = Facture::all(['id']);

        foreach ($factures as $facture) {
            Bien::factory(1)->create(['facture' => $facture->id]);
        }

        echo Bien::count()." élément(s) de factures créée(s).\n";
    }
}
