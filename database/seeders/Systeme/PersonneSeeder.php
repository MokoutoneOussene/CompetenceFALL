<?php

namespace Database\Seeders\Systeme;

use App\Models\Systeme\Pays;
use App\Models\Systeme\Personne;
use App\Models\Systeme\Utilisateur;
use Illuminate\Database\Seeder;

class PersonneSeeder extends Seeder
{
    public function run(): void
    {

        Personne::factory()->createMany([
            [
                'utilisateur' => Utilisateur::where('nomUtilisateur', 'candidat-alpha')->first(['id'])->id,
                'nom' => 'Ouédraogo',
                'prenoms' => 'Bassirou',
                'genre' => 'masculin',
                'dateNaissance' => '1980-01-01 06:00:00',
                'lieuNaissance' => 'Bobo-Dioulasso',
                'paysNaissance' => Pays::where('nom', 'Burkina Faso')->first(['id'])->id,
                'lieuResidence' => 'Ouagadougou',
                'paysResidence' => Pays::where('nom', 'Burkina Faso')->first(['id'])->id,
                'nationalites' => 'Burkinabé',
            ],
            [
                'utilisateur' => Utilisateur::where('nomUtilisateur', 'candidat-beta')->first(['id'])->id,
                'nom' => 'BOUDA',
                'prenoms' => 'Larissa',
                'genre' => 'feminin',
                'dateNaissance' => '1990-01-01 06:00:00',
                'lieuNaissance' => 'Kaya',
                'paysNaissance' => Pays::where('nom', 'Burkina Faso')->first(['id'])->id,
                'lieuResidence' => 'Accra',
                'paysResidence' => Pays::where('nom', 'Ghana')->first(['id'])->id,
                'nationalites' => 'Burkinabé',
            ],
            [
                'utilisateur' => Utilisateur::where('nomUtilisateur', 'roo-alpha')->first(['id'])->id,
                'nom' => 'ZANGRE',
                'prenoms' => 'Mathieu',
                'genre' => 'masculin',
                'dateNaissance' => '1995-01-01 06:00:00',
                'lieuNaissance' => "Fada N'Gourma",
                'paysNaissance' => Pays::where('nom', 'Burkina Faso')->first(['id'])->id,
                'lieuResidence' => 'Dijon',
                'paysResidence' => Pays::where('nom', 'France')->first(['id'])->id,
                'nationalites' => 'Burkinabé, Français',
            ],
        ]);

        echo Personne::count()." personne(s) créée(s).\n";
    }
}
