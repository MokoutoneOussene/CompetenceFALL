<?php

namespace Database\Seeders\Forum;

use App\Models\Forum\Forum;
use Illuminate\Database\Seeder;

class ForumSeeder extends Seeder
{
    public function run()
    {

        Forum::factory(rand(1, 3))->create();

        echo Forum::count()." forum(s) créé(s).\n";
    }
}
