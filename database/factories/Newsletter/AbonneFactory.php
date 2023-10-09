<?php

namespace Database\Factories\Newsletter;

use App\Models\Newsletter\Abonne;
use App\Models\Newsletter\NewsletterCategorie;
use Illuminate\Database\Eloquent\Factories\Factory;

class AbonneFactory extends Factory
{
    protected $model = Abonne::class;

    public function definition()
    {

        return [

            'categorie' => NewsletterCategorie::inRandomOrder()->first(['id'])->id,
            'email' => $this->faker->unique()->safeEmail(),
        ];
    }
}
