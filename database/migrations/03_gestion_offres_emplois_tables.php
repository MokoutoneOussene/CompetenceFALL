<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Execute les migrations.
     */
    public function up(): void
    {

        // Table des domaines d'études : Mathématiques, Siences de gestion...
        Schema::create('emploi_domaine_etudes', function (Blueprint $table) {

            $table->uuid('id')->primary();
            $table->string('intitule')->unique()->nullable(false);
            $table->text('description')->nullable(true);
        });

        // Table des niveaux d'études : Primaire, Secondaire, Supérieur.
        Schema::create('emploi_niveau_etudes', function (Blueprint $table) {

            $table->uuid('id')->primary();
            $table->string('intitule')->unique()->nullable(false);
            $table->unsignedSmallInteger('niveau')->nullable(false)->default(1);
            $table->text('description')->nullable(true);
        });

        // Table des niveaux de spécialisation : BTS, DUT, Licence, Master...
        Schema::create('emploi_niveau_specialisations', function (Blueprint $table) {

            $table->uuid('id')->primary();
            $table->string('intitule')->unique()->nullable(false);
            $table->string('abreviation')->unique()->nullable(true);
            $table->unsignedSmallInteger('niveau')->nullable(false)->default(1);
            $table->text('description')->nullable(true);
        });

        // Table des offres d'emploi.
        Schema::create('emploi_offre_emplois', function (Blueprint $table) {

            $table->uuid('id')->primary();
            $table->string('poste')->nullable(false);
            $table->string('contrat')->nullable(true);
            $table->string('nomOrganisation')->nullable(true);
            $table->text('infosOrganisation')->nullable(true);
            $table->string('domaine')->nullable(true);
            $table->text('description')->nullable(true);
            $table->text('prerequis')->nullable(true);
            $table->dateTime('dateLimite')->nullable(true);
            $table->string('lieu')->nullable(true);
            $table->uuid('pays')->nullable(true);
            $table->enum('typeLieu', ['surSite', 'teleTravail', 'hybride'])->nullable(true);
            $table->unsignedInteger('remuneration')->nullable(true);
            $table->text('avantages')->nullable(true);
            $table->unsignedSmallInteger('places')->nullable(false);
            $table->dateTime('dateDebutPoste')->nullable(true);
            $table->text('consignes')->nullable(true);
            $table->text('infosComplementaires')->nullable(true);
            $table->unsignedSmallInteger('pourcentageMoyenne')->nullable(false)->default(50); // Pourcentage de la note moyenne minimale
            $table->boolean('statutPublication')->nullable(false)->default(false);
            $table->dateTime('dateDebutPublication')->nullable(false)->default(Carbon::now()->format('Y-m-d H:i:s'));
            $table->dateTime('dateFinPublication')->nullable(false)->default(Carbon::now()->addWeeks(2)->format('Y-m-d H:i:s'));
            $table->uuid('auteurCreation')->nullable(true);
            $table->uuid('auteurMiseAJour')->nullable(true);
            $table->timestamps();

            $table->foreign('pays')->references('id')->on('systeme_pays')->nullOnDelete();
            $table->foreign('auteurCreation')->references('id')->on('systeme_utilisateurs')->nullOnDelete();
            $table->foreign('auteurMiseAJour')->references('id')->on('systeme_utilisateurs')->nullOnDelete();
        });

        // Table des questions des offres d'emplois.
        Schema::create('emploi_question_offres', function (Blueprint $table) {

            $table->uuid('id')->primary();
            $table->uuid('offre')->nullable(false);
            $table->unsignedSmallInteger('ordre')->nullable(false)->default(0);
            $table->text('contenu')->nullable(false);
            $table->enum('typeQuestion', ['vraiFaux', 'reponseCourte'])->nullable(false)->default('vraiFaux');
            $table->unsignedSmallInteger('note')->nullable(true);
            $table->boolean('bonneReponse')->nullable(true);

            $table->foreign('offre')->references('id')->on('emploi_offre_emplois')->cascadeOnDelete();
        });

        // Table des préréquis diplomes.
        Schema::create('emploi_prerequis_diplomes', function (Blueprint $table) {

            $table->uuid('id')->primary();
            $table->uuid('offre')->nullable(false);
            $table->uuid('domaineEtude')->nullable(true);
            $table->unsignedSmallInteger('noteDomaine')->nullable(true);
            $table->uuid('niveauEtude')->nullable(true);
            $table->uuid('niveauSpecialisation')->nullable(true);

            $table->foreign('offre')->references('id')->on('emploi_offre_emplois')->cascadeOnDelete();
            $table->foreign('domaineEtude')->references('id')->on('emploi_domaine_etudes')->nullOnDelete();
            $table->foreign('niveauEtude')->references('id')->on('emploi_niveau_etudes')->nullOnDelete();
            $table->foreign('niveauSpecialisation')->references('id')->on('emploi_niveau_specialisations')->nullOnDelete();
        });

        // Table des préréquis certificats.
        Schema::create('emploi_prerequis_certificats', function (Blueprint $table) {

            $table->uuid('id')->primary();
            $table->uuid('offre')->nullable(false);
            $table->uuid('domaineEtude')->nullable(false);
            $table->unsignedSmallInteger('noteDomaine')->nullable(false);

            $table->foreign('offre')->references('id')->on('emploi_offre_emplois')->cascadeOnDelete();
            $table->foreign('domaineEtude')->references('id')->on('emploi_domaine_etudes')->cascadeOnDelete();
        });

        // Table des préréquis expériences professionnelles.
        Schema::create('emploi_prerequis_experiences', function (Blueprint $table) {

            $table->uuid('id')->primary();
            $table->uuid('offre')->nullable(false);
            $table->uuid('domaineEtude')->nullable(false);
            $table->unsignedSmallInteger('noteDomaine')->nullable(false);
            $table->unsignedSmallInteger('duree')->nullable(true);

            $table->foreign('offre')->references('id')->on('emploi_offre_emplois')->cascadeOnDelete();
            $table->foreign('domaineEtude')->references('id')->on('emploi_domaine_etudes')->cascadeOnDelete();
        });

        // Table des préréquis langues.
        Schema::create('emploi_prerequis_langues', function (Blueprint $table) {

            $table->uuid('id')->primary();
            $table->uuid('offre')->nullable(false);
            $table->string('intitule')->nullable(false);
            $table->unsignedSmallInteger('noteLangue')->nullable(false);
            $table->enum('niveau', ['a1', 'b1', 'c1', 'a2', 'b2', 'c2'])->nullable(true);
            $table->unsignedSmallInteger('noteNiveau')->nullable(true);
            $table->boolean('statutParle')->default(true);
            $table->unsignedSmallInteger('noteStatutParle')->nullable(true);
            $table->boolean('statutLu')->default(true);
            $table->unsignedSmallInteger('noteStatutLu')->nullable(true);
            $table->boolean('statutEcrit')->default(true);
            $table->unsignedSmallInteger('noteStatutEcrit')->nullable(true);

            $table->foreign('offre')->references('id')->on('emploi_offre_emplois')->cascadeOnDelete();
        });

        // Table des diplomes des candidats.
        Schema::create('emploi_candidat_diplomes', function (Blueprint $table) {

            $table->uuid('id')->primary();
            $table->uuid('utilisateur')->nullable(false);
            $table->boolean('statutObtention')->nullable(true);
            $table->string('identifiant')->nullable(true);
            $table->string('intitule')->nullable(false);
            $table->uuid('domaineEtude')->nullable(true);
            $table->uuid('niveauEtude')->nullable(true);
            $table->uuid('niveauSpecialisation')->nullable(true);
            $table->string('organisation')->nullable(true);
            $table->dateTime('dateDebut')->nullable(false);
            $table->dateTime('dateFin')->nullable(false);
            $table->dateTime('dateDelivrance')->nullable(false);
            $table->string('slug')->nullable(true);

            $table->foreign('utilisateur')->references('id')->on('systeme_utilisateurs')->cascadeOnDelete();
            $table->foreign('domaineEtude')->references('id')->on('emploi_domaine_etudes')->nullOnDelete();
            $table->foreign('niveauEtude')->references('id')->on('emploi_niveau_etudes')->nullOnDelete();
            $table->foreign('niveauSpecialisation')->references('id')->on('emploi_niveau_specialisations')->nullOnDelete();
        });

        // Table des certificats des candidats.
        Schema::create('emploi_candidat_certificats', function (Blueprint $table) {

            $table->uuid('id')->primary();
            $table->uuid('utilisateur')->nullable(false);
            $table->string('identifiant')->nullable(true);
            $table->string('intitule')->nullable(false);
            $table->uuid('domaineEtude')->nullable(true);
            $table->string('organisation')->nullable(false);
            $table->dateTime('dateDebut')->nullable(false);
            $table->dateTime('dateFin')->nullable(false);
            $table->dateTime('dateDelivrance')->nullable(true);
            $table->string('slug')->nullable(true);

            $table->foreign('utilisateur')->references('id')->on('systeme_utilisateurs')->cascadeOnDelete();
            $table->foreign('domaineEtude')->references('id')->on('emploi_domaine_etudes')->nullOnDelete();
        });

        // Table des expériences professionnelles des candidats.
        Schema::create('emploi_candidat_experiences', function (Blueprint $table) {

            $table->uuid('id')->primary();
            $table->uuid('utilisateur')->nullable(false);
            $table->string('poste')->nullable(false);
            $table->uuid('domaineEtude')->nullable(true);
            $table->unsignedSmallInteger('duree')->nullable(false);
            $table->dateTime('dateDebut')->nullable(false);
            $table->dateTime('dateFin')->nullable(true);
            $table->text('taches')->nullable(false);
            $table->string('contrat')->nullable(true);
            $table->string('organisation')->nullable(false);
            $table->string('lieu')->nullable(false);
            $table->uuid('pays')->nullable(true);
            $table->enum('typeLieu', ['surSite', 'teleTravail', 'hybride'])->nullable(false);
            $table->string('nomSuperieur')->nullable(true);
            $table->string('prenomsSuperieur')->nullable(true);
            $table->string('posteSuperieur')->nullable(true);
            $table->string('indicatifTelephoniqueSuperieur')->nullable(true);
            $table->string('telephoneSuperieur')->nullable(true);

            $table->foreign('utilisateur')->references('id')->on('systeme_utilisateurs')->cascadeOnDelete();
            $table->foreign('domaineEtude')->references('id')->on('emploi_domaine_etudes')->nullOnDelete();
            $table->foreign('pays')->references('id')->on('systeme_pays')->nullOnDelete();
        });

        // Table des langues des candidats.
        Schema::create('emploi_candidat_langues', function (Blueprint $table) {

            $table->uuid('id')->primary();
            $table->uuid('utilisateur')->nullable(false);
            $table->string('intitule')->nullable(false);
            $table->enum('niveau', ['a1', 'b1', 'c1', 'a2', 'b2', 'c2'])->nullable(true);
            $table->boolean('statutParle')->default(true);
            $table->boolean('statutLu')->default(true);
            $table->boolean('statutEcrit')->default(true);

            $table->foreign('utilisateur')->references('id')->on('systeme_utilisateurs')->cascadeOnDelete();
        });

        // Table des personnes de références des candidats.
        Schema::create('emploi_candidat_references', function (Blueprint $table) {

            $table->uuid('id')->primary();
            $table->uuid('utilisateur')->nullable(false);
            $table->string('nom')->nullable(false);
            $table->string('prenoms')->nullable(false);
            $table->string('poste')->nullable(false);
            $table->string('organisation')->nullable(false);
            $table->string('email')->nullable(true);
            $table->string('indicatifTelephonique')->nullable(true);
            $table->string('telephone')->nullable(true);
            $table->string('relation')->default('superieur');
            $table->dateTime('dateDebut')->nullable(false);
            $table->dateTime('dateFin')->nullable(true);

            $table->foreign('utilisateur')->references('id')->on('systeme_utilisateurs')->cascadeOnDelete();
        });

        // Table des portfolios des candidats.
        Schema::create('emploi_candidat_portfolios', function (Blueprint $table) {

            $table->uuid('id')->primary();
            $table->uuid('utilisateur')->nullable(false);
            $table->string('intitule')->nullable(false);
            $table->text('description')->nullable(true);
            $table->dateTime('date')->nullable(true);
            $table->string('lien')->nullable(true);

            $table->foreign('utilisateur')->references('id')->on('systeme_utilisateurs')->cascadeOnDelete();
        });

        // Talble des centres d'intérêts des candidats.
        Schema::create('emploi_candidat_centres', function (Blueprint $table) {

            $table->uuid('id')->primary();
            $table->uuid('utilisateur')->nullable(false);
            $table->string('intitule')->nullable(false);
            $table->text('description')->nullable(true);

            $table->foreign('utilisateur')->references('id')->on('systeme_utilisateurs')->cascadeOnDelete();
        });

        // Table des compétences des candidats.
        Schema::create('emploi_candidat_competences', function (Blueprint $table) {

            $table->uuid('id')->primary();
            $table->uuid('utilisateur')->nullable(false);
            $table->string('intitule')->nullable(false);
            $table->text('description')->nullable(true);

            $table->foreign('utilisateur')->references('id')->on('systeme_utilisateurs')->cascadeOnDelete();
        });

        // Table des cvs des candidats.
        Schema::create('emploi_candidat_cvs', function (Blueprint $table) {

            $table->uuid('id')->primary();
            $table->uuid('utilisateur')->nullable(false);
            $table->string('intitule')->nullable(true);
            $table->string('slug')->nullable(false);

            $table->foreign('utilisateur')->references('id')->on('systeme_utilisateurs')->cascadeOnDelete();
        });

        // Table des candidatures.
        Schema::create('emploi_candidatures', function (Blueprint $table) {

            $table->uuid('id')->primary();
            $table->uuid('utilisateur')->nullable(false);
            $table->uuid('offre')->nullable(false);
            $table->uuid('examinateur')->nullable(true);
            $table->string('intitule')->nullable(true);
            $table->uuid('cv')->nullable(true);
            $table->text('lettreMotivation')->nullable(true);
            $table->boolean('statutSoumission')->default(false);
            $table->boolean('statutExamination')->nullable(true);
            $table->unsignedSmallInteger('noteDiplomes')->nullable(true)->default(0);
            $table->unsignedSmallInteger('noteCertificats')->nullable(true)->default(0);
            $table->unsignedSmallInteger('noteExperiences')->nullable(true)->default(0);
            $table->unsignedSmallInteger('noteLangues')->nullable(true)->default(0);
            $table->unsignedSmallInteger('noteReponses')->nullable(true)->default(0);
            $table->unsignedSmallInteger('noteGlobale')->nullable(true)->default(0);
            $table->text('observations')->nullable(true);
            $table->uuid('auteurMiseAJour')->nullable(true);
            $table->timestamps();

            $table->foreign('utilisateur')->references('id')->on('systeme_utilisateurs')->cascadeOnDelete();
            $table->foreign('offre')->references('id')->on('emploi_offre_emplois')->cascadeOnDelete();
            $table->foreign('examinateur')->references('id')->on('systeme_utilisateurs')->nullOnDelete();
            $table->foreign('cv')->references('id')->on('emploi_candidat_cvs')->nullOnDelete();
            $table->foreign('auteurMiseAJour')->references('id')->on('systeme_utilisateurs')->nullOnDelete();
        });

        // Table pivot entre candidatures et competences des candidats.
        Schema::create('emploi_candidature_competences', function (Blueprint $table) {

            $table->uuid('id')->primary();
            $table->uuid('candidature')->nullable(false);
            $table->uuid('competence')->nullable(false);

            $table->foreign('candidature')->references('id')->on('emploi_candidatures')->cascadeOnDelete();
            $table->foreign('competence')->references('id')->on('emploi_candidat_competences')->cascadeOnDelete();
            $table->unique(['candidature', 'competence']);
        });

		// Table pivot entre candidatures et cvs des candidats.
        Schema::create('emploi_candidature_cvs', function (Blueprint $table) {

            $table->uuid('id')->primary();
            $table->uuid('candidature')->nullable(false);
            $table->uuid('cv')->nullable(false);

            $table->foreign('candidature')->references('id')->on('emploi_candidatures')->cascadeOnDelete();
            $table->foreign('cv')->references('id')->on('emploi_candidat_cvs')->cascadeOnDelete();
        });

        // Table pivot entre candidatures et centres d'interets des candidats.
        Schema::create('emploi_candidature_centres', function (Blueprint $table) {

            $table->uuid('id')->primary();
            $table->uuid('candidature')->nullable(false);
            $table->uuid('centre')->nullable(false);

            $table->foreign('candidature')->references('id')->on('emploi_candidatures')->cascadeOnDelete();
            $table->foreign('centre')->references('id')->on('emploi_candidat_centres')->cascadeOnDelete();
            $table->unique(['candidature', 'centre']);
        });

        // Talbe pivot entre candidatures et portfolios des candidats.
        Schema::create('emploi_candidature_portfolios', function (Blueprint $table) {

            $table->uuid('id')->primary();
            $table->uuid('candidature')->nullable(false);
            $table->uuid('portfolio')->nullable(false);

            $table->foreign('candidature')->references('id')->on('emploi_candidatures')->cascadeOnDelete();
            $table->foreign('portfolio')->references('id')->on('emploi_candidat_portfolios')->cascadeOnDelete();
            $table->unique(['candidature', 'portfolio']);
        });

        // Talbe pivot entre candidatures et personnes de référence des candidats.
        Schema::create('emploi_candidature_references', function (Blueprint $table) {

            $table->uuid('id')->primary();
            $table->uuid('candidature')->nullable(false);
            $table->uuid('reference')->nullable(false);

            $table->foreign('candidature')->references('id')->on('emploi_candidatures')->cascadeOnDelete();
            $table->foreign('reference')->references('id')->on('emploi_candidat_references')->cascadeOnDelete();
            $table->unique(['candidature', 'reference']);
        });

        // Talbe pivot entre candidatures et langues des candidats.
        Schema::create('emploi_candidature_langues', function (Blueprint $table) {

            $table->uuid('id')->primary();
            $table->uuid('candidature')->nullable(false);
            $table->uuid('langue')->nullable(false);

            $table->foreign('candidature')->references('id')->on('emploi_candidatures')->cascadeOnDelete();
            $table->foreign('langue')->references('id')->on('emploi_candidat_langues')->cascadeOnDelete();
            $table->unique(['candidature', 'langue']);
        });

        // Talbe pivot entre candidatures et expériences des candidats.
        Schema::create('emploi_candidature_experiences', function (Blueprint $table) {

            $table->uuid('id')->primary();
            $table->uuid('candidature')->nullable(false);
            $table->uuid('experience')->nullable(false);

            $table->foreign('candidature')->references('id')->on('emploi_candidatures')->cascadeOnDelete();
            $table->foreign('experience')->references('id')->on('emploi_candidat_experiences')->cascadeOnDelete();
            $table->unique(['candidature', 'experience']);
        });

        // Talbe pivot entre candidatures et certificats des candidats.
        Schema::create('emploi_candidature_certificats', function (Blueprint $table) {

            $table->uuid('id')->primary();
            $table->uuid('candidature')->nullable(false);
            $table->uuid('certificat')->nullable(false);

            $table->foreign('candidature')->references('id')->on('emploi_candidatures')->cascadeOnDelete();
            $table->foreign('certificat')->references('id')->on('emploi_candidat_certificats')->cascadeOnDelete();
            $table->unique(['candidature', 'certificat']);
        });

        // Talbe pivot entre candidatures diplomes des candidats.
        Schema::create('emploi_candidature_diplomes', function (Blueprint $table) {

            $table->uuid('id')->primary();
            $table->uuid('candidature');
            $table->uuid('diplome');

            $table->foreign('candidature')->references('id')->on('emploi_candidatures')->cascadeOnDelete();
            $table->foreign('diplome')->references('id')->on('emploi_candidat_diplomes')->cascadeOnDelete();
            $table->unique(['candidature', 'diplome']);
        });

        // Table des reponses des candidats aux questions posées pour l'offre d'emploi.
        Schema::create('emploi_candidature_reponses', function (Blueprint $table) {

            $table->uuid('id')->primary();
            $table->uuid('candidature')->nullable(false);
            $table->uuid('question')->nullable(false);
            $table->boolean('reponse')->nullable(false);
            $table->text('contenu')->nullable(true);

            $table->foreign('candidature')->references('id')->on('emploi_candidatures')->cascadeOnDelete();
            $table->foreign('question')->references('id')->on('emploi_question_offres')->cascadeOnDelete();
            $table->unique(['candidature', 'question']);
        });

        // Table des convocations des candidats retenues pour les entretiens.
        Schema::create('emploi_convocations', function (Blueprint $table) {

            $table->uuid('id')->primary();
            $table->uuid('candidature')->nullable(false);
            $table->string('objet')->nullable(false);
            $table->string('lieu')->nullable(true);
            $table->uuid('pays')->nullable(true);
            $table->string('adresse')->nullable(false);
            $table->dateTime('date')->nullable(false);
            $table->text('consignes')->nullable(true);
            $table->string('indicatifTelephonique')->nullable(false);
            $table->string('telephone')->nullable(false);
            $table->string('lien')->nullable(true);
            $table->uuid('auteurCreation')->nullable(true);
            $table->uuid('auteurMiseAJour')->nullable(true);

            $table->foreign('candidature')->references('id')->on('emploi_candidatures')->cascadeOnDelete();
            $table->foreign('pays')->references('id')->on('systeme_pays')->cascadeOnDelete();
            $table->foreign('auteurCreation')->references('id')->on('systeme_utilisateurs')->nullOnDelete();
            $table->foreign('auteurMiseAJour')->references('id')->on('systeme_utilisateurs')->nullOnDelete();
        });

        // Table des archives.
        Schema::create('emploi_archives', function (Blueprint $table) {

            $table->uuid('id')->primary();
            $table->uuid('utilisateur')->nullable(true);
            $table->string('offre')->nullable(true);
            $table->string('intitule')->nullable(true);
            $table->string('chemin')->nullable(true);
            $table->uuid('taille')->nullable(true);
            $table->boolean('statut')->nullable(true);
            $table->boolean('details')->nullable(true);
            $table->timestamps();

            $table->foreign('utilisateur')->references('id')->on('systeme_utilisateurs')->nullOnDelete();
        });
    }

    /**
     * Annule les migrations.
     */
    public function down(): void
    {

        Schema::dropIfExists('emploi_convocations');
        Schema::dropIfExists('emploi_candidature_reponses');
        Schema::dropIfExists('emploi_candidature_diplomes');
        Schema::dropIfExists('emploi_candidature_certificats');
        Schema::dropIfExists('emploi_candidature_experiences');
        Schema::dropIfExists('emploi_candidature_langues');
        Schema::dropIfExists('emploi_candidature_references');
        Schema::dropIfExists('emploi_candidature_portfolios');
        Schema::dropIfExists('emploi_candidature_centres');
        Schema::dropIfExists('emploi_candidature_competences');
        Schema::dropIfExists('emploi_candidatures');
        Schema::dropIfExists('emploi_candidat_certificats');
        Schema::dropIfExists('emploi_candidat_experiences');
        Schema::dropIfExists('emploi_candidat_langues');
        Schema::dropIfExists('emploi_candidat_references');
        Schema::dropIfExists('emploi_candidat_portfolios');
        Schema::dropIfExists('emploi_candidat_centres');
        Schema::dropIfExists('emploi_candidat_competences');
        Schema::dropIfExists('emploi_candidat_diplomes');
        Schema::dropIfExists('emploi_question_offres');
        Schema::dropIfExists('emploi_prerequis_langues');
        Schema::dropIfExists('emploi_prerequis_experiences');
        Schema::dropIfExists('emploi_prerequis_certificats');
        Schema::dropIfExists('emploi_prerequis_diplomes');
        Schema::dropIfExists('emploi_offre_emplois');
        Schema::dropIfExists('emploi_niveau_specialisations');
        Schema::dropIfExists('emploi_niveau_etudes');
        Schema::dropIfExists('emploi_domaine_etudes');
    }
};
