<?php

namespace Database\Seeders\Systeme;

use App\Models\Systeme\Politique;
use Illuminate\Database\Seeder;

class PolitiqueSeeder extends Seeder
{
    public function run(): void
    {

        Politique::factory(rand(1, 3))->create();

        echo Politique::count()." politique(s) créée(s).\n";
    }
}
