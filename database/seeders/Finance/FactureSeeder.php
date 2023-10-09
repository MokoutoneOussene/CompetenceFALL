<?php

namespace Database\Seeders\Finance;

use App\Models\Finance\Facture;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FactureSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run()
    {

        Facture::factory(rand(1, 5))->create();

        echo Facture::count()." facture(s) créée(s).\n";
    }
}
