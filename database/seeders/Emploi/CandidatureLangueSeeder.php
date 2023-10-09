<?php

namespace Database\Seeders\Emploi;

use App\Models\Emploi\CandidatureLangue;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CandidatureLangueSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run()
    {
        CandidatureLangue::factory(100)->create();
    }
}
