<?php

namespace Database\Seeders;

use Database\Seeders\Blog\BlogArticleSeeder;
use Database\Seeders\Blog\BlogCategorieSeeder;
use Database\Seeders\Blog\BlogMediaSeeder;
use Database\Seeders\Blog\BlogPageSeeder;
use Database\Seeders\Emploi\CandidatCentreSeeder;
use Database\Seeders\Emploi\CandidatCertificatSeeder;
use Database\Seeders\Emploi\CandidatCompetenceSeeder;
use Database\Seeders\Emploi\CandidatDiplomeSeeder;
use Database\Seeders\Emploi\CandidatExperienceSeeder;
use Database\Seeders\Emploi\CandidatLangueSeeder;
use Database\Seeders\Emploi\CandidatPortfolioSeeder;
use Database\Seeders\Emploi\CandidatReferenceSeeder;
use Database\Seeders\Emploi\CandidatureCentreSeeder;
use Database\Seeders\Emploi\CandidatureCertificatSeeder;
use Database\Seeders\Emploi\CandidatureCompetenceSeeder;
use Database\Seeders\Emploi\CandidatureConvocationSeeder;
use Database\Seeders\Emploi\CandidatureDiplomeSeeder;
use Database\Seeders\Emploi\CandidatureExperienceSeeder;
use Database\Seeders\Emploi\CandidatureLangueSeeder;
use Database\Seeders\Emploi\CandidaturePortfolioSeeder;
use Database\Seeders\Emploi\CandidatureReferenceSeeder;
use Database\Seeders\Emploi\CandidatureReponseSeeder;
use Database\Seeders\Emploi\CandidatureSeeder;
use Database\Seeders\Emploi\DomaineEtudeSeeder;
use Database\Seeders\Emploi\NiveauEtudeSeeder;
use Database\Seeders\Emploi\NiveauSpecialisationSeeder;
use Database\Seeders\Emploi\OffreEmploiSeeder;
use Database\Seeders\Emploi\PrerequisCertificatSeeder;
use Database\Seeders\Emploi\PrerequisDiplomeSeeder;
use Database\Seeders\Emploi\PrerequisExperienceSeeder;
use Database\Seeders\Emploi\PrerequisLangueSeeder;
use Database\Seeders\Emploi\QuestionOffreSeeder;
use Database\Seeders\Finance\BienSeeder;
use Database\Seeders\Finance\FactureSeeder;
use Database\Seeders\Finance\PaiementSeeder;
use Database\Seeders\Finance\RemboursementSeeder;
use Database\Seeders\Finance\RemiseSeeder;
use Database\Seeders\Formation\CompositionSeeder;
use Database\Seeders\Formation\EvaluationMediaSeeder;
use Database\Seeders\Formation\EvaluationSeeder;
use Database\Seeders\Formation\FormationCertificatSeeder;
use Database\Seeders\Formation\FormationMediaSeeder;
use Database\Seeders\Formation\FormationPageSeeder;
use Database\Seeders\Formation\FormationPartieSeeder;
use Database\Seeders\Formation\FormationPrerequisSeeder;
use Database\Seeders\Formation\FormationPresentielleSeeder;
use Database\Seeders\Formation\FormationProgrammeSeeder;
use Database\Seeders\Formation\FormationProgressionSeeder;
use Database\Seeders\Formation\FormationQuestionSeeder;
use Database\Seeders\Formation\FormationReponseSeeder;
use Database\Seeders\Formation\FormationSeeder;
use Database\Seeders\Formation\ParticipantSeeder;
use Database\Seeders\Formation\TirageSeeder;
use Database\Seeders\Forum\AvertissementSeeder;
use Database\Seeders\Forum\BanissementSeeder;
use Database\Seeders\Forum\ForumSeeder;
use Database\Seeders\Forum\MembreSeeder;
use Database\Seeders\Forum\PostMediaSeeder;
use Database\Seeders\Forum\PostReactionSeeder;
use Database\Seeders\Forum\PostReponseSeeder;
use Database\Seeders\Forum\PostSeeder;
use Database\Seeders\Forum\SignalementSeeder;
use Database\Seeders\Interface\ApplicationSeeder;
use Database\Seeders\Marketing\MarketeurSeeder;
use Database\Seeders\Marketing\MarketingPaiementSeeder;
use Database\Seeders\Marketing\MarketingVenteSeeder;
use Database\Seeders\Newsletter\AbonneSeeder;
use Database\Seeders\Newsletter\NewsletterArticleSeeder;
use Database\Seeders\Newsletter\NewsletterCategorieSeeder;
use Database\Seeders\Newsletter\NewsletterMediaSeeder;
use Database\Seeders\Newsletter\NewsletterPageSeeder;
use Database\Seeders\Service\AttestationSeeder;
use Database\Seeders\Service\DemandeMediaSeeder;
use Database\Seeders\Service\DemandeSeeder;
use Database\Seeders\Service\PropositionMediaSeeder;
use Database\Seeders\Service\PropositionSeeder;
use Database\Seeders\Systeme\BanniereSeeder;
use Database\Seeders\Systeme\ChiffreSeeder;
use Database\Seeders\Systeme\CommentaireAnonymeSeeder;
use Database\Seeders\Systeme\FaqMediaSeeder;
use Database\Seeders\Systeme\FaqSeeder;
use Database\Seeders\Systeme\HistoriqueMotDePasseSeeder;
use Database\Seeders\Systeme\IndicatifTelephoniqueSeeder;
use Database\Seeders\Systeme\LogSeeder;
use Database\Seeders\Systeme\OrganisationSeeder;
use Database\Seeders\Systeme\ParametreSeeder;
use Database\Seeders\Systeme\PaysSeeder;
use Database\Seeders\Systeme\PersonneSeeder;
use Database\Seeders\Systeme\PolitiqueSeeder;
use Database\Seeders\Systeme\PrivilegeSeeder;
use Database\Seeders\Systeme\RoleSeeder;
use Database\Seeders\Systeme\SessionSeeder;
use Database\Seeders\Systeme\TentativeConnexionSeeder;
use Database\Seeders\Systeme\UtilisateurBlocageSeeder;
use Database\Seeders\Systeme\UtilisateurSeeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {

        $this->call([
            PaysSeeder::class,
            IndicatifTelephoniqueSeeder::class,
            ApplicationSeeder::class,
            UtilisateurSeeder::class,
            RoleSeeder::class,
            PrivilegeSeeder::class,
            HistoriqueMotDePasseSeeder::class,
            TentativeConnexionSeeder::class,
            SessionSeeder::class,
            UtilisateurBlocageSeeder::class,
            LogSeeder::class,
            OrganisationSeeder::class,
            PersonneSeeder::class,
            BanniereSeeder::class,
            ChiffreSeeder::class,
            FaqSeeder::class,
            FaqMediaSeeder::class,
            CommentaireAnonymeSeeder::class,
            PolitiqueSeeder::class,
            ParametreSeeder::class,
            FactureSeeder::class,
            BienSeeder::class,
            RemiseSeeder::class,
            PaiementSeeder::class,
            RemboursementSeeder::class,
            DemandeSeeder::class,
            DemandeMediaSeeder::class,
            PropositionSeeder::class,
            PropositionMediaSeeder::class,
            AttestationSeeder::class,
            BlogCategorieSeeder::class,
            BlogArticleSeeder::class,
            BlogPageSeeder::class,
            BlogMediaSeeder::class,
            FormationSeeder::class,
            ParticipantSeeder::class,
            FormationPrerequisSeeder::class,
            FormationProgrammeSeeder::class,
            FormationPresentielleSeeder::class,
            FormationPartieSeeder::class,
            FormationPageSeeder::class,
            FormationMediaSeeder::class,
            FormationProgressionSeeder::class,
            EvaluationSeeder::class,
            FormationQuestionSeeder::class,
            FormationReponseSeeder::class,
            EvaluationMediaSeeder::class,
            CompositionSeeder::class,
            TirageSeeder::class,
            FormationCertificatSeeder::class,
            ForumSeeder::class,
            MembreSeeder::class,
            BanissementSeeder::class,
            PostSeeder::class,
            PostReactionSeeder::class,
            PostMediaSeeder::class,
            PostReponseSeeder::class,
            SignalementSeeder::class,
            AvertissementSeeder::class,
            MarketeurSeeder::class,
            MarketingPaiementSeeder::class,
            MarketingVenteSeeder::class,
            NewsletterCategorieSeeder::class,
            AbonneSeeder::class,
            NewsletterArticleSeeder::class,
            NewsletterPageSeeder::class,
            NewsletterMediaSeeder::class,
            DomaineEtudeSeeder::class,
            NiveauEtudeSeeder::class,
            NiveauSpecialisationSeeder::class,
            OffreEmploiSeeder::class,
            QuestionOffreSeeder::class,
            CandidatCertificatSeeder::class,
            CandidatCompetenceSeeder::class,
            CandidatDiplomeSeeder::class,
            CandidatExperienceSeeder::class,
            CandidatLangueSeeder::class,
            CandidatPortfolioSeeder::class,
            CandidatReferenceSeeder::class,
            CandidatCentreSeeder::class,
            //CandidatureSeeder::class,
            //CandidatureCentreSeeder::class,
            //CandidatureCertificatSeeder::class,
            //CandidatureCompetenceSeeder::class,
            //CandidatureConvocationSeeder::class,
            //CandidatureDiplomeSeeder::class,
            //CandidatureExperienceSeeder::class,
            //CandidatureLangueSeeder::class,
            //CandidaturePortfolioSeeder::class,
            //CandidatureReferenceSeeder::class,
            //CandidatureReponseSeeder::class,
            PrerequisCertificatSeeder::class,
            PrerequisDiplomeSeeder::class,
            PrerequisExperienceSeeder::class,
            PrerequisLangueSeeder::class,
        ]);
    }
}
