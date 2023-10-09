<?php

namespace Database\Factories\Formation;

use App\Models\Finance\Facture;
use App\Models\Formation\Formation;
use App\Models\Formation\Participant;
use App\Models\Systeme\Utilisateur;
use Illuminate\Database\Eloquent\Factories\Factory;

class ParticipantFactory extends Factory
{
    protected $model = Participant::class;

    public function definition()
    {

        return [

            'utilisateur' => Utilisateur::inRandomOrder()->first(['id'])->id,
            'formation' => Formation::inRandomOrder()->first(['id'])->id,
            'facture' => Facture::inRandomOrder()->first(['id'])->id,
            'statutActivation' => $this->faker->boolean(),
        ];
    }
}
