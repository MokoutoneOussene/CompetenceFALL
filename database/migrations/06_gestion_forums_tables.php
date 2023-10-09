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

        Schema::create('forum_forums', function (Blueprint $table) {

            $table->uuid('id')->primary();
            $table->string('intitule')->unique()->nullable(false);
            $table->string('theme')->nullable(false);
            $table->text('description')->nullable(false);
            $table->text('regles')->nullable(false);
            $table->uuid('auteurCreation')->nullable(true);
            $table->uuid('auteurMiseAJour')->nullable(true);
            $table->timestamps();

            $table->foreign('auteurCreation')->references('id')->on('systeme_utilisateurs')->nullOnDelete();
            $table->foreign('auteurMiseAJour')->references('id')->on('systeme_utilisateurs')->nullOnDelete();
        });

        Schema::create('forum_membres', function (Blueprint $table) {

            $table->uuid('id')->primary();
            $table->uuid('utilisateur')->nullable(false);
            $table->uuid('forum')->nullable(false);
            $table->boolean('statutActivation')->default(false);
            $table->uuid('auteurCreation')->nullable(true);
            $table->uuid('auteurMiseAJour')->nullable(true);
            $table->timestamps();

            $table->foreign('utilisateur')->references('id')->on('systeme_utilisateurs')->cascadeOnDelete();
            $table->foreign('forum')->references('id')->on('forum_forums')->cascadeOnDelete();
            $table->foreign('auteurCreation')->references('id')->on('systeme_utilisateurs')->nullOnDelete();
            $table->foreign('auteurMiseAJour')->references('id')->on('systeme_utilisateurs')->nullOnDelete();
        });

        Schema::create('forum_posts', function (Blueprint $table) {

            $table->uuid('id')->primary();
            $table->uuid('membre')->nullable(true);
            $table->uuid('forum')->nullable(false);
            $table->text('contenu')->nullable(false);
            $table->text('statutVisibilite')->nullable(false);
            $table->uuid('auteurCreation')->nullable(true);
            $table->uuid('auteurMiseAJour')->nullable(true);
            $table->timestamps();

            $table->foreign('membre')->references('id')->on('forum_membres')->nullOnDelete();
            $table->foreign('forum')->references('id')->on('forum_forums')->cascadeOnDelete();
            $table->foreign('auteurCreation')->references('id')->on('systeme_utilisateurs')->nullOnDelete();
            $table->foreign('auteurMiseAJour')->references('id')->on('systeme_utilisateurs')->nullOnDelete();
        });

        Schema::create('forum_post_medias', function (Blueprint $table) {

            $table->uuid('id')->primary();
            $table->uuid('post')->nullable(false);
            $table->string('nom')->nullable(true);
            $table->string('chemin')->nullable(false);
            $table->string('typeMime')->nullable(false);
            $table->unsignedBigInteger('taille')->nullable(false);
            $table->timestamps();

            $table->foreign('post')->references('id')->on('forum_posts')->cascadeOnDelete();
        });

        Schema::create('forum_post_reactions', function (Blueprint $table) {

            $table->uuid('id')->primary();
            $table->uuid('membre')->nullable(true);
            $table->uuid('post')->nullable(false);
            $table->enum('reaction', ['aimer', 'nePasAimer'])->nullable(false);
            $table->timestamps();

            $table->foreign('membre')->references('id')->on('forum_membres')->nullOnDelete();
            $table->foreign('post')->references('id')->on('forum_posts')->cascadeOnDelete();
        });

        Schema::create('forum_post_reponses', function (Blueprint $table) {

            $table->uuid('id')->primary();
            $table->uuid('post')->nullable(false);
            $table->uuid('reponse')->nullable(false);
            $table->timestamps();

            $table->foreign('post')->references('id')->on('forum_posts')->cascadeOnDelete();
            $table->foreign('reponse')->references('id')->on('forum_posts')->cascadeOnDelete();
        });

        Schema::create('forum_signalements', function (Blueprint $table) {

            $table->uuid('id')->primary();
            $table->uuid('membre')->nullable(false);
            $table->uuid('post')->nullable(false);
            $table->text('motif')->nullable(false);
            $table->timestamps();

            $table->foreign('membre')->references('id')->on('forum_membres')->cascadeOnDelete();
            $table->foreign('post')->references('id')->on('forum_posts')->cascadeOnDelete();
        });

        Schema::create('forum_avertissements', function (Blueprint $table) {

            $table->uuid('id')->primary();
            $table->uuid('membre')->nullable(true);
            $table->uuid('post')->nullable(true);
            $table->text('motif')->nullable(false);
            $table->uuid('auteurCreation')->nullable(true);
            $table->uuid('auteurMiseAJour')->nullable(true);
            $table->timestamps();

            $table->foreign('membre')->references('id')->on('forum_membres')->cascadeOnDelete();
            $table->foreign('post')->references('id')->on('forum_posts')->cascadeOnDelete();
            $table->foreign('auteurCreation')->references('id')->on('systeme_utilisateurs')->nullOnDelete();
            $table->foreign('auteurMiseAJour')->references('id')->on('systeme_utilisateurs')->nullOnDelete();
        });

        Schema::create('forum_banissements', function (Blueprint $table) {

            $table->uuid('id')->primary();
            $table->uuid('membre')->nullable(false);
            $table->text('motif')->nullable(false);
            $table->uuid('auteurCreation')->nullable(true);
            $table->uuid('auteurMiseAJour')->nullable(true);
            $table->timestamps();

            $table->foreign('membre')->references('id')->on('forum_membres')->cascadeOnDelete();
            $table->foreign('auteurCreation')->references('id')->on('systeme_utilisateurs')->nullOnDelete();
            $table->foreign('auteurMiseAJour')->references('id')->on('systeme_utilisateurs')->nullOnDelete();
        });
    }

    /**
     * Annule migrations.
     */
    public function down(): void
    {

        Schema::dropIfExists('forum_banissements');
        Schema::dropIfExists('forum_avertissements');
        Schema::dropIfExists('forum_signalements');
        Schema::dropIfExists('forum_post_reponses');
        Schema::dropIfExists('forum_post_reactions');
        Schema::dropIfExists('forum_post_medias');
        Schema::dropIfExists('forum_posts');
        Schema::dropIfExists('forum_membres');
        Schema::dropIfExists('forum_forums');
    }
};
