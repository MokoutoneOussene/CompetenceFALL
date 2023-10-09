<?php

namespace Database\Factories\Emploi;

use App\Models\Emploi\CandidatCertificat;
use App\Models\Emploi\Candidature;
use App\Models\Emploi\CandidatureCertificat;
use Illuminate\Database\Eloquent\Factories\Factory;

class CandidatureCertificatFactory extends Factory
{
    protected $model = CandidatureCertificat::class;

    public function definition()
    {
        return [
            'candidature' => Candidature::inRandomOrder()->first()->id,
            'certificat' => CandidatCertificat::inRandomOrder()->first()->id,
        ];
    }
}
