<?php

namespace Database\Factories\Emploi;

use App\Models\Emploi\OffreEmploi;
use App\Models\Emploi\PrerequisLangue;
use Illuminate\Database\Eloquent\Factories\Factory;

class PrerequisLangueFactory extends Factory
{
    protected $model = PrerequisLangue::class;

    public function definition()
    {

        $niveau = $this->faker->optional()->randomElement(['a1', 'b1', 'c1', 'a2', 'b2', 'c2']);
        $statutParle = $this->faker->boolean;
        $statutLu = $this->faker->boolean;
        $statutEcrit = $this->faker->boolean;

        return [
            'offre' => OffreEmploi::factory(),
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
            'noteLangue' => $this->faker->numberBetween(0, 100),
            'niveau' => $niveau,
            'noteNiveau' => $niveau != null ? $this->faker->numberBetween(0, 100) : null,
            'statutParle' => $statutParle,
            'noteStatutParle' => $statutParle != false ? $this->faker->numberBetween(0, 10) : null,
            'statutLu' => $statutLu,
            'noteStatutLu' => $statutLu != false ? $this->faker->numberBetween(0, 10) : null,
            'statutEcrit' => $statutEcrit,
            'noteStatutEcrit' => $statutEcrit != false ? $this->faker->numberBetween(0, 10) : null,
        ];
    }
}
