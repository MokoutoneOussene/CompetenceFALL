<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Execute les migration.
     */
    public function up(): void
    {

        // Table des utilisateurs.
        Schema::create('systeme_utilisateurs', function (Blueprint $table) {

            $table->uuid('id')->primary();
            $table->string('cheminPhotoProfil')->nullable(true);
            $table->string('cheminBanniere')->nullable(true);
            $table->string('nomUtilisateur')->unique()->nullable(false);
            $table->text('motDePasse')->default(Hash::make('M0tDeP@sseF0rt'));
            $table->string('email')->unique()->nullable(false);
            $table->string('indicatifTelephonique')->nullable(true);
            $table->string('telephone')->nullable(true);
            $table->string('boitePostale')->unique()->nullable(true);
            $table->string('siteWeb')->unique()->nullable(true);
            $table->text('description')->nullable(true);
            $table->enum('typeUtilisateur', ['personne', 'organisation'])->default('personne');
            $table->boolean('statutDoubleAuthentification')->default(false);
            $table->dateTime('dateVerificationEmail')->nullable(true);
            $table->boolean('statutNotificationEmail')->default(true);
            $table->string('otp')->unique()->nullable(true);
            $table->dateTime('dateExpirationOtp')->nullable(true);
            $table->dateTime('dateProchaineTentativeOtp')->nullable(true);
            $table->dateTime('dateVerificationTelephone')->nullable(true);
            $table->boolean('statutNotificationSms')->default(true);
            $table->dateTime('dateDerniereConnexion')->nullable(true);
            $table->timestamps();

            $table->unique(['indicatifTelephonique', 'telephone']);
        });

        Schema::create('systeme_roles', function (Blueprint $table) {

            $table->uuid('id')->primary();
            $table->string('iconeRole')->nullable(false);
            $table->string('intitule')->unique()->nullable(false);
            $table->string('slug')->unique()->nullable(false);
            $table->enum('categorie', [
                'systeme', 'superadministrateur', 'administrateur', 'responsable', 'collaborateur', 'standard',
            ])->nullable(false);
            $table->text('description')->nullable(false);
            $table->unsignedBigInteger('nombreUtilisateursLimite')->nullable(false);
            $table->uuid('auteurCreation')->nullable(true);
            $table->uuid('auteurMiseAJour')->nullable(true);
            $table->timestamps();

            $table->foreign('auteurCreation')->references('id')->on('systeme_utilisateurs')->nullOnDelete();
            $table->foreign('auteurMiseAJour')->references('id')->on('systeme_utilisateurs')->nullOnDelete();
        });

        Schema::create('systeme_privileges', function (Blueprint $table) {

            $table->uuid('id')->primary();
            $table->uuid('utilisateur')->nullable(false);
            $table->uuid('role')->nullable(false);
            $table->boolean('statutActivation')->default(true);
            $table->uuid('auteurCreation')->nullable(true);
            $table->uuid('auteurMiseAJour')->nullable(true);
            $table->timestamps();

            $table->foreign('utilisateur')->references('id')->on('systeme_utilisateurs')->cascadeOnDelete();
            $table->foreign('role')->references('id')->on('systeme_roles')->cascadeOnDelete();
            $table->foreign('auteurCreation')->references('id')->on('systeme_utilisateurs')->nullOnDelete();
            $table->foreign('auteurMiseAJour')->references('id')->on('systeme_utilisateurs')->nullOnDelete();
            $table->unique(['utilisateur', 'role']);
        });

        Schema::create('systeme_historique_mot_de_passes', function (Blueprint $table) {

            $table->uuid('id')->primary();
            $table->uuid('utilisateur')->nullable(false);
            $table->text('motDePasse')->nullable(false);
            $table->timestamps();

            $table->foreign('utilisateur')->references('id')->on('systeme_utilisateurs')->cascadeOnDelete();
        });

        Schema::create('systeme_sessions', function (Blueprint $table) {

            $table->uuid('id')->primary();
            $table->uuid('utilisateur')->nullable(false);
            $table->text('agent')->nullable(false);
            $table->string('ipv4')->nullable(false);
            $table->uuid('jeton')->unique()->nullable(false);
            $table->dateTime('dateExpiration')->nullable(false);
            $table->timestamps();

            $table->foreign('utilisateur')->references('id')->on('systeme_utilisateurs')->cascadeOnDelete();
        });

        Schema::create('systeme_tentative_connexions', function (Blueprint $table) {

            $table->uuid('id')->primary();
            $table->uuid('utilisateur')->nullable(false);
            $table->text('agent')->nullable(false);
            $table->string('ipv4')->nullable(false);
            $table->timestamps();

            $table->foreign('utilisateur')->references('id')->on('systeme_utilisateurs')->cascadeOnDelete();
        });

        Schema::create('systeme_utilisateur_blocages', function (Blueprint $table) {

            $table->uuid('id')->primary();
            $table->uuid('utilisateur')->nullable(false);
            $table->string('motif')->nullable(false);
            $table->boolean('statutActivation')->default(true);
            $table->boolean('statutDeblocable')->default(true);
            $table->uuid('auteurCreation')->nullable(true);
            $table->uuid('auteurMiseAJour')->nullable(true);
            $table->timestamps();

            $table->foreign('utilisateur')->references('id')->on('systeme_utilisateurs')->cascadeOnDelete();
            $table->foreign('auteurCreation')->references('id')->on('systeme_utilisateurs')->nullOnDelete();
            $table->foreign('auteurMiseAJour')->references('id')->on('systeme_utilisateurs')->nullOnDelete();
        });

        Schema::create('systeme_logs', function (Blueprint $table) {

            $table->uuid('id')->primary();
            $table->uuid('utilisateur')->nullable(true);
            $table->string('action')->nullable(false);
            $table->dateTime('date')->nullable(false);
            $table->json('champs')->nullable(true);
            $table->text('details')->nullable(true);
            $table->timestamps();

            $table->foreign('utilisateur')->references('id')->on('systeme_utilisateurs')->nullOnDelete();
        });

        Schema::create('systeme_pays', function (Blueprint $table) {

            $table->uuid('id')->primary();
            $table->string('nom')->unique()->nullable(false);
        });

        Schema::create('systeme_indicatif_telephoniques', function (Blueprint $table) {

            $table->uuid('id')->primary();
            $table->uuid('pays')->unique()->nullable(false);
            $table->unsignedSmallInteger('valeur')->nullable(false);

            $table->foreign('pays')->references('id')->on('systeme_pays')->cascadeOnDelete();
        });

        Schema::create('systeme_organisations', function (Blueprint $table) {

            $table->uuid('id')->primary();
            $table->uuid('utilisateur')->unique()->nullable(false);
            $table->string('identifiant')->nullable(false);
            $table->string('denomination')->unique()->nullable(false);
            $table->string('statutJuridique')->nullable(false);
            $table->string('domaine')->nullable(false);
            $table->dateTime('dateFondation')->nullable(true);
            $table->unsignedBigInteger('capitalSocial')->nullable(true);
            $table->unsignedSmallInteger('nombreEmploye')->nullable(true);
            $table->string('lieuSiege')->nullable(false);
            $table->uuid('paysSiege')->nullable(true);
            $table->uuid('auteurCreation')->nullable(true);
            $table->uuid('auteurMiseAJour')->nullable(true);
            $table->timestamps();

            $table->foreign('utilisateur')->references('id')->on('systeme_utilisateurs')->cascadeOnDelete();
            $table->foreign('paysSiege')->references('id')->on('systeme_pays')->nullOnDelete();
            $table->foreign('auteurCreation')->references('id')->on('systeme_utilisateurs')->nullOnDelete();
            $table->foreign('auteurMiseAJour')->references('id')->on('systeme_utilisateurs')->nullOnDelete();
            $table->unique(['paysSiege', 'identifiant']);
            $table->unique(['paysSiege', 'denomination']);
        });

        Schema::create('systeme_personnes', function (Blueprint $table) {

            $table->uuid('id')->primary();
            $table->uuid('utilisateur')->unique()->nullable(false);
            $table->string('nom')->nullable(true);
            $table->string('prenoms')->nullable(true);
            $table->enum('genre', ['masculin', 'feminin', 'nonPrecise'])->default('nonPrecise');
            $table->date('dateNaissance')->nullable(true);
            $table->string('lieuNaissance')->nullable(true);
            $table->uuid('paysNaissance')->nullable(true); //
            $table->string('lieuResidence')->nullable(true);
            $table->uuid('paysResidence')->nullable(true); //
            $table->string('nationalites')->nullable(true);
            $table->uuid('auteurCreation')->nullable(true);
            $table->uuid('auteurMiseAJour')->nullable(true);
            $table->timestamps();

            $table->foreign('utilisateur')->references('id')->on('systeme_utilisateurs')->cascadeOnDelete();
            $table->foreign('paysNaissance')->references('id')->on('systeme_pays')->nullOnDelete();
            $table->foreign('paysResidence')->references('id')->on('systeme_pays')->nullOnDelete();
            $table->foreign('auteurCreation')->references('id')->on('systeme_utilisateurs')->nullOnDelete();
            $table->foreign('auteurMiseAJour')->references('id')->on('systeme_utilisateurs')->nullOnDelete();
        });

        Schema::create('systeme_bannieres', function (Blueprint $table) {

            $table->uuid('id')->primary();
            $table->string('intitule')->nullable(false);
            $table->string('contenu')->nullable(false);
            $table->dateTime('dateDebutDiffusion')->nullable(false);
            $table->dateTime('dateFinDiffusion')->nullable(false);
            $table->boolean('statutActivation')->nullable(false);
            $table->uuid('auteurCreation')->nullable(true);
            $table->uuid('auteurMiseAJour')->nullable(true);
            $table->timestamps();

            $table->foreign('auteurCreation')->references('id')->on('systeme_utilisateurs')->nullOnDelete();
            $table->foreign('auteurMiseAJour')->references('id')->on('systeme_utilisateurs')->nullOnDelete();
        });

        Schema::create('systeme_chiffres', function (Blueprint $table) {

            $table->uuid('id')->primary();
            $table->string('intitule')->nullable(false);
            $table->unsignedBigInteger('valeur')->nullable(false);
            $table->text('description')->nullable(true);
            $table->uuid('auteurCreation')->nullable(true);
            $table->uuid('auteurMiseAJour')->nullable(true);
            $table->timestamps();

            $table->foreign('auteurCreation')->references('id')->on('systeme_utilisateurs')->nullOnDelete();
            $table->foreign('auteurMiseAJour')->references('id')->on('systeme_utilisateurs')->nullOnDelete();
        });

        Schema::create('systeme_faqs', function (Blueprint $table) {

            $table->uuid('id')->primary();
            $table->text('question')->nullable(false);
            $table->text('reponse')->nullable(false);
            $table->uuid('auteurCreation')->nullable(true);
            $table->uuid('auteurMiseAJour')->nullable(true);
            $table->timestamps();

            $table->foreign('auteurCreation')->references('id')->on('systeme_utilisateurs')->nullOnDelete();
            $table->foreign('auteurMiseAJour')->references('id')->on('systeme_utilisateurs')->nullOnDelete();
        });

        Schema::create('systeme_faq_medias', function (Blueprint $table) {

            $table->uuid('id')->primary();
            $table->uuid('faq')->nullable(false);
            $table->string('nom')->nullable(true);
            $table->string('chemin')->nullable(false);
            $table->string('typeMime')->nullable(false);
            $table->unsignedBigInteger('taille')->nullable(false);
            $table->uuid('auteurCreation')->nullable(true);
            $table->uuid('auteurMiseAJour')->nullable(true);
            $table->timestamps();

            $table->foreign('faq')->references('id')->on('systeme_faqs')->cascadeOnDelete();
            $table->foreign('auteurCreation')->references('id')->on('systeme_utilisateurs')->nullOnDelete();
            $table->foreign('auteurMiseAJour')->references('id')->on('systeme_utilisateurs')->nullOnDelete();
        });

        Schema::create('systeme_commentaire_anonymes', function (Blueprint $table) {

            $table->uuid('id')->primary();
            $table->string('email')->nullable(false);
            $table->string('objet')->nullable(false);
            $table->text('contenu')->nullable(false);
            $table->uuid('auteurCreation')->nullable(true);
            $table->uuid('auteurMiseAJour')->nullable(true);
            $table->timestamps();

            $table->foreign('auteurCreation')->references('id')->on('systeme_utilisateurs')->nullOnDelete();
            $table->foreign('auteurMiseAJour')->references('id')->on('systeme_utilisateurs')->nullOnDelete();
        });

        Schema::create('systeme_politiques', function (Blueprint $table) {

            $table->uuid('id')->primary();
            $table->string('intitule')->nullable(false);
            $table->text('contenu')->nullable(false);
            $table->uuid('auteurCreation')->nullable(true);
            $table->uuid('auteurMiseAJour')->nullable(true);
            $table->timestamps();

            $table->foreign('auteurCreation')->references('id')->on('systeme_utilisateurs')->nullOnDelete();
            $table->foreign('auteurMiseAJour')->references('id')->on('systeme_utilisateurs')->nullOnDelete();
        });

        Schema::create('systeme_parametres', function (Blueprint $table) {

            $table->uuid('id')->primary();
            $table->string('intitule')->nullable(false);
            $table->string('valeur')->nullable(false);
            $table->enum('categorie', ['systeme', 'finance', 'service', 'emploi', 'forum', 'blog', 'newsletter'])->nullable(false);
            $table->text('description')->nullable(false);
            $table->uuid('auteurCreation')->nullable(true);
            $table->uuid('auteurMiseAJour')->nullable(true);
            $table->timestamps();

            $table->foreign('auteurMiseAJour')->references('id')->on('systeme_utilisateurs')->nullOnDelete();
            $table->foreign('auteurCreation')->references('id')->on('systeme_utilisateurs')->nullOnDelete();
        });

        Schema::create('interface_applications', function (Blueprint $table) {

            $table->uuid('id')->primary();
            $table->string('denomination')->nullable(false);
            $table->string('jeton')->nullable(false);
            $table->boolean('statutActivation')->default(true);
            $table->dateTime('dateExpiration')->nullable(true);
            $table->uuid('auteurCreation')->nullable(true);
            $table->uuid('auteurMiseAJour')->nullable(true);
            $table->timestamps();

            $table->foreign('auteurCreation')->references('id')->on('systeme_utilisateurs')->nullOnDelete();
            $table->foreign('auteurMiseAJour')->references('id')->on('systeme_utilisateurs')->nullOnDelete();
        });
    }

    /**
     * Annule migrations.
     */
    public function down(): void
    {

        Schema::dropIfExists('interface_applications');
        Schema::dropIfExists('systeme_parametres');
        Schema::dropIfExists('systeme_politiques');
        Schema::dropIfExists('systeme_commentaire_anonymes');
        Schema::dropIfExists('systeme_faq_medias');
        Schema::dropIfExists('systeme_faqs');
        Schema::dropIfExists('systeme_chiffres');
        Schema::dropIfExists('systeme_bannieres');
        Schema::dropIfExists('systeme_personnes');
        Schema::dropIfExists('systeme_organisations');
        Schema::dropIfExists('systeme_indicatif_telephoniques');
        Schema::dropIfExists('systeme_pays');
        Schema::dropIfExists('systeme_logs');
        Schema::dropIfExists('systeme_utilisateur_blocages');
        Schema::dropIfExists('systeme_tentative_connexions');
        Schema::dropIfExists('systeme_sessions');
        Schema::dropIfExists('systeme_historique_mot_de_passes');
        Schema::dropIfExists('systeme_privileges');
        Schema::dropIfExists('systeme_roles');
        Schema::dropIfExists('systeme_utilisateurs');
    }
};
