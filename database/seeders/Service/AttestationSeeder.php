<?php

namespace Database\Seeders\Service;

use App\Models\Service\Attestation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AttestationSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run()
    {

        Attestation::factory(rand(1, 5))->create();

        echo Attestation::count()." attestation(s) de reconnaissance créée(s).\n";
    }
}
