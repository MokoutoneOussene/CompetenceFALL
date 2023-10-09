<?php

namespace Database\Seeders\Emploi;

use App\Models\Emploi\NiveauSpecialisation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NiveauSpecialisationSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run()
    {

        $niveauxSpecialisations = [
            [
                'intitule' => "Brevet d'Études du Premier Cycle (BEPC)",
                'abreviation' => 'BEPC',
                'niveau' => 1,
                'description' => 'Diplôme du premier cycle du collège.',
            ],
            [
                'intitule' => "Brevet d'Études Professionnelles (BEP)",
                'abreviation' => 'BEP',
                'niveau' => 3,
                'description' => 'Diplôme de formation professionnelle de niveau intermédiaire.',
            ],
            [
                'intitule' => "Certificat d'Aptitude Professionnelle (CAP)",
                'abreviation' => 'CAP',
                'niveau' => 3,
                'description' => 'Diplôme de formation professionnelle de niveau intermédiaire.',
            ],
            [
                'intitule' => 'Brevet de Technicien (BT)',
                'abreviation' => 'BT',
                'niveau' => 3,
                'description' => 'Diplôme technique de niveau intermédiaire.',
            ],
            [
                'intitule' => "Diplôme d'Études Secondaires (DES)",
                'abreviation' => 'DES',
                'niveau' => 4,
                'description' => "Diplôme de fin d'études secondaires.",
            ],
            [
                'intitule' => 'Baccalauréat (BAC)',
                'abreviation' => 'BAC',
                'niveau' => 4,
                'description' => "Diplôme de fin d'études secondaires permettant l'accès à l'enseignement supérieur.",
            ],
            [
                'intitule' => 'Baccalauréat Professionnel (BAC Pro)',
                'abreviation' => 'BAC Pro',
                'niveau' => 5,
                'description' => "Diplôme de fin d'études secondaires avec une orientation professionnelle.",
            ],
            [
                'intitule' => "Diplôme d'Études Universitaires Générales (DEUG)",
                'abreviation' => 'DEUG',
                'niveau' => 6,
                'description' => 'Diplôme universitaire de niveau intermédiaire.',
            ],
            [
                'intitule' => 'Diplôme Universitaire de Technologie (DUT)',
                'abreviation' => 'DUT',
                'niveau' => 6,
                'description' => "Diplôme technique de niveau supérieur obtenu à l'université.",
            ],
            [
                'intitule' => 'Brevet de Technicien Supérieur (BTS)',
                'abreviation' => 'BTS',
                'niveau' => 6,
                'description' => 'Diplôme supérieur en technologie et sciences appliquées.',
            ],
            [
                'intitule' => 'Diplôme de Technicien Supérieur (DTS)',
                'abreviation' => 'DTS',
                'niveau' => 6,
                'description' => 'Diplôme supérieur en technologie et sciences appliquées.',
            ],
            [
                'intitule' => 'Licence',
                'abreviation' => 'L',
                'niveau' => 7,
                'description' => 'Diplôme universitaire de premier cycle.',
            ],
            [
                'intitule' => 'Maitrise',
                'abreviation' => 'M1',
                'niveau' => 8,
                'description' => 'Diplôme universitaire de second cycle.',
            ],
            [
                'intitule' => 'Master',
                'abreviation' => 'M2',
                'niveau' => 9,
                'description' => 'Diplôme universitaire de second cycle.',
            ],
            [
                'intitule' => 'Doctorat (Ph.D)',
                'abreviation' => 'Ph.D.',
                'niveau' => 12,
                'description' => 'Diplôme universitaire de troisième cycle.',
            ],
            [
                'intitule' => 'Diplômes de spécialisation post-doctorale.',
                'abreviation' => 'DSPD',
                'niveau' => 15,
                'description' => 'Diplômes obtenus après le doctorat.',
            ],
        ];

        NiveauSpecialisation::factory()->createMany($niveauxSpecialisations);
    }
}
