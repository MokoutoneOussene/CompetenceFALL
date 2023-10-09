<?php

namespace Database\Seeders\Finance;

use App\Models\Finance\Paiement;
use App\Models\Finance\Remboursement;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RemboursementSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run()
    {

        $paiements = Paiement::all(['id']);

        foreach ($paiements as $paiement) {
            Remboursement::factory(1)->create(['paiement' => $paiement->id]);
        }

        echo Remboursement::count()." remboursement(s) de paiement(s) créé(s).\n";
    }
}
