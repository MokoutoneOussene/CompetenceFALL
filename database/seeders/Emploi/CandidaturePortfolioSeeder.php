<?php

namespace Database\Seeders\Emploi;

use App\Models\Emploi\CandidaturePortfolio;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CandidaturePortfolioSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run()
    {
        CandidaturePortfolio::factory(100)->create();
    }
}
