<?php

namespace Database\Seeders\Emploi;

use App\Models\Emploi\DomaineEtude;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DomaineEtudeSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run()
    {

        $domainesEtudes = [

            [
                'intitule' => 'Sciences naturelles',
                'description' => 'Étude des phénomènes naturels et des sciences biologiques.',
            ],
            [
                'intitule' => "Sciences de la Terre et de l'environnement",
                'description' => "Étude de la Terre, de l'environnement et des phénomènes géologiques.",
            ],
            [
                'intitule' => 'Sciences de la santé',
                'description' => 'Étude des sciences médicales et de la santé humaine.',
            ],
            [
                'intitule' => 'Sciences sociales',
                'description' => 'Étude des comportements et interactions sociales.',
            ],
            [
                'intitule' => 'Sciences humaines',
                'description' => "Étude de l'histoire, de la culture et de la société humaine.",
            ],
            [
                'intitule' => "Sciences de l'éducation",
                'description' => "Étude des méthodes d'enseignement et de l'apprentissage.",
            ],
            [
                'intitule' => 'Sciences économiques et commerciales',
                'description' => "Étude de l'économie, des affaires et du commerce.",
            ],
            [
                'intitule' => "Sciences de l'ingénieur",
                'description' => "Étude de l'ingénierie et des sciences de l'ingénieur.",
            ],
            [
                'intitule' => 'Arts et beaux-arts',
                'description' => 'Étude des arts visuels, de la musique et de la créativité artistique.',
            ],
            [
                'intitule' => 'Droit et sciences politiques',
                'description' => 'Étude du droit et des sciences politiques.',
            ],
            [
                'intitule' => "Sciences de l'informatique et de la technologie",
                'description' => "Étude de l'informatique, de la technologie et de l'ingénierie informatique.",
            ],
            [
                'intitule' => 'Sciences de la communication et des médias',
                'description' => 'Étude de la communication, des médias et du journalisme.',
            ],
            [
                'intitule' => 'Mathématiques et statistiques',
                'description' => 'Étude des mathématiques et des statistiques.',
            ],
            [
                'intitule' => "Sciences agricoles et de l'alimentation",
                'description' => "Étude de l'agriculture, de l'alimentation et de la nutrition.",
            ],
            [
                'intitule' => "Sciences de la gestion et de l'administration",
                'description' => "Étude de la gestion d'entreprise et de l'administration.",
            ],
            [
                'intitule' => 'Sciences du sport et de la santé physique',
                'description' => 'Étude du sport, de la santé physique et de la performance athlétique.',
            ],
            [
                'intitule' => "Sciences de la bibliothéconomie et de l'information",
                'description' => "Étude de la gestion de l'information et des bibliothèques.",
            ],
            [
                'intitule' => 'Sciences sociales appliquées',
                'description' => 'Application des sciences sociales à des problèmes pratiques.',
            ],
            [
                'intitule' => 'Sciences de la mode et du design',
                'description' => 'Étude de la mode, du design et de la créativité artistique.',
            ],
            [
                'intitule' => "Sciences de l'enfance et de la famille",
                'description' => "Étude de l'enfance, de la famille et du développement humain.",
            ],
        ];

        DomaineEtude::factory()->createMany($domainesEtudes);
    }
}
