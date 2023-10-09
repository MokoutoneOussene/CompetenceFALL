<?php

namespace Database\Seeders\Formation;

use App\Models\Formation\Formation;
use Illuminate\Database\Seeder;

class FormationSeeder extends Seeder
{
    public function run()
    {

        Formation::factory(rand(1, 3))->create();

        echo Formation::count()." formation(s) créée(s).\n";
    }
}
