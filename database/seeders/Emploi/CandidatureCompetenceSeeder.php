<?php

namespace Database\Seeders\Emploi;

use App\Models\Emploi\CandidatureCompetence;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CandidatureCompetenceSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run()
    {
        CandidatureCompetence::factory(100)->create();
    }
}
