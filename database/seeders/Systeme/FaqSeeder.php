<?php

namespace Database\Seeders\Systeme;

use App\Models\Systeme\Faq;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {

        Faq::factory(rand(1, 3))->create();

        echo Faq::count()." foire(s) aux questions créée(s).\n";
    }
}
