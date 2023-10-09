<?php

namespace Database\Seeders\Forum;

use App\Models\Forum\Post;
use App\Models\Forum\PostMedia;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostMediaSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run()
    {

        $posts = Post::all(['id']);

        foreach ($posts as $post) {
            PostMedia::factory(rand(1, 2))->create(['post' => $post->id]);
        }

        echo PostMedia::count()." média(s) pour les posts créé(s).\n";
    }
}
