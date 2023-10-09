<?php

namespace Database\Seeders\Emploi;

use App\Models\Emploi\CandidatCv;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CandidatCvSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run()
    {
        CandidatCv::factory(10)->create();
    }
}
