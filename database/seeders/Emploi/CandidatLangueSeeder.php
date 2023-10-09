<?php

namespace Database\Seeders\Emploi;

use App\Models\Emploi\CandidatLangue;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CandidatLangueSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run()
    {
        CandidatLangue::factory()->createMany([

            ['intitule' => 'Chinois (Mandarin)'],
            ['intitule' => 'Espagnol'],
            ['intitule' => 'Anglais'],
            ['intitule' => 'Hindi'],
            ['intitule' => 'Arabe'],
            ['intitule' => 'Bengali'],
            ['intitule' => 'Portugais'],
            ['intitule' => 'Russe'],
            ['intitule' => 'Japonais'],
            ['intitule' => 'Lahnda (Pakistanais occidental)'],
            ['intitule' => 'Marathi'],
            ['intitule' => 'Télougou'],
            ['intitule' => 'Turc'],
            ['intitule' => 'Français'],
            ['intitule' => 'Allemand'],
            ['intitule' => 'Persan (Farsi)'],
            ['intitule' => 'Vietnamien'],
            ['intitule' => 'Coréen'],
            ['intitule' => 'Taïwanais (Min Nan)'],
            ['intitule' => 'Cantonais'],
        ]);
    }
}
