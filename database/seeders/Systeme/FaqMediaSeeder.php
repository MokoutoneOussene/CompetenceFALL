<?php

namespace Database\Seeders\Systeme;

use App\Models\Systeme\Faq;
use App\Models\Systeme\FaqMedia;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FaqMediaSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {

        $faqs = Faq::all(['id']);

        foreach ($faqs as $faq) {
            FaqMedia::factory(rand(1, 2))->create(['faq' => $faq->id]);
        }

        echo FaqMedia::count()." média(s) pour les foire(s) aux questions créé(s).\n";
    }
}
