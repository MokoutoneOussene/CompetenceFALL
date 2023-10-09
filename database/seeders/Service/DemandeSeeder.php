<?php

namespace Database\Seeders\Service;

use App\Models\Service\Demande;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DemandeSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run()
    {

        Demande::factory(rand(5, 10))->create();

        echo Demande::count()." demande(s) de service créée(s).\n";
    }
}
