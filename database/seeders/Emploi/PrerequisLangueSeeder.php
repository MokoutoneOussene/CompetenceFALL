<?php

namespace Database\Seeders\Emploi;

use App\Models\Emploi\PrerequisLangue;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PrerequisLangueSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run()
    {

        PrerequisLangue::factory()->createMany([

            ['intitule' => 'Mooré'],
            ['intitule' => 'Dioula'],
            ['intitule' => 'Foulfuldé'],
            ['intitule' => 'Dagara'],
            ['intitule' => 'Lobiri'],
            ['intitule' => 'Gouin'],
            ['intitule' => 'San'],
            ['intitule' => 'Espagnol'],
            ['intitule' => 'Anglais'],
            ['intitule' => 'Hindi'],
            ['intitule' => 'Arabe'],
            ['intitule' => 'Bengali'],
            ['intitule' => 'Portugais'],
            ['intitule' => 'Russe'],
            ['intitule' => 'Japonais'],
            ['intitule' => 'Lahnda'],
            ['intitule' => 'Marathi'],
            ['intitule' => 'Télougou'],
            ['intitule' => 'Turc'],
            ['intitule' => 'Français'],
            ['intitule' => 'Allemand'],
            ['intitule' => 'Farsi'],
            ['intitule' => 'Vietnamien'],
            ['intitule' => 'Coréen'],
            ['intitule' => 'Taïwanais'],
            ['intitule' => 'Cantonais'],
        ]);
    }
}
