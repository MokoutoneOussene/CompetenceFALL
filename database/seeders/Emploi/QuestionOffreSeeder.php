<?php

namespace Database\Seeders\Emploi;

use App\Models\Emploi\QuestionOffre;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class QuestionOffreSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run()
    {

        QuestionOffre::factory()->createMany([

            [
                'contenu' => "Quelle est la principale responsabilité d'un développeur web junior ?",
                'typeQuestion' => 'reponseCourte',
                'note' => null,
                'bonneReponse' => null,
            ],
            [
                'contenu' => 'Vrai ou faux : HTML est un langage de programmation ?',
                'typeQuestion' => 'vraiFaux',
                'note' => 3,
                'bonneReponse' => true,
            ],
            [
                'contenu' => 'Quelles compétences sont essentielles pour un spécialiste des ressources humaines ?',
                'typeQuestion' => 'reponseCourte',
                'note' => null,
                'bonneReponse' => null,
            ],
            [
                'contenu' => 'Vrai ou faux : La gestion du personnel est une tâche importante pour un spécialiste des ressources humaines ?',
                'typeQuestion' => 'vraiFaux',
                'note' => 3,
                'bonneReponse' => true,
            ],
        ]);
    }
}
