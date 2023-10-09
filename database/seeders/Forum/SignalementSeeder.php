<?php

namespace Database\Seeders\Forum;

use App\Models\Forum\Membre;
use App\Models\Forum\Signalement;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SignalementSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run()
    {

        $membres = Membre::all();

        foreach ($membres as $membre) {

            $forum = $membre->forum()->first();

            $posts = $forum->posts()->get(['id']);

            Signalement::factory(1)->create([
                'membre' => $membre->id,
                'post' => $posts->random()->id,
            ]);
        }

        echo Signalement::count()." signalement(s) de posts créé(s).\n";
    }
}
