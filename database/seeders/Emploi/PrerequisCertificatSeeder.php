<?php

namespace Database\Seeders\Emploi;

use App\Models\Emploi\PrerequisCertificat;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PrerequisCertificatSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run()
    {

        PrerequisCertificat::factory(4)->create();

    }
}
