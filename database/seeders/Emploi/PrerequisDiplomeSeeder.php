<?php

namespace Database\Seeders\Emploi;

use App\Models\Emploi\PrerequisDiplome;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PrerequisDiplomeSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run()
    {

        PrerequisDiplome::factory(4)->create();
    }
}
