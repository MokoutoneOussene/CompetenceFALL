<?php

namespace Database\Seeders\Systeme;

use App\Models\Systeme\Chiffre;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ChiffreSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {

        Chiffre::factory(rand(1, 3))->create();

        echo Chiffre::count()." chiffre(s) créé(s).\n";
    }
}
