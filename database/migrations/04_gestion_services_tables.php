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

        Schema::create('service_demandes', function (Blueprint $table) {

            $table->uuid('id')->primary();
            $table->uuid('client')->nullable(false);
            $table->uuid('examinateur')->nullable(true);
            $table->enum('domaine', ['ressourcesHumaines', 'projetsProgrammes', 'recrutement', 'formation'])->nullable(false);
            $table->string('intitule')->nullable(false);
            $table->string('contenu')->nullable(false);
            $table->dateTime('dateDebutSouhaitee')->nullable(false);
            $table->dateTime('dateFinSouhaitee')->nullable(true);
            $table->enum('statutExamination', ['enTraitement', 'acceptee', 'rejetee'])->default('enTraitement');
            $table->text('observations')->nullable(true);
            $table->uuid('auteurCreation')->nullable(true);
            $table->uuid('auteurMiseAJour')->nullable(true);
            $table->timestamps();

            $table->foreign('client')->references('id')->on('systeme_utilisateurs')->cascadeOnDelete();
            $table->foreign('examinateur')->references('id')->on('systeme_utilisateurs')->nullOnDelete();
            $table->foreign('auteurCreation')->references('id')->on('systeme_utilisateurs')->nullOnDelete();
            $table->foreign('auteurMiseAJour')->references('id')->on('systeme_utilisateurs')->nullOnDelete();
        });

        Schema::create('service_propositions', function (Blueprint $table) {

            $table->uuid('id')->primary();
            $table->uuid('demande')->nullable(false);
            $table->uuid('facture')->nullable(false);
            $table->string('intitule')->nullable(false);
            $table->text('contenu')->nullable(false);
            $table->dateTime('dateDebutProbable')->nullable(true);
            $table->dateTime('dateFinProbable')->nullable(true);
            $table->uuid('auteurCreation')->nullable(true);
            $table->uuid('auteurMiseAJour')->nullable(true);
            $table->timestamps();

            $table->foreign('demande')->references('id')->on('service_demandes')->cascadeOnDelete();
            $table->foreign('facture')->references('id')->on('finance_factures')->cascadeOnDelete();
            $table->foreign('auteurCreation')->references('id')->on('systeme_utilisateurs')->nullOnDelete();
            $table->foreign('auteurMiseAJour')->references('id')->on('systeme_utilisateurs')->nullOnDelete();
        });

        Schema::create('service_attestations', function (Blueprint $table) {

            $table->uuid('id')->primary();
            $table->uuid('client')->nullable(false);
            $table->string('intitule')->nullable(false);
            $table->string('numero')->nullable(false);
            $table->dateTime('dateObtention')->nullable(false);
            $table->string('cheminAttestation')->nullable(false);
            $table->uuid('auteurCreation')->nullable(true);
            $table->uuid('auteurMiseAJour')->nullable(true);
            $table->timestamps();

            $table->foreign('client')->references('id')->on('systeme_utilisateurs')->cascadeOnDelete();
            $table->foreign('auteurCreation')->references('id')->on('systeme_utilisateurs')->nullOnDelete();
            $table->foreign('auteurMiseAJour')->references('id')->on('systeme_utilisateurs')->nullOnDelete();
        });

        Schema::create('service_demande_medias', function (Blueprint $table) {

            $table->uuid('id')->primary();
            $table->uuid('demande')->nullable(false);
            $table->string('nom')->nullable(true);
            $table->string('chemin')->nullable(false);
            $table->string('typeMime')->nullable(false);
            $table->unsignedBigInteger('taille')->nullable(false);
            $table->timestamps();

            $table->foreign('demande')->references('id')->on('service_demandes')->cascadeOnDelete();
        });

        Schema::create('service_proposition_medias', function (Blueprint $table) {

            $table->uuid('id')->primary();
            $table->uuid('proposition')->nullable(false);
            $table->string('nom')->nullable(true);
            $table->string('chemin')->nullable(false);
            $table->string('typeMime')->nullable(false);
            $table->unsignedBigInteger('taille')->nullable(false);
            $table->timestamps();

            $table->foreign('proposition')->references('id')->on('service_propositions')->cascadeOnDelete();
        });
    }

    /**
     * Annule migrations.
     */
    public function down(): void
    {

        Schema::dropIfExists('service_proposition_medias');
        Schema::dropIfExists('service_demande_medias');
        Schema::dropIfExists('service_attestations');
        Schema::dropIfExists('service_propositions');
        Schema::dropIfExists('service_demandes');
    }
};
