<?php

namespace Database\Seeders\Interface;

use App\Models\Interface\Application;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ApplicationSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {

        Application::factory(1)->create([
            'denomination' => 'Postman en environnement de développement',
            'jeton' => 'da718b26-4308-411c-8fde-ad6049b10a76',
            'statutActivation' => true,
            'dateExpiration' => '2025-12-31 23:59:59',
        ]);

        Application::factory(2)->create();
    }
}
