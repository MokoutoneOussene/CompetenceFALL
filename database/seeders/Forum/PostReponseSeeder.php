<?php

namespace Database\Seeders\Forum;

use App\Models\Forum\Post;
use App\Models\Forum\PostReponse;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostReponseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run()
    {

        $posts = Post::all(['id']);

        foreach ($posts as $post) {
            PostReponse::factory(rand(1, 2))->create(['post' => $post->id]);
        }

        echo PostReponse::count()." réponse(s) aux posts créé(s).\n";
    }
}
