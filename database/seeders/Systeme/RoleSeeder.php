<?php

namespace Database\Seeders\Systeme;

use App\Models\Systeme\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run()
    {

        Role::factory()->createMany([
            [
                'intitule' => 'Système de sauvegarde',
                'slug' => 'sys',
                'categorie' => 'systeme',
                'description' => 'Système de gestion des sauvegardes.',
                'nombreUtilisateursLimite' => rand(1, 2),
            ],
            [
                'intitule' => 'Super administrateur',
                'slug' => 'sad',
                'categorie' => 'superadministrateur',
                'description' => 'Utilisateur ayant un accès complet et illimité à la plateforme.',
                'nombreUtilisateursLimite' => rand(1, 2),
            ],
            [
                'intitule' => 'Administrateur',
                'slug' => 'adm',
                'categorie' => 'administrateur',
                'description' => 'Responsable de la gestion des utilisateurs dont le niveau est inférieur au sien.',
                'nombreUtilisateursLimite' => rand(1, 2),
            ],
            [
                'intitule' => 'Responsable des utilisateurs standards',
                'slug' => 'rcp',
                'categorie' => 'responsable',
                'description' => 'Responsable de la gestion des collaborateurs, des participants, des marketers et des demandes de collaboration.',
                'nombreUtilisateursLimite' => rand(1, 2),
            ],
            [
                'intitule' => 'Responsable des formations et des planifications',
                'slug' => 'rfp',
                'categorie' => 'responsable',
                'description' => 'Responsable de la gestion des formations, des planifications, des demandes de formations et des candidatures aux formations en présentielles.',
                'nombreUtilisateursLimite' => rand(1, 2),
            ],
            [
                'intitule' => 'Responsable des prestations en ressources humaines',
                'slug' => 'rpr',
                'categorie' => 'responsable',
                'description' => 'Responsable des demandes de prestations dans le domaine des ressources humaines.',
                'nombreUtilisateursLimite' => rand(1, 2),
            ],
            [
                'intitule' => 'Responsable des prestations en projets et programmes',
                'slug' => 'rpt',
                'categorie' => 'responsable',
                'description' => 'Responsable des prestations dans le domaine projets et programmes.',
                'nombreUtilisateursLimite' => rand(1, 2),
            ],
            [
                'intitule' => "Responsable des organisations et offres d'emploi",
                'slug' => 'roo',
                'categorie' => 'responsable',
                'description' => "Responsable des offres d'emploi, des organisations et des candidatures aux offres d'emploi.",
                'nombreUtilisateursLimite' => rand(1, 2),
            ],
            [
                'intitule' => 'Responsable des finances',
                'slug' => 'rfi',
                'categorie' => 'responsable',
                'description' => 'Responsable des finances, des paiements entrants et sortants.',
                'nombreUtilisateursLimite' => rand(1, 2),
            ],
            [
                'intitule' => 'Moderateur',
                'slug' => 'mod',
                'categorie' => 'responsable',
                'description' => 'Responsable des forums.',
                'nombreUtilisateursLimite' => rand(1, 2),
            ],
            [
                'intitule' => 'Marketer',
                'slug' => 'mar',
                'categorie' => 'standard',
                'description' => 'Utilisateur ayant un code promo de marketing.',
                'nombreUtilisateursLimite' => rand(1, 2),
            ],
            [
                'intitule' => 'Collaborateur',
                'slug' => 'col',
                'categorie' => 'collaborateur',
                'description' => 'Utilisateur repertorié comme collaborateur.',
                'nombreUtilisateursLimite' => rand(1, 2),
            ],
            [
                'intitule' => 'Formateur',
                'slug' => 'for',
                'categorie' => 'collaborateur',
                'description' => 'Utilisateur repertorié comme formateur.',
                'nombreUtilisateursLimite' => rand(1, 2),
            ],
            [
                'intitule' => 'Participant',
                'slug' => 'par',
                'categorie' => 'standard',
                'description' => 'Utilisateur participant aux formations.',
                'nombreUtilisateursLimite' => rand(1, 2),
            ],
            [
                'intitule' => 'Candidat',
                'slug' => 'can',
                'categorie' => 'standard',
                'description' => "Utilisateur postulant aux offres d'emploi.",
                'nombreUtilisateursLimite' => rand(1, 2),
            ],
            [
                'intitule' => 'Client',
                'slug' => 'cli',
                'categorie' => 'standard',
                'description' => 'Utilisateur soumettant des demandes de services.',
                'nombreUtilisateursLimite' => rand(1, 2),
            ],
        ]);

        echo Role::count()." rôle(s) créé(s).\n";
    }
}
