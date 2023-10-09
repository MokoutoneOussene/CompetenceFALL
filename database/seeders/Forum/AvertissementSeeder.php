<?php

namespace Database\Seeders\Forum;

use App\Models\Forum\Avertissement;
use App\Models\Forum\Membre;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AvertissementSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run()
    {

        $membres = Membre::all();

        foreach ($membres as $membre) {

            $forum = $membre->forum()->first();
            $posts = $forum->posts()->get(['id']);

            Avertissement::factory(1)->create([
                'membre' => $membre->id,
                'post' => $posts->random()->id,
            ]);
        }

        echo Avertissement::count()." avertissement(s) créé(s).\n";
    }
}
