<?php

namespace Database\Seeders\Forum;

use App\Models\Forum\Post;
use App\Models\Forum\PostReaction;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostReactionSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run()
    {

        $posts = Post::all(['id']);

        foreach ($posts as $post) {
            PostReaction::factory(rand(1, 2))->create(['post' => $post->id]);
        }

        echo PostReaction::count()." réaction(s) aux posts créé(s).\n";
    }
}
