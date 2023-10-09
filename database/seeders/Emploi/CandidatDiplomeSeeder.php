<?php

namespace Database\Seeders\Emploi;

use App\Models\Emploi\CandidatDiplome;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CandidatDiplomeSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run()
    {
        CandidatDiplome::factory()->createMany([

            ['intitule' => 'Baccalauréat en arts (B.A.)'],
            ['intitule' => 'Baccalauréat en sciences (B.Sc.)'],
            ['intitule' => 'Master en administration des affaires (MBA)'],
            ['intitule' => 'Doctorat en médecine (M.D.)'],
            ['intitule' => 'Juris Doctor (J.D.)'],
            ['intitule' => 'Doctorat en philosophie (Ph.D.)'],
            ['intitule' => 'Master en éducation (M.Ed.)'],
            ['intitule' => 'Licence en génie civil'],
            ['intitule' => 'Licence en sciences infirmières (B.Sc. Infirmière)'],
            ['intitule' => 'Licence en comptabilité (B.Compt.)'],
            ['intitule' => "Master en sciences de l'informatique (M.Sc. Informatique)"],
            ['intitule' => 'Diplôme en gestion des ressources humaines'],
            ['intitule' => 'Diplôme en marketing numérique'],
            ['intitule' => 'Diplôme en design graphique'],
            ['intitule' => 'Licence en administration des affaires (B.B.A.)'],
            ['intitule' => 'Diplôme en soins infirmiers auxiliaires autorisés (SIAA)'],
            ['intitule' => 'Licence en psychologie'],
            ['intitule' => 'Diplôme en génie électrique'],
            ['intitule' => 'Diplôme en développement web'],
            ['intitule' => 'Master en santé publique (MSP)'],
            ['intitule' => 'Diplôme en gestion de projet'],
            ['intitule' => 'Licence en sciences politiques'],
            ['intitule' => "Diplôme en communication d'entreprise"],
            ['intitule' => 'Master en beaux-arts (MFA)'],
            ['intitule' => "Diplôme en technologie de l'information"],
            ['intitule' => 'Licence en économie'],
            ['intitule' => "Diplôme en éducation de l'enfance"],
            ['intitule' => "Master en sciences de l'environnement (M.Sc. Environnement)"],
            ['intitule' => 'Diplôme en gestion hôtelière'],
            ['intitule' => 'Licence en architecture'],
        ]);
    }
}
