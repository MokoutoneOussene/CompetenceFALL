<?php

namespace Database\Seeders\Systeme;

use App\Models\Systeme\Parametre;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ParametreSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {

        Parametre::factory(rand(1, 3))->create();

        echo Parametre::count()." parametre(s) créé(s).\n";
    }
}
