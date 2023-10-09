<?php

namespace Database\Factories\Systeme;

use App\Models\Systeme\Utilisateur;
use App\Models\Systeme\UtilisateurBlocage;
use Illuminate\Database\Eloquent\Factories\Factory;

class UtilisateurBlocageFactory extends Factory
{
    protected $model = UtilisateurBlocage::class;

    public function definition()
    {

        return [
            'utilisateur' => Utilisateur::inRandomOrder()->first(['id'])->id,
            'motif' => 'Motif de blocage : '.$this->faker->paragraph(1),
            'statutActivation' => $this->faker->boolean(),
            'statutDeblocable' => $this->faker->boolean(),
        ];
    }
}
