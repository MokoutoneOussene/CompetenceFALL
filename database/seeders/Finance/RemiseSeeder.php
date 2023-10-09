<?php

namespace Database\Seeders\Finance;

use App\Models\Finance\Paiement;
use App\Models\Finance\Remise;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RemiseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run()
    {

        $paiements = Paiement::all(['id']);

        foreach ($paiements as $paiement) {
            Remise::factory(1)->create(['paiement' => $paiement->id]);
        }

        echo Remise::count()." remise(s) créée(s).\n";
    }
}
