<?php

namespace Database\Seeders\Forum;

use App\Models\Forum\Banissement;
use App\Models\Forum\Membre;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BanissementSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run()
    {

        $membres = Membre::limit(5)->get(['id', 'forum']);

        foreach ($membres as $membre) {

            Banissement::factory(1)->create(['membre' => $membre->id]);
        }

        echo Banissement::count()." banissement(s) créé(s).\n";
    }
}
