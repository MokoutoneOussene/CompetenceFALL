<?php

namespace Database\Seeders\Formation;

use App\Models\Finance\Facture;
use App\Models\Formation\Formation;
use App\Models\Formation\Participant;
use App\Models\Systeme\Utilisateur;
use Illuminate\Database\Seeder;

class ParticipantSeeder extends Seeder
{
    public function run()
    {

        $formations = Formation::all(['id', 'cout']);

        foreach ($formations as $formation) {

            $utilisateur = Utilisateur::inRandomOrder()->first(['id']);
            $facture = Facture::factory()->create([
                'client' => $utilisateur->id,
                'montantTTC' => $formation->cout,
            ]);

            Participant::factory(rand(1, 2))->create([
                'utilisateur' => $utilisateur->id,
                'formation' => $formation->id,
                'facture' => $facture->id,
            ]);
        }

        echo Participant::count()." inscription(s) de participants créé(s).\n";
    }
}
