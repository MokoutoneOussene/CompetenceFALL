<?php

namespace Database\Seeders\Emploi;

use App\Models\Emploi\CandidatureReponse;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CandidatureReponseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run()
    {
        CandidatureReponse::factory(100)->create();
    }
}
