<?php

namespace Database\Factories\Emploi;

use App\Models\Emploi\OffreEmploi;
use App\Models\Systeme\Pays;
use App\Models\Systeme\Utilisateur;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class OffreEmploiFactory extends Factory
{
    protected $model = OffreEmploi::class;

    public function definition()
    {

        $dateDebutPublication = Carbon::now()->format('Y-m-d');
        $dateFinPublication = Carbon::parse($dateDebutPublication)->addWeeks(2)->format('Y-m-d H:i:s');
        $statutPublication = Carbon::now()->gt($dateFinPublication) ? false : true;

        return [

            'poste' => $this->faker->jobTitle,
            'contrat' => $this->faker->randomElement(['CDD', 'CDI', 'Interim', 'Alternance', 'Stage']),
            'domaine' => $this->faker->randomElement(['Commerce', 'Informatique', 'Education', 'Ressources humaines', 'Comptabilité']),
            'nomOrganisation' => $this->faker->company,
            'infosOrganisation' => $this->faker->paragraph,
            'description' => $this->faker->paragraph,
            'prerequis' => $this->faker->paragraph,
            'lieu' => $this->faker->city,
            'pays' => Pays::inRandomOrder()->first()->id,
            'typeLieu' => $this->faker->randomElement(['surSite', 'teleTravail', 'hybride']),
            'remuneration' => $this->faker->randomNumber(6),
            'avantages' => $this->faker->paragraph,
            'places' => $this->faker->randomDigitNotNull(),
            'dateDebutPoste' => Carbon::parse($dateFinPublication)->addWeeks(2)->format('Y-m-d H:i:s'),
            'consignes' => $this->faker->paragraph,
            'infosComplementaires' => $this->faker->paragraph,
            'statutPublication' => $statutPublication,
            'pourcentageMoyenne' => $this->faker->randomElement([50, 55, 60, 65, 70, 75, 80]),
            'dateDebutPublication' => $dateDebutPublication,
            'dateFinPublication' => $dateFinPublication,
            'auteurCreation' => Utilisateur::inRandomOrder()->first()->id,
            'auteurMiseAJour' => Utilisateur::inRandomOrder()->first()->id,
        ];
    }
}
