<?php

namespace Database\Seeders\Emploi;

use App\Models\Emploi\CandidatReference;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CandidatReferenceSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run()
    {
        CandidatReference::factory(10)->create();
    }
}
