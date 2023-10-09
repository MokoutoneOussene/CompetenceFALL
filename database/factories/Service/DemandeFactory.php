<?php

namespace Database\Factories\Service;

use App\Models\Service\Demande;
use App\Models\Systeme\Utilisateur;
use Illuminate\Database\Eloquent\Factories\Factory;

class DemandeFactory extends Factory
{
    protected $model = Demande::class;

    public function definition()
    {

        return [

            'client' => Utilisateur::inRandomOrder()->first()->id,
            'examinateur' => Utilisateur::inRandomOrder()->first()->id,
            'domaine' => $this->faker->randomElement(['ressourcesHumaines', 'projetsProgrammes', 'recrutement', 'formation']),
            'intitule' => 'Demande de '.$this->faker->word(),
            'contenu' => $this->faker->paragraph(1, false),
            'dateDebutSouhaitee' => $this->faker->dateTimeBetween('now', '+3 days'),
            'dateFinSouhaitee' => $this->faker->dateTimeBetween('+4 days', '+8 days'),
            'statutExamination' => $this->faker->randomElement(['enTraitement', 'acceptee', 'rejetee']),
            'observations' => $this->faker->paragraph(1, false),
        ];
    }
}
