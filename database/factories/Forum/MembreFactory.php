<?php

namespace Database\Factories\Forum;

use App\Models\Forum\Forum;
use App\Models\Forum\Membre;
use App\Models\Systeme\Utilisateur;
use Illuminate\Database\Eloquent\Factories\Factory;

class MembreFactory extends Factory
{
    protected $model = Membre::class;

    public function definition()
    {

        return [

            'utilisateur' => Utilisateur::inRandomOrder()->first(['id'])->id,
            'forum' => Forum::inRandomOrder()->first(['id'])->id,
            'statutActivation' => $this->faker->boolean(),
        ];
    }
}
