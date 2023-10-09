<?php

namespace Database\Seeders\Emploi;

use App\Models\Emploi\CandidatPortfolio;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CandidatPortfolioSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run()
    {
        CandidatPortfolio::factory()->createMany([

            ['intitule' => 'Conception de site web pour une entreprise de technologie'],
            ['intitule' => 'Campagne de marketing numérique réussie pour une start-up'],
            ['intitule' => 'Série de photographies primée sur la nature'],
            ['intitule' => 'Illustrations artistiques pour un livre pour enfants'],
            ['intitule' => "Rédaction d'un article vedette pour un magazine national"],
            ['intitule' => 'Application mobile de gestion de tâches populaire'],
            ['intitule' => "Conception d'une interface utilisateur intuitive pour une application"],
            ['intitule' => "Développement d'un logiciel de gestion des stocks"],
            ['intitule' => 'Campagne publicitaire à fort impact pour une ONG'],
            ['intitule' => 'Modélisation 3D pour une entreprise de jeux vidéo'],
            ['intitule' => 'Reportage en direct sur un événement majeur'],
            ['intitule' => "Conception d'une expérience utilisateur conviviale pour une application de commerce électronique"],
            ['intitule' => "Gestion réussie d'un projet de construction majeur"],
            ['intitule' => "Création d'un logo emblématique pour une marque de mode"],
            ['intitule' => 'Montage et production de vidéos promotionnelles'],
            ['intitule' => "Développement d'un jeu mobile addictif"],
            ['intitule' => "Conception de produits primée dans le secteur de l'électronique grand public"],
            ['intitule' => 'Recherche scientifique publiée dans une revue renommée'],
            ['intitule' => 'Campagne de relations publiques pour une entreprise Fortune 500'],
            ['intitule' => "Communication d'entreprise pour une fusion d'entreprise réussie"],
        ]);
    }
}
