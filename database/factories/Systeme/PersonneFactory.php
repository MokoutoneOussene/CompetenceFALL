<?php

namespace Database\Factories\Systeme;

use App\Models\Systeme\Pays;
use App\Models\Systeme\Personne;
use App\Models\Systeme\Utilisateur;
use Illuminate\Database\Eloquent\Factories\Factory;

class PersonneFactory extends Factory
{
    protected $model = Personne::class;

    public function definition()
    {

        $utilisateur = Utilisateur::where('typeUtilisateur', 'personne')->inRandomOrder()->first(['id'])->id;
        $paysNaissance = Pays::inRandomOrder()->first(['id', 'nom']);
        $paysResidence = Pays::inRandomOrder()->first(['id', 'nom']);
        $nationalites = $paysNaissance->nom.', '.$paysResidence->nom;

        return [

            'utilisateur' => $utilisateur,
            'nom' => $this->faker->lastName(),
            'prenoms' => $this->faker->firstName(),
            'genre' => $this->faker->randomElement(['masculin', 'feminin', 'nonPrecise']),
            'dateNaissance' => $this->faker->dateTimeBetween('-100 years', '-18 years')->format('Y-m-d H:i:s'),
            'lieuNaissance' => $this->faker->city(),
            'paysNaissance' => $paysNaissance->id,
            'lieuResidence' => $this->faker->city(),
            'paysResidence' => $paysResidence->id,
            'nationalites' => $nationalites,
        ];
    }
}
