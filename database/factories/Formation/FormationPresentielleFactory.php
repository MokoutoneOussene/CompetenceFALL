<?php

namespace Database\Factories\Formation;

use App\Models\Formation\Formation;
use App\Models\Formation\FormationPresentielle;
use App\Models\Systeme\Pays;
use App\Models\Systeme\Utilisateur;
use Illuminate\Database\Eloquent\Factories\Factory;

class FormationPresentielleFactory extends Factory
{
    protected $model = FormationPresentielle::class;

    public function definition()
    {

        return [

            'formation' => Formation::inRandomOrder()->first(['id'])->id,
            'formateur' => Utilisateur::inRandomOrder()->first(['id'])->id,
            'prerequis' => $this->faker->paragraph(1, false),
            'dateDebut' => $this->faker->dateTimeBetween('now', '+2 weeks'),
            'dateFin' => $this->faker->dateTimeBetween('+2 weeks', '+4 weeks'),
            'lieu' => $this->faker->city(),
            'pays' => Pays::inRandomOrder()->first(['id'])->id,
        ];
    }
}
