<?php

namespace Database\Factories\Forum;

use App\Models\Forum\Banissement;
use App\Models\Forum\Membre;
use Illuminate\Database\Eloquent\Factories\Factory;

class BanissementFactory extends Factory
{
    protected $model = Banissement::class;

    public function definition()
    {

        return [

            'membre' => Membre::inRandomOrder()->first(['id'])->id,
            'motif' => $this->faker->paragraph(1, false),
        ];
    }
}
