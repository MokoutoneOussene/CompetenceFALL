<?php

namespace Database\Seeders\Emploi;

use App\Models\Emploi\CandidatureDiplome;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CandidatureDiplomeSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run()
    {
        CandidatureDiplome::factory(100)->create();
    }
}
