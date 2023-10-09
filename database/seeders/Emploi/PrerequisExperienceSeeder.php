<?php

namespace Database\Seeders\Emploi;

use App\Models\Emploi\PrerequisExperience;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PrerequisExperienceSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run()
    {

        PrerequisExperience::factory(4)->create();

    }
}
