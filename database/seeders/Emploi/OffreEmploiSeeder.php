<?php

namespace Database\Seeders\Emploi;

use App\Models\Emploi\OffreEmploi;
use App\Models\Systeme\Pays;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OffreEmploiSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run()
    {
        OffreEmploi::factory()->createMany([

            [
                'poste' => 'Designer Web Junior',
                'contrat' => 'CDI',
                'domaine' => 'Informatique',
                'nomOrganisation' => 'Tech Solutions Inc.',
                'infosOrganisation' => 'Une entreprise de technologie innovante.',
                'description' => 'Nous recherchons des designers web juniors talentueux pour rejoindre notre équipe.',
                'prerequis' => 'Diplôme en informatique, compétences en Design Motion.',
                'lieu' => 'Ouagadougou',
                'pays' => Pays::where('nom', 'Burkina Faso')->first(['id'])->id,
                'typeLieu' => 'surSite',
                'remuneration' => 350000,
                'avantages' => 'Assurance santé, formation continue, télétravail occasionnel.',
                'places' => 3,
                'dateDebutPoste' => '2023-10-15 09:00:00',
                'consignes' => 'Respecter les préréquis minimals avant de postuler.',
                'infosComplementaires' => 'Vous travaillerez sur des projets passionnants dans un environnement dynamique.',
                'statutPublication' => true,
            ],
            [
                'poste' => 'Spécialiste des Ressources Humaines',
                'contrat' => 'CDD',
                'domaine' => 'Ressources humaines',
                'nomOrganisation' => 'HR Solutions Ltd.',
                'infosOrganisation' => 'Une entreprise de conseil en ressources humaines.',
                'description' => 'Nous cherchons un spécialiste des RH pour un contrat à durée déterminée.',
                'prerequis' => 'Expérience en gestion des ressources humaines.',
                'lieu' => 'Lyon',
                'pays' => Pays::where('nom', 'France')->first(['id'])->id,
                'typeLieu' => 'surSite',
                'remuneration' => 450000,
                'avantages' => 'Tickets restaurant, horaires flexibles.',
                'places' => 1,
                'dateDebutPoste' => '2023-11-01 10:00:00',
                'consignes' => 'Envoyez votre CV et lettre de motivation.',
                'infosComplementaires' => 'Travaillez avec une équipe passionnée dans le domaine des RH.',
                'statutPublication' => true,
            ],
        ]);
    }
}
