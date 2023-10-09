<?php

namespace Database\Factories\Systeme;

use App\Models\Systeme\Log;
use App\Models\Systeme\Utilisateur;
use Illuminate\Database\Eloquent\Factories\Factory;

class LogFactory extends Factory
{
    protected $model = Log::class;

    public function definition()
    {

        return [

            'utilisateur' => Utilisateur::inRandomOrder()->first(['id'])->id,
            'action' => $this->faker->randomElement(['creation', 'miseAJour', 'visualisation', 'supression']),
            'date' => now()->format('Y-m-d H:i:s'),
            'champs' => json_encode(['champs1', 'champs']),
            'details' => $this->faker->paragraph(1, false),
        ];
    }
}
