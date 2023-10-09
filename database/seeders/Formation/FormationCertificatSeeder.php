<?php

namespace Database\Seeders\Formation;

use App\Models\Formation\Formation;
use App\Models\Formation\FormationCertificat;
use App\Models\Formation\Participant;
use Illuminate\Database\Seeder;

class FormationCertificatSeeder extends Seeder
{
    public function run()
    {

        $participants = Participant::all(['id']);

        foreach ($participants as $participant) {

            FormationCertificat::factory(1)->create(['participant' => $participant->id]);
        }

        echo Formation::count()." certificat(s) créé(s).\n";
    }
}
