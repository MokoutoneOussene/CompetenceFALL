<?php

namespace Database\Seeders\Emploi;

use App\Models\Emploi\CandidatCertificat;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CandidatCertificatSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run()
    {
        CandidatCertificat::factory()->createMany([

            ['intitule' => 'Certificat en gestion de projet'],
            ['intitule' => 'Certificat en marketing numérique'],
            ['intitule' => 'Certificat en comptabilité'],
            ['intitule' => 'Certificat en gestion des ressources humaines'],
            ['intitule' => 'Certificat en design graphique'],
            ['intitule' => 'Certificat en soins infirmiers'],
            ['intitule' => 'Certificat en sécurité informatique'],
            ['intitule' => 'Certificat en gestion financière'],
            ['intitule' => 'Certificat en développement personnel'],
            ['intitule' => 'Certificat en leadership'],
            ['intitule' => 'Certificat en formation et développement'],
            ['intitule' => "Certificat en gestion de la chaîne d'approvisionnement"],
            ['intitule' => 'Certificat en gestion de la qualité'],
            ['intitule' => 'Certificat en marketing des médias sociaux'],
            ['intitule' => 'Certificat en gestion de la santé'],
            ['intitule' => 'Certificat en gestion de projet agile'],
            ['intitule' => 'Certificat en analyse de données'],
            ['intitule' => 'Certificat en communication professionnelle'],
            ['intitule' => 'Certificat en gestion de la logistique'],
            ['intitule' => 'Certificat en développement web'],
        ]);
    }
}
