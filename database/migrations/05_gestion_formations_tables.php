<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Execute les migration.
     */
    public function up(): void
    {

        Schema::create('formation_lignes', function (Blueprint $table) {

            $table->uuid('id')->primary();
            $table->string('intitule')->nullable(false);
            $table->enum('typeFormation', ['presentielle', 'enLigne'])->default('enLigne');
            $table->text('description')->nullable(false);
            $table->enum('niveauDifficulte', ['facile', 'intermediaire', 'avance'])->nullable(false);
            $table->unsignedSmallInteger('duree')->nullable(false);
            $table->unsignedBigInteger('cout')->nullable(false);
            $table->boolean('statutPublic')->default(true);
            $table->boolean('statutActivation')->default(true);
            $table->uuid('auteurCreation')->nullable(true);
            $table->uuid('auteurMiseAJour')->nullable(true);
            $table->timestamps();

            $table->foreign('auteurCreation')->references('id')->on('systeme_utilisateurs')->nullOnDelete();
            $table->foreign('auteurMiseAJour')->references('id')->on('systeme_utilisateurs')->nullOnDelete();
        });

        Schema::create('formation_participants', function (Blueprint $table) {

            $table->uuid('id')->primary();
            $table->uuid('utilisateur')->nullable(false);
            $table->uuid('formation')->nullable(false);
            $table->uuid('facture')->nullable(true);
            $table->boolean('statutActivation')->default(true);
            $table->timestamps();

            $table->foreign('utilisateur')->references('id')->on('systeme_utilisateurs')->cascadeOnDelete();
            $table->foreign('formation')->references('id')->on('formation_lignes')->cascadeOnDelete();
            $table->foreign('facture')->references('id')->on('finance_factures')->nullOnDelete();
        });

        Schema::create('formation_prerequis', function (Blueprint $table) {

            $table->uuid('id')->primary();
            $table->uuid('formation')->nullable(false);
            $table->uuid('prerequis')->nullable(false);
            $table->timestamps();

            $table->foreign('formation')->references('id')->on('formation_lignes')->cascadeOnDelete();
            $table->foreign('prerequis')->references('id')->on('formation_lignes')->cascadeOnDelete();
        });

        Schema::create('formation_presentielles', function (Blueprint $table) {

            $table->uuid('id')->primary();
            $table->uuid('formation')->nullable(false);
            $table->uuid('formateur')->nullable(true); //
            $table->text('prerequis')->nullable(false);
            $table->dateTime('dateDebut')->nullable(false);
            $table->dateTime('dateFin')->nullable(false);
            $table->string('lieu')->nullable(false);
            $table->uuid('pays')->nullable(false);
            $table->timestamps();

            $table->foreign('formation')->references('id')->on('formation_lignes')->cascadeOnDelete();
            $table->foreign('formateur')->references('id')->on('systeme_utilisateurs')->nullOnDelete();
            $table->foreign('pays')->references('id')->on('systeme_pays')->cascadeOnDelete();
        });

        Schema::create('formation_programmes', function (Blueprint $table) {

            $table->uuid('id')->primary();
            $table->uuid('formation')->nullable(false);
            $table->string('intitule')->nullable(false);
            $table->text('details')->nullable(false);
            $table->dateTime('dateDebut')->nullable(false);
            $table->dateTime('dateFin')->nullable(false);
            $table->timestamps();

            $table->foreign('formation')->references('id')->on('formation_lignes')->cascadeOnDelete();
        });

        Schema::create('formation_parties', function (Blueprint $table) {

            $table->uuid('id')->primary();
            $table->uuid('formation')->nullable(false);
            $table->string('intitule')->nullable(false);
            $table->text('resume')->nullable(false);
            $table->timestamps();

            $table->foreign('formation')->references('id')->on('formation_lignes')->cascadeOnDelete();
        });

        Schema::create('formation_pages', function (Blueprint $table) {

            $table->uuid('id')->primary();
            $table->uuid('partie')->nullable(false);
            $table->string('intitule')->nullable(true);
            $table->unsignedSmallInteger('numeroOrdre')->nullable(false);
            $table->text('contenu')->nullable(false);
            $table->timestamps();

            $table->foreign('partie')->references('id')->on('formation_parties')->cascadeOnDelete();
        });

        Schema::create('formation_medias', function (Blueprint $table) {

            $table->uuid('id')->primary();
            $table->uuid('formation')->nullable(false);
            $table->string('nom')->nullable(true);
            $table->string('chemin')->nullable(false);
            $table->string('typeMime')->nullable(false);
            $table->unsignedBigInteger('taille')->nullable(false);
            $table->timestamps();

            $table->foreign('formation')->references('id')->on('formation_lignes')->cascadeOnDelete();
        });

        Schema::create('formation_progressions', function (Blueprint $table) {

            $table->uuid('id')->primary();
            $table->uuid('participant')->nullable(false);
            $table->uuid('page')->nullable(true);
            $table->timestamps();

            $table->foreign('participant')->references('id')->on('formation_participants')->cascadeOnDelete();
            $table->foreign('page')->references('id')->on('formation_pages')->nullOnDelete();
        });

        Schema::create('formation_evaluations', function (Blueprint $table) {

            $table->uuid('id')->primary();
            $table->uuid('formation')->nullable(false);
            $table->string('intitule')->nullable(false);
            $table->text('description')->nullable(false);
            $table->unsignedSmallInteger('nombreQuestions')->nullable(false);
            $table->unsignedSmallInteger('nombreBonnesReponses')->nullable(false);
            $table->unsignedSmallInteger('duree')->nullable(false);
            $table->dateTime('dateDebutComposition')->nullable(true);
            $table->dateTime('dateFinComposition')->nullable(true);
            $table->timestamps();

            $table->foreign('formation')->references('id')->on('formation_lignes')->cascadeOnDelete();
        });

        Schema::create('formation_questions', function (Blueprint $table) {

            $table->uuid('id')->primary();
            $table->uuid('evaluation')->nullable(false);
            $table->text('contenu')->nullable(false);
            $table->enum('typeQuestion', [
                'vraiFaux', 'choixUnique', 'choixMultiple', 'reponseCourte',
            ])->default('vraiFaux');
            $table->timestamps();

            $table->foreign('evaluation')->references('id')->on('formation_evaluations')->cascadeOnDelete();
        });

        Schema::create('formation_evaluation_medias', function (Blueprint $table) {

            $table->uuid('id')->primary();
            $table->uuid('evaluation')->nullable(false);
            $table->string('nom')->nullable(false);
            $table->string('chemin')->nullable(false);
            $table->string('typeMime')->nullable(false);
            $table->unsignedBigInteger('taille')->nullable(false);
            $table->timestamps();

            $table->foreign('evaluation')->references('id')->on('formation_evaluations')->cascadeOnDelete();
        });

        Schema::create('formation_reponses', function (Blueprint $table) {

            $table->uuid('id')->primary();
            $table->uuid('question')->nullable(false);
            $table->text('contenu')->nullable(true);
            $table->boolean('bonneReponse')->default(false);
            $table->timestamps();

            $table->foreign('question')->references('id')->on('formation_questions')->cascadeOnDelete();
        });

        Schema::create('formation_compositions', function (Blueprint $table) {

            $table->uuid('id')->primary();
            $table->uuid('participant')->nullable(false);
            $table->uuid('evaluation')->nullable(false);
            $table->unsignedSmallInteger('noteObtenue')->default(0);
            $table->dateTime('dateDebut')->nullable(true);
            $table->dateTime('dateFin')->nullable(true);
            $table->uuid('auteurCreation')->nullable(true);
            $table->uuid('auteurMiseAJour')->nullable(true);
            $table->timestamps();

            $table->foreign('participant')->references('id')->on('formation_participants')->cascadeOnDelete();
            $table->foreign('evaluation')->references('id')->on('formation_evaluations')->cascadeOnDelete();
            $table->foreign('auteurCreation')->references('id')->on('systeme_utilisateurs')->nullOnDelete();
            $table->foreign('auteurMiseAJour')->references('id')->on('systeme_utilisateurs')->nullOnDelete();
        });

        Schema::create('formation_tirages', function (Blueprint $table) {

            $table->uuid('id')->primary();
            $table->uuid('composition')->nullable(false);
            $table->uuid('question')->nullable(false);
            $table->unsignedSmallInteger('ordreTirage')->nullable(false);
            $table->dateTime('dateEnvoiQuestion')->nullable(true);
            $table->dateTime('dateRetourReponse')->nullable(true);
            $table->string('reponseTexte')->nullable(true);
            $table->boolean('reponseTrouvee')->default(false);
            $table->timestamps();

            $table->foreign('composition')->references('id')->on('formation_compositions')->cascadeOnDelete();
            $table->foreign('question')->references('id')->on('formation_questions')->cascadeOnDelete();
        });

        Schema::create('formation_certificats', function (Blueprint $table) {

            $table->uuid('id')->primary();
            $table->uuid('participant')->nullable(true); //
            $table->string('identifiant')->nullable(true);
            $table->string('intitule')->nullable(false);
            $table->string('domaine')->nullable(false);
            $table->string('cheminCertificat')->nullable(true);
            $table->uuid('auteurCreation')->nullable(true);
            $table->uuid('auteurMiseAJour')->nullable(true);
            $table->timestamps();

            $table->foreign('participant')->references('id')->on('formation_participants')->nullOnDelete();
            $table->foreign('auteurCreation')->references('id')->on('systeme_utilisateurs')->nullOnDelete();
            $table->foreign('auteurMiseAJour')->references('id')->on('systeme_utilisateurs')->nullOnDelete();
        });
    }

    /**
     * Annule migrations.
     */
    public function down(): void
    {

        Schema::dropIfExists('formation_tirages');
        Schema::dropIfExists('formation_certificats');
        Schema::dropIfExists('formation_compositions');
        Schema::dropIfExists('formation_reponses');
        Schema::dropIfExists('formation_evaluation_medias');
        Schema::dropIfExists('formation_questions');
        Schema::dropIfExists('formation_evaluations');
        Schema::dropIfExists('formation_progressions');
        Schema::dropIfExists('formation_medias');
        Schema::dropIfExists('formation_pages');
        Schema::dropIfExists('formation_parties');
        Schema::dropIfExists('formation_programmes');
        Schema::dropIfExists('formation_presentielles');
        Schema::dropIfExists('formation_prerequis');
        Schema::dropIfExists('formation_participants');
        Schema::dropIfExists('formation_lignes');
    }
};
