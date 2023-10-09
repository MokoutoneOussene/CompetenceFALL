<?php

namespace Database\Factories\Systeme;

use App\Models\Systeme\CommentaireAnonyme;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentaireAnonymeFactory extends Factory
{
    protected $model = CommentaireAnonyme::class;

    public function definition()
    {

        return [

            'email' => $this->faker->safeEmail(),
            'objet' => $this->faker->word(),
            'contenu' => $this->faker->paragraph(4),
        ];
    }
}
