<?php

namespace Database\Factories\Formation;

use App\Models\Formation\Composition;
use App\Models\Formation\Evaluation;
use App\Models\Formation\Participant;
use Illuminate\Database\Eloquent\Factories\Factory;

class CompositionFactory extends Factory
{
    protected $model = Composition::class;

    public function definition()
    {

        $dateDebut = $this->faker->dateTimeBetween('-2 days', 'now');

        $dateFin = $this->faker->dateTimeBetween($dateDebut, '+2 hours');

        return [

            'participant' => Participant::inRandomOrder()->first(['id'])->id,
            'evaluation' => Evaluation::inRandomOrder()->first(['id'])->id,
            'noteObtenue' => $this->faker->numberBetween(1, 20),
            'dateDebut' => $dateDebut,
            'dateFin' => $dateFin,
        ];
    }
}
