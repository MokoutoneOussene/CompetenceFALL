<?php

namespace Database\Factories\Systeme;

use App\Models\Systeme\Pays;
use Illuminate\Database\Eloquent\Factories\Factory;

class PaysFactory extends Factory
{
    protected $model = Pays::class;

    public function definition()
    {
        return ['nom' => $this->faker->country];
    }
}
