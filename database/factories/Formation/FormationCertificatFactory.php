<?php

namespace Database\Factories\Formation;

use App\Models\Formation\FormationCertificat;
use App\Models\Formation\Participant;
use Illuminate\Database\Eloquent\Factories\Factory;

class FormationCertificatFactory extends Factory
{
    protected $model = FormationCertificat::class;

    public function definition()
    {

        return [

            'participant' => Participant::inRandomOrder()->first(['id'])->id,
            'identifiant' => substr($this->faker->md5(), 0, 10),
            'intitule' => $this->faker->word(),
            'domaine' => $this->faker->randomElement(['informatique', 'sante']),
            'cheminCertificat' => $this->faker->filePath(),
        ];
    }
}
