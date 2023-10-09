<?php

namespace Database\Factories\Systeme;

use App\Models\Systeme\Faq;
use Illuminate\Database\Eloquent\Factories\Factory;

class FaqFactory extends Factory
{
    protected $model = Faq::class;

    public function definition()
    {

        return [

            'question' => $this->faker->paragraph(1, false),
            'reponse' => $this->faker->paragraph(4, false),
        ];
    }
}
