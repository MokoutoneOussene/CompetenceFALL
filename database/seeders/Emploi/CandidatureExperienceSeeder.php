<?php

namespace Database\Seeders\Emploi;

use App\Models\Emploi\CandidatureExperience;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CandidatureExperienceSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run()
    {
        CandidatureExperience::factory(100)->create();
    }
}
