<?php

namespace Database\Factories\Formation;

use App\Models\Formation\Composition;
use App\Models\Formation\FormationQuestion;
use App\Models\Formation\Tirage;
use Illuminate\Database\Eloquent\Factories\Factory;

class TirageFactory extends Factory
{
    protected $model = Tirage::class;

    public function definition()
    {

        $composition = Composition::inRandomOrder()->first();
        $dateEnvoiQuestion = $this->faker->dateTimeBetween($composition->dateDebut, 'now');
        $dateRetourReponse = $this->faker->dateTimeBetween($dateEnvoiQuestion, 'now');

        return [

            'composition' => $composition->id,
            'question' => FormationQuestion::where('evaluation', $composition->evaluation)->inRandomOrder()->first(['id'])->id,
            'ordreTirage' => (int) (Tirage::max('ordreTirage') ?? 0) + 1,
            'dateEnvoiQuestion' => $dateEnvoiQuestion,
            'dateRetourReponse' => $dateRetourReponse,
        ];
    }
}
