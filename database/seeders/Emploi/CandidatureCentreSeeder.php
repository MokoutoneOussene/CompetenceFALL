<?php

namespace Database\Seeders\Emploi;

use App\Models\Emploi\CandidatureCentre;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CandidatureCentreSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run()
    {
        CandidatureCentre::factory(100)->create();
    }
}
