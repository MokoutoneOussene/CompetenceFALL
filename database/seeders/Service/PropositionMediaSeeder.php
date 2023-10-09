<?php

namespace Database\Seeders\Service;

use App\Models\Service\Proposition;
use App\Models\Service\PropositionMedia;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PropositionMediaSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run()
    {

        $propositions = Proposition::all(['id']);

        foreach ($propositions as $proposition) {
            PropositionMedia::factory(rand(1, 2))->create(['proposition' => $proposition->id]);
        }

        echo PropositionMedia::count()." pièce-jointe(s) aux propostions aux demande de service créée(s).\n";
    }
}
