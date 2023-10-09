<?php

namespace Database\Seeders\Emploi;

use App\Models\Emploi\CandidatureConvocation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CandidatureConvocationSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run()
    {
        CandidatureConvocation::factory(100)->create();
    }
}
