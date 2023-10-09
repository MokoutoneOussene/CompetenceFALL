<?php

namespace Database\Factories\Systeme;

use App\Models\Systeme\Privilege;
use App\Models\Systeme\Role;
use App\Models\Systeme\Utilisateur;
use Illuminate\Database\Eloquent\Factories\Factory;

class PrivilegeFactory extends Factory
{
    protected $model = Privilege::class;

    public function definition()
    {

        return [

            'utilisateur' => Utilisateur::inRandomOrder()->first(['id'])->id,
            'role' => Role::inRandomOrder()->first(['id'])->id,
            'statutActivation' => $this->faker->boolean(70),
        ];
    }
}
