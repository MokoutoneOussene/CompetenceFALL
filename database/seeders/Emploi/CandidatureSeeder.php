<?php

namespace Database\Seeders\Emploi;

use App\Models\Emploi\Candidature;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CandidatureSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run()
    {
        Candidature::factory(10)->create();
    }
}
