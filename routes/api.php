<?php

use App\Http\Controllers\Ano\AnoDomaineEtudeController;
use App\Http\Controllers\Ano\AnoIndicatifTelephoniqueController;
use App\Http\Controllers\Ano\AnoNiveauEtudeController;
use App\Http\Controllers\Ano\AnoNiveauSpecialisationController;
use App\Http\Controllers\Ano\AnoOffreEmploiController;
use App\Http\Controllers\Ano\AnoPaysController;
use App\Http\Controllers\Can\CanCandidatureCentreController;
use App\Http\Controllers\Can\CanCandidatureCertificatController;
use App\Http\Controllers\Can\CanCandidatureCompetenceController;
use App\Http\Controllers\Can\CanCandidatureController;
use App\Http\Controllers\Can\CanCandidatureCvController;
use App\Http\Controllers\Can\CanCandidatureDiplomeController;
use App\Http\Controllers\Can\CanCandidatureExperienceController;
use App\Http\Controllers\Can\CanCandidatureLangueController;
use App\Http\Controllers\Can\CanCandidaturePortfolioController;
use App\Http\Controllers\Can\CanCandidatureReferenceController;
use App\Http\Controllers\Can\CanCentreController;
use App\Http\Controllers\Can\CanCertificatController;
use App\Http\Controllers\Can\CanCompetenceController;
use App\Http\Controllers\Can\CanConvocationController;
use App\Http\Controllers\Can\CanCvController;
use App\Http\Controllers\Can\CanDiplomeController;
use App\Http\Controllers\Can\CanExperienceController;
use App\Http\Controllers\Can\CanLangueController;
use App\Http\Controllers\Can\CanPortfolioController;
use App\Http\Controllers\Can\CanReferenceController;
use App\Http\Controllers\Compte\COMCompteController;
use App\Http\Controllers\Roo\RooArchiveController;
use App\Http\Controllers\Roo\RooCandidatureController;
use App\Http\Controllers\Roo\RooConvocationController;
use App\Http\Controllers\Roo\RooOffreEmploiController;
use App\Http\Controllers\Roo\RooPrerequisCertificatController;
use App\Http\Controllers\Roo\RooPrerequisDiplomeController;
use App\Http\Controllers\Roo\RooPrerequisExperienceController;
use App\Http\Controllers\Roo\RooPrerequisLangueController;
use App\Http\Controllers\Roo\RooQuestionOffreController;
use App\Http\Middleware\Compte\AppAuthentificationMiddleware;
use App\Http\Middleware\Compte\AppCompteMiddleware;
use App\Http\Middleware\Compte\ComAuthentificationMiddleware;
use App\Http\Middleware\Compte\ComAutorisationMiddleware;
use Illuminate\Support\Facades\Route;

Route::middleware(AppAuthentificationMiddleware::class)->group(function () {

    /**
     * Routes pour les applications clientes.
     */
    Route::get('/cfai/app/compte/voir')->middleware(AppCompteMiddleware::class);

    /**
     * Routes pour les utilisateurs finaux non authentifés.
     */
    // Routes pour les comptes utilisateurs.
    Route::post('/cfai/auth/compte/creer', [COMCompteController::class, 'creer'])->name('cfai.auth.compte.creer');
    Route::post('/cfai/auth/compte/connecter', [COMCompteController::class, 'connecter'])->name('cfai.auth.compte.connecter');
    Route::post('/cfai/auth/compte/connecterDoubleAuthentification', [COMCompteController::class, 'connecterDoubleAuthentification'])->name('cfai.auth.compte.connecterDoubleAuthentification');
    Route::post('/cfai/auth/compte/demanderOtp', [COMCompteController::class, 'demanderOtp'])->name('cfai.auth.compte.demanderOtp');
    Route::post('/cfai/auth/compte/verifierEmail', [COMCompteController::class, 'verifierEmail'])->name('cfai.auth.compte.verifierEmail');
    Route::post('/cfai/auth/compte/verifierTelephone', [COMCompteController::class, 'verifierTelephone'])->name('cfai.auth.compte.verifierTelephone');
    Route::post('/cfai/auth/compte/mettreAJourMotDePasseOublie', [COMCompteController::class, 'mettreAJourMotDePasseOublie'])->name('cfai.auth.compte.mettreAJourMotDePasseOublie');
    Route::post('/cfai/auth/compte/debloquer', [COMCompteController::class, 'debloquer'])->name('cfai.auth.compte.debloquer');

    // Routes pour les pays.
    Route::get('/cfai/ano/pays/{id}', [AnoPaysController::class, 'voir'])->name('cfai.ano.pays.voir');
    Route::get('/cfai/ano/pays', [AnoPaysController::class, 'lister'])->name('cfai.ano.pays.lister');

    // Routes pour les indicatifs téléphoniques.
    Route::get('/cfai/ano/indicatifTelephonique/{id}', [AnoIndicatifTelephoniqueController::class, 'voir'])->name('cfai.ano.indicatifTelephonique.voir');
    Route::get('/cfai/ano/indicatifTelephonique', [AnoIndicatifTelephoniqueController::class, 'lister'])->name('cfai.ano.indicatifTelephonique.lister');

    // Routes pour les domaines d'études.
    Route::get('/cfai/ano/domaineEtude/{id}', [AnoDomaineEtudeController::class, 'voir'])->name('cfai.ano.domaineEtude.voir');
    Route::get('/cfai/ano/domaineEtude', [AnoDomaineEtudeController::class, 'lister'])->name('cfai.ano.domaineEtude.lister');

    // Routes pour les niveaux d'études.
    Route::get('/cfai/ano/niveauEtude/{id}', [AnoNiveauEtudeController::class, 'voir'])->name('cfai.ano.niveauEtude.voir');
    Route::get('/cfai/ano/niveauEtude', [AnoNiveauEtudeController::class, 'lister'])->name('cfai.ano.niveauEtude.lister');

    // Routes pour les niveaux de spécialisation.
    Route::get('/cfai/ano/niveauSpecialisation/{id}', [AnoNiveauSpecialisationController::class, 'voir'])->name('cfai.ano.niveauSpecialisation.voir');
    Route::get('/cfai/ano/niveauSpecialisation', [AnoNiveauSpecialisationController::class, 'lister'])->name('cfai.ano.niveauSpecialisation.lister');

    // Routes pour les niveaux de spécialisation.
    Route::get('/cfai/ano/offreEmploi/rechercher', [AnoOffreEmploiController::class, 'rechercher'])->name('cfai.ano.offreEmploi.rechercher');
    Route::get('/cfai/ano/offreEmploi/{id}', [AnoOffreEmploiController::class, 'voir'])->name('cfai.ano.offreEmploi.voir');
	Route::get('/cfai/ano/offreEmploi', [AnoOffreEmploiController::class, 'lister'])->name('cfai.ano.offreEmploi.lister');

    /**
     * Routes pour les utilisateurs finaux authentifiés.
     */
    Route::middleware(ComAuthentificationMiddleware::class)->group(function () {

        // Routes pour les comptes utilisateurs.
        Route::post('/cfai/auth/compte/ajouterPersonne', [COMCompteController::class, 'ajouterPersonne'])->name('cfai.auth.compte.ajouterPersonne');
        Route::post('/cfai/auth/compte/ajouterOrganisation', [COMCompteController::class, 'ajouterOrganisation'])->name('cfai.auth.compte.ajouterOrganisation');
        Route::get('/cfai/auth/compte/voir', [COMCompteController::class, 'voir'])->name('cfai.auth.compte.voir');
        Route::get('/cfai/auth/compte/telechargerPhotoProfil', [COMCompteController::class, 'telechargerPhotoProfil'])->name('cfai.auth.compte.telechargerPhotoProfil');
        Route::get('/cfai/auth/compte/voirSessions', [COMCompteController::class, 'voirSessions'])->name('cfai.auth.compte.voirSessions');
        Route::post('/cfai/auth/compte/mettreAJour', [COMCompteController::class, 'mettreAJour'])->name('cfai.auth.compte.mettreAJour');
        Route::post('/cfai/auth/compte/mettreAJourPhotoProfil', [COMCompteController::class, 'mettreAJourPhotoProfil'])->name('cfai.auth.compte.mettreAJourPhotoProfil');
        Route::post('/cfai/auth/compte/mettreAJourPersonne', [COMCompteController::class, 'mettreAJourPersonne'])->name('cfai.auth.compte.mettreAJourPersonne');
        Route::post('/cfai/auth/compte/mettreAJourOrganisation', [COMCompteController::class, 'mettreAJourOrganisation'])->name('cfai.auth.compte.mettreAJourOrganisation');
        Route::post('/cfai/auth/compte/mettreAJourAuthentification', [COMCompteController::class, 'mettreAJourAuthentification'])->name('cfai.auth.compte.mettreAJourAuthentification');
        Route::post('/cfai/auth/compte/mettreAJourMotDePasse', [COMCompteController::class, 'mettreAJourMotDePasse'])->name('cfai.auth.compte.mettreAJourMotDePasse');
        Route::delete('/cfai/auth/compte/deconnecter', [COMCompteController::class, 'deconnecter'])->name('cfai.auth.compte.deconnecter');
        Route::post('/cfai/auth/compte/deconnecterSession', [COMCompteController::class, 'deconnecterSession'])->name('cfai.auth.compte.deconnecterSession');
        Route::post('/cfai/auth/compte/deconnecterSessions', [COMCompteController::class, 'deconnecterSessions'])->name('cfai.auth.compte.deconnecterSessions');
        Route::post('/cfai/auth/compte/supprimer', [COMCompteController::class, 'supprimer'])->name('cfai.auth.compte.supprimer');

        Route::middleware(ComAutorisationMiddleware::class)->group(function () {

            /**
             * Routes pour le responsable des offres d'emploi.
             */
            // Offres d'emplois
            Route::post('/cfai/roo/offreEmploi', [RooOffreEmploiController::class, 'creer'])->name('cfai.roo.offreEmploi.creer');
            Route::get('/cfai/roo/offreEmploi/rechercher', [RooOffreEmploiController::class, 'rechercher'])->name('cfai.roo.offreEmploi.rechercher');
            Route::get('/cfai/roo/offreEmploi/telecharger/{id}', [RooOffreEmploiController::class, 'telecharger'])->name('cfai.roo.offreEmploi.telecharger');
            Route::get('/cfai/roo/offreEmploi/{id}', [RooOffreEmploiController::class, 'voir'])->name('cfai.roo.offreEmploi.voir');
            Route::get('/cfai/roo/offreEmploi', [RooOffreEmploiController::class, 'lister'])->name('cfai.roo.offreEmploi.lister');
            Route::patch('/cfai/roo/offreEmploi/{id}', [RooOffreEmploiController::class, 'mettreAJour'])->name('cfai.roo.offreEmploi.mettreAJour');
            Route::delete('/cfai/roo/offreEmploi/{id}', [RooOffreEmploiController::class, 'supprimer'])->name('cfai.roo.offreEmploi.supprimer');

            // Préréquis diplomes.
            Route::post('/cfai/roo/prerequisDiplome', [RooPrerequisDiplomeController::class, 'creer'])->name('cfai.roo.prerequisDiplome.creer');
            Route::get('/cfai/roo/prerequisDiplome/{id}', [RooPrerequisDiplomeController::class, 'voir'])->name('cfai.roo.prerequisDiplome.voir');
            Route::patch('/cfai/roo/prerequisDiplome/{id}', [RooPrerequisDiplomeController::class, 'mettreAJourFichier'])->name('cfai.roo.prerequisDiplome.mettreAJour');
            Route::delete('/cfai/roo/prerequisDiplome/{id}', [RooPrerequisDiplomeController::class, 'supprimer'])->name('cfai.roo.prerequisDiplome.supprimer');

            // Préréquis certificats.
            Route::post('/cfai/roo/prerequisCertificat', [RooPrerequisCertificatController::class, 'creer'])->name('cfai.roo.prerequisCertificat.creer');
            Route::get('/cfai/roo/prerequisCertificat/{id}', [RooPrerequisCertificatController::class, 'voir'])->name('cfai.roo.prerequisCertificat.voir');
            Route::patch('/cfai/roo/prerequisCertificat/{id}', [RooPrerequisCertificatController::class, 'mettreAJour'])->name('cfai.roo.prerequisCertificat.mettreAJour');
            Route::delete('/cfai/roo/prerequisCertificat/{id}', [RooPrerequisCertificatController::class, 'supprimer'])->name('cfai.roo.prerequisCertificat.supprimer');

            // Préréquis expériences.
            Route::post('/cfai/roo/prerequisExperience', [RooPrerequisExperienceController::class, 'creer'])->name('cfai.roo.prerequisExperience.creer');
            Route::get('/cfai/roo/prerequisExperience/{id}', [RooPrerequisExperienceController::class, 'voir'])->name('cfai.roo.prerequisExperience.voir');
            Route::patch('/cfai/roo/prerequisExperience/{id}', [RooPrerequisExperienceController::class, 'mettreAJour'])->name('cfai.roo.prerequisExperience.mettreAJour');
            Route::delete('/cfai/roo/prerequisExperience/{id}', [RooPrerequisExperienceController::class, 'supprimer'])->name('cfai.roo.prerequisExperience.supprimer');

            // Préréquis langues.
            Route::post('/cfai/roo/prerequisLangue', [RooPrerequisLangueController::class, 'creer'])->name('cfai.roo.prerequisLangue.creer');
            Route::get('/cfai/roo/prerequisLangue/{id}', [RooPrerequisLangueController::class, 'voir'])->name('cfai.roo.prerequisLangue.voir');
            Route::patch('/cfai/roo/prerequisLangue/{id}', [RooPrerequisLangueController::class, 'mettreAJour'])->name('cfai.roo.prerequisLangue.mettreAJour');
            Route::delete('/cfai/roo/prerequisLangue/{id}', [RooPrerequisLangueController::class, 'supprimer'])->name('cfai.roo.prerequisLangue.supprimer');

            // Questionnaire offre emploi.
            Route::post('/cfai/roo/question', [RooQuestionOffreController::class, 'creer'])->name('cfai.roo.question.creer');
            Route::get('/cfai/roo/question/{id}', [RooQuestionOffreController::class, 'voir'])->name('cfai.roo.question.voir');
            Route::patch('/cfai/roo/question/{id}', [RooQuestionOffreController::class, 'mettreAJour'])->name('cfai.roo.question.mettreAJour');
            Route::delete('/cfai/roo/question/{id}', [RooQuestionOffreController::class, 'supprimer'])->name('cfai.roo.question.supprimer');

            // Candidatures.
            Route::get('/cfai/roo/candidature/rechercher', [RooCandidatureController::class, 'rechercher'])->name('cfai.roo.candidature.rechercher');
            Route::get('/cfai/roo/candidature/lister/{id}', [RooCandidatureController::class, 'lister'])->name('cfai.roo.candidature.lister');
            Route::get('/cfai/roo/candidature/{id}', [RooCandidatureController::class, 'voir'])->name('cfai.roo.candidature.voir');
            Route::patch('/cfai/roo/candidature/{id}', [RooCandidatureController::class, 'mettreAJour'])->name('cfai.roo.candidature.mettreAJour');

            // Convocations.
            Route::post('/cfai/roo/convocation', [RooConvocationController::class, 'creer'])->name('cfai.roo.convocation.creer');
            Route::get('/cfai/roo/convocation/{id}', [RooConvocationController::class, 'voir'])->name('cfai.roo.convocation.voir');
            Route::get('/cfai/roo/convocation/lister/{idOffre}', [RooConvocationController::class, 'lister'])->name('cfai.roo.convocation.lister');
            Route::patch('/cfai/roo/convocation/{id}', [RooConvocationController::class, 'mettreAJour'])->name('cfai.roo.convocation.mettreAJour');
            Route::delete('/cfai/roo/convocation/{id}', [RooConvocationController::class, 'supprimer'])->name('cfai.roo.convocation.supprimer');

            // Archives.
            Route::get('/cfai/roo/archive/telecharger/{id}', [RooArchiveController::class, 'telecharger'])->name('cfai.roo.archive.telecharger');
            Route::get('/cfai/roo/archive/verifier/{id}', [RooArchiveController::class, 'voir'])->name('cfai.roo.archive.voir');
            Route::get('/cfai/roo/archive/creer/{id}', [RooArchiveController::class, 'creer'])->name('cfai.roo.archive.creer');
            Route::get('/cfai/roo/archive', [RooArchiveController::class, 'lister'])->name('cfai.roo.archive.lister');

            /**
             * Candidat
             */
            // Diplômes.
            Route::post('/cfai/can/diplome', [CanDiplomeController::class, 'creer'])->name('cfai.can.diplome.creer');
			Route::post('/cfai/can/diplome/{id}', [CanDiplomeController::class, 'mettreAJourFichier'])->name('cfai.can.diplome.mettreAJourFichier');
            Route::patch('/cfai/can/diplome/{id}', [CanDiplomeController::class, 'mettreAjour'])->name('cfai.can.diplome.mettreAjour');
            Route::get('/cfai/can/diplome/{id}', [CanDiplomeController::class, 'voir'])->name('cfai.can.diplome.voir');
            Route::get('/cfai/can/diplome', [CanDiplomeController::class, 'lister'])->name('cfai.can.diplome.lister');
            Route::delete('/cfai/can/diplome/{id}', [CanDiplomeController::class, 'supprimer'])->name('cfai.can.diplome.supprimer');

            // Certificats.
            Route::post('/cfai/can/certificat', [CanCertificatController::class, 'creer'])->name('cfai.can.certificat.creer');
            Route::post('/cfai/can/certificat/{id}', [CanCertificatController::class, 'mettreAJourFichier'])->name('cfai.can.certificat.mettreAJourFichier');
            Route::get('/cfai/can/certificat/{id}', [CanCertificatController::class, 'voir'])->name('cfai.can.certificat.voir');
            Route::get('/cfai/can/certificat', [CanCertificatController::class, 'lister'])->name('cfai.can.certificat.lister');
            Route::patch('/cfai/can/certificat/{id}', [CanCertificatController::class, 'mettreAJour'])->name('cfai.can.certificat.mettreAJour');
            Route::delete('/cfai/can/certificat/{id}', [CanCertificatController::class, 'supprimer'])->name('cfai.can.certificat.supprimer');

            // Experiences.
            Route::post('/cfai/can/experience', [CanExperienceController::class, 'creer'])->name('cfai.can.experience.creer');
            Route::get('/cfai/can/experience', [CanExperienceController::class, 'lister'])->name('cfai.can.experience.lister');
            Route::delete('/cfai/can/experience/{id}', [CanExperienceController::class, 'supprimer'])->name('cfai.can.experience.supprimer');

            // Reférences.
            Route::post('/cfai/can/reference', [CanReferenceController::class, 'creer'])->name('cfai.can.reference.creer');
            Route::get('/cfai/can/reference', [CanReferenceController::class, 'lister'])->name('cfai.can.reference.lister');
            Route::delete('/cfai/can/reference/{id}', [CanReferenceController::class, 'supprimer'])->name('cfai.can.reference.supprimer');

            // Portfolio.
            Route::post('/cfai/can/portfolio', [CanPortfolioController::class, 'creer'])->name('cfai.can.portfolio.creer');
            Route::get('/cfai/can/portfolio', [CanPortfolioController::class, 'lister'])->name('cfai.can.portfolio.lister');
            Route::delete('/cfai/can/portfolio/{id}', [CanPortfolioController::class, 'supprimer'])->name('cfai.can.portfolio.supprimer');

            // Compétences.
            Route::post('/cfai/can/competence', [CanCompetenceController::class, 'creer'])->name('cfai.can.competence.creer');
            Route::get('/cfai/can/competence', [CanCompetenceController::class, 'lister'])->name('cfai.can.competence.lister');
            Route::delete('/cfai/can/competence/{id}', [CanCompetenceController::class, 'supprimer'])->name('cfai.can.competence.supprimer');

            // Langues.
            Route::post('/cfai/can/langue', [CanLangueController::class, 'creer'])->name('cfai.can.langue.creer');
            Route::get('/cfai/can/langue', [CanLangueController::class, 'lister'])->name('cfai.can.langue.lister');
            Route::delete('/cfai/can/langue/{id}', [CanLangueController::class, 'supprimer'])->name('cfai.can.langue.supprimer');

            // Centres d'intérêts.
            Route::post('/cfai/can/centre', [CanCentreController::class, 'creer'])->name('cfai.can.centre.creer');
            Route::get('/cfai/can/centre', [CanCentreController::class, 'lister'])->name('cfai.can.centre.lister');
            Route::delete('/cfai/can/centre/{id}', [CanCentreController::class, 'supprimer'])->name('cfai.can.centre.supprimer');

            // Cvs.
            Route::post('/cfai/can/cv', [CanCvController::class, 'uploader'])->name('cfai.can.cv.uploader');
            Route::get('/cfai/can/cv', [CanCvController::class, 'lister'])->name('cfai.can.cv.lister');
            Route::get('/cfai/can/cv/{id}', [CanCvController::class, 'downloader'])->name('cfai.can.cv.downloader');
            Route::delete('/cfai/can/cv/{id}', [CanCvController::class, 'supprimer'])->name('cfai.can.cv.supprimer');

            // Convocations.
            Route::get('/cfai/can/convocation/telecharger/{id}', [CanConvocationController::class, 'telecharger'])->name('cfai.can.convocation.telecharger');
            Route::get('/cfai/can/convocation/{id}', [CanConvocationController::class, 'voir'])->name('cfai.can.convocation.voir');
            Route::get('/cfai/can/convocation', [CanConvocationController::class, 'lister'])->name('cfai.can.convocation.lister');

            // Candidatures.
            Route::post('/cfai/can/candidature', [CanCandidatureController::class, 'creer'])->name('cfai.can.candidature.creer');
            Route::get('/cfai/can/candidature/{id}', [CanCandidatureController::class, 'voir'])->name('cfai.can.candidature.voir');
            Route::get('/cfai/can/candidature', [CanCandidatureController::class, 'lister'])->name('cfai.can.candidature.lister');
            Route::patch('/cfai/can/candidature/{id}', [CanCandidatureController::class, 'mettreAJour'])->name('cfai.can.candidature.mettreAJour');
            Route::delete('/cfai/can/candidature/{id}', [CanCandidatureController::class, 'supprimer'])->name('cfai.can.candidature.supprimer');

            Route::get('/cfai/can/lier/diplome', [CanCandidatureDiplomeController::class, 'lier'])->name('cfai.can.candidature.diplome.lier');
            Route::delete('/cfai/can/lier/diplome/{id}', [CanCandidatureDiplomeController::class, 'delier'])->name('cfai.can.candidature.diplome.delier');

            Route::get('/cfai/can/lier/certificat', [CanCandidatureCertificatController::class, 'lier'])->name('cfai.can.candidature.certificat.lier');
            Route::delete('/cfai/can/lier/certificat/{id}', [CanCandidatureCertificatController::class, 'delier'])->name('cfai.can.candidature.certificat.delier');

            Route::get('/cfai/can/lier/experience', [CanCandidatureExperienceController::class, 'lier'])->name('cfai.can.candidature.experience.lier');
            Route::delete('/cfai/can/lier/experience/{id}', [CanCandidatureExperienceController::class, 'delier'])->name('cfai.can.candidature.experience.delier');

            Route::get('/cfai/can/lier/reference', [CanCandidatureReferenceController::class, 'lier'])->name('cfai.can.candidature.reference.lier');
            Route::delete('/cfai/can/lier/reference/{id}', [CanCandidatureReferenceController::class, 'delier'])->name('cfai.can.candidature.reference.delier');

            Route::get('/cfai/can/lier/portfolio', [CanCandidaturePortfolioController::class, 'lier'])->name('cfai.can.candidature.portfolio.lier');
            Route::delete('/cfai/can/lier/portfolio/{id}', [CanCandidaturePortfolioController::class, 'delier'])->name('cfai.can.candidature.portfolio.delier');

            Route::get('/cfai/can/lier/competence', [CanCandidatureCompetenceController::class, 'lier'])->name('cfai.can.candidature.competence.lier');
            Route::delete('/cfai/can/lier/competence/{id}', [CanCandidatureCompetenceController::class, 'delier'])->name('cfai.can.candidature.competence.delier');

            Route::get('/cfai/can/lier/langue', [CanCandidatureLangueController::class, 'lier'])->name('cfai.can.candidature.langue.lier');
            Route::delete('/cfai/can/lier/langue/{id}', [CanCandidatureLangueController::class, 'delier'])->name('cfai.can.candidature.langue.delier');

            Route::get('/cfai/can/lier/centre', [CanCandidatureCentreController::class, 'lier'])->name('cfai.can.candidature.centre.lier');
            Route::delete('/cfai/can/lier/centre/{id}', [CanCandidatureCentreController::class, 'delier'])->name('cfai.can.candidature.centre.delier');

            Route::post('/cfai/can/lier/cv', [CanCandidatureCvController::class, 'lier'])->name('cfai.can.candidature.cv.lier');
            Route::delete('/cfai/can/lier/cv/{id}', [CanCandidatureCvController::class, 'delier'])->name('cfai.can.candidature.cv.delier');
        });
    });
});
