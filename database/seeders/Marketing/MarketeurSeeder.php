<?php

namespace Database\Seeders\Marketing;

use App\Models\Marketing\Marketeur;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MarketeurSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run()
    {

        Marketeur::factory(rand(1, 5))->create();

        echo Marketeur::count()." marketeur(s) créé(s).\n";
    }
}
