<?php

namespace Database\Factories\Emploi;

use App\Models\Emploi\CandidatLangue;
use App\Models\Systeme\Utilisateur;
use Illuminate\Database\Eloquent\Factories\Factory;

class CandidatLangueFactory extends Factory
{
    protected $model = CandidatLangue::class;

    public function definition()
    {
        return [
            'utilisateur' => Utilisateur::inRandomOrder()->first()->id,
            'intitule' => $this->faker->randomElement([
                'Mandarin',
                'Espagnol',
                'Anglais',
                'Hindi',
                'Arabe',
                'Bengali',
                'Portugais',
                'Russe',
                'Japonais',
                'Lahnda',
                'Marathi',
                'Télougou',
                'Turc',
                'Français',
                'Allemand',
                'Farsi',
                'Vietnamien',
                'Coréen',
                'Min Nan',
                'Cantonais',
            ]),
            'niveau' => $this->faker->optional()->randomElement(['a1', 'b1', 'c1', 'a2', 'b2', 'c2']),
            'statutParle' => $this->faker->boolean,
            'statutLu' => $this->faker->boolean,
            'statutEcrit' => $this->faker->boolean,
        ];
    }
}
