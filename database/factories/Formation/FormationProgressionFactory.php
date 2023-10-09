<?php

namespace Database\Factories\Formation;

use App\Models\Formation\FormationPage;
use App\Models\Formation\FormationProgression;
use App\Models\Formation\Participant;
use Illuminate\Database\Eloquent\Factories\Factory;

class FormationProgressionFactory extends Factory
{
    protected $model = FormationProgression::class;

    public function definition()
    {

        return [

            'participant' => Participant::inRandomOrder()->first(['id'])->id,
            'page' => FormationPage::inRandomOrder()->first(['id'])->id,
        ];
    }
}
