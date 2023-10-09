<?php

namespace Database\Seeders\Emploi;

use App\Models\Emploi\CandidatureReference;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CandidatureReferenceSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run()
    {
        CandidatureReference::factory(100)->create();
    }
}
