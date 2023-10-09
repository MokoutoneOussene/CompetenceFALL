<?php

namespace Database\Factories\Systeme;

use App\Models\Systeme\Role;
use Illuminate\Database\Eloquent\Factories\Factory;

class RoleFactory extends Factory
{
    protected $model = Role::class;

    public function definition()
    {

        $intitule = ucfirst('Role '.$this->faker->unique()->word);
        $slug = substr($intitule, rand(1, 3), 3);

        return [

            'iconeRole' => $this->faker->unique()->filePath(),
            'intitule' => $intitule,
            'slug' => $slug,
            'categorie' => $this->faker->randomElement([
                'systeme', 'superadministrateur', 'administrateur', 'responsable', 'collaborateur', 'standard',
            ]),
            'description' => $this->faker->paragraph(1, false),
            'nombreUtilisateursLimite' => $this->faker->randomNumber(3),
        ];
    }
}
