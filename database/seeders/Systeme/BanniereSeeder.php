<?php

namespace Database\Seeders\Systeme;

use App\Models\Systeme\Banniere;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BanniereSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {

        Banniere::factory(rand(1, 3))->create();

        echo Banniere::count()." bannière(s) créée(s).\n";
    }
}
