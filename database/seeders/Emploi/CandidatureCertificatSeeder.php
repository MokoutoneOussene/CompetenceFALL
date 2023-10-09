<?php

namespace Database\Seeders\Emploi;

use App\Models\Emploi\CandidatureCertificat;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CandidatureCertificatSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run()
    {
        CandidatureCertificat::factory(100)->create();
    }
}
