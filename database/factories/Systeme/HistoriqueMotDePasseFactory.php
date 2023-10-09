<?php

namespace Database\Factories\Systeme;

use App\Models\Systeme\HistoriqueMotDePasse;
use App\Models\Systeme\Utilisateur;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class HistoriqueMotDePasseFactory extends Factory
{
    protected $model = HistoriqueMotDePasse::class;

    public function definition()
    {

        return [

            'utilisateur' => Utilisateur::inRandomOrder()->first(['id'])->id,
            'motDePasse' => Hash::make($this->faker->word()),
        ];
    }
}
