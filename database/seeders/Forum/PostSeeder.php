<?php

namespace Database\Seeders\Forum;

use App\Models\Forum\Forum;
use App\Models\Forum\Post;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run()
    {

        $forums = Forum::all(['id']);

        foreach ($forums as $forum) {
            Post::factory(rand(1, 2))->create(['forum' => $forum->id]);
        }

        echo Post::count()." post(s) créé(s).\n";
    }
}
