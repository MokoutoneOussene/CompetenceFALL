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

        Schema::create('blog_categories', function (Blueprint $table) {

            $table->uuid('id')->primary();
            $table->string('intitule')->nullable(false);
            $table->string('theme')->nullable(false);
            $table->text('description')->nullable(false);
            $table->boolean('statutVisibilite')->nullable(false);
            $table->uuid('auteurCreation')->nullable(true);
            $table->uuid('auteurMiseAJour')->nullable(true);
            $table->timestamps();

            $table->foreign('auteurCreation')->references('id')->on('systeme_utilisateurs')->nullOnDelete();
            $table->foreign('auteurMiseAJour')->references('id')->on('systeme_utilisateurs')->nullOnDelete();
        });

        Schema::create('blog_articles', function (Blueprint $table) {

            $table->uuid('id')->primary();
            $table->uuid('categorie')->nullable(true);
            $table->string('intitule')->nullable(false);
            $table->text('resume')->nullable(false);
            $table->boolean('statutVisibilite')->default(false);
            $table->uuid('auteurCreation')->nullable(true);
            $table->uuid('auteurMiseAJour')->nullable(true);
            $table->timestamps();

            $table->foreign('categorie')->references('id')->on('blog_categories')->nullOnDelete();
            $table->foreign('auteurCreation')->references('id')->on('systeme_utilisateurs')->nullOnDelete();
            $table->foreign('auteurMiseAJour')->references('id')->on('systeme_utilisateurs')->nullOnDelete();
        });

        Schema::create('blog_pages', function (Blueprint $table) {

            $table->uuid('id')->primary();
            $table->uuid('article')->nullable(false);
            $table->unsignedSmallInteger('numeroOrdre')->nullable(false);
            $table->text('intitule')->nullable(false);
            $table->text('resume')->nullable(false);
            $table->text('contenu')->nullable(false);
            $table->timestamps();

            $table->foreign('article')->references('id')->on('blog_articles')->cascadeOnDelete();
        });

        Schema::create('blog_medias', function (Blueprint $table) {

            $table->uuid('id')->primary();
            $table->uuid('article')->nullable(false);
            $table->string('nom')->nullable(true);
            $table->string('chemin')->nullable(false);
            $table->string('typeMime')->nullable(false);
            $table->unsignedBigInteger('taille')->nullable(false);
            $table->timestamps();

            $table->foreign('article')->references('id')->on('blog_articles')->cascadeOnDelete();
        });

        Schema::create('newsletter_categories', function (Blueprint $table) {

            $table->uuid('id')->primary();
            $table->string('intitule')->nullable(false);
            $table->string('theme')->nullable(false);
            $table->text('description')->nullable(false);
            $table->boolean('statutVisibilite')->default(false);
            $table->uuid('auteurCreation')->nullable(true);
            $table->uuid('auteurMiseAJour')->nullable(true);
            $table->timestamps();

            $table->foreign('auteurCreation')->references('id')->on('systeme_utilisateurs')->nullOnDelete();
            $table->foreign('auteurMiseAJour')->references('id')->on('systeme_utilisateurs')->nullOnDelete();
        });

        Schema::create('newsletter_articles', function (Blueprint $table) {

            $table->uuid('id')->primary();
            $table->uuid('categorie')->nullable(false);
            $table->string('intitule')->nullable(false);
            $table->text('resume')->nullable(false);
            $table->dateTime('dateEnvoiePrevue')->nullable(false);
            $table->dateTime('dateEnvoie')->nullable(true);
            $table->uuid('auteurCreation')->nullable(true);
            $table->uuid('auteurMiseAJour')->nullable(true);
            $table->timestamps();

            $table->foreign('auteurCreation')->references('id')->on('systeme_utilisateurs')->nullOnDelete();
            $table->foreign('auteurMiseAJour')->references('id')->on('systeme_utilisateurs')->nullOnDelete();
        });

        Schema::create('newsletter_pages', function (Blueprint $table) {

            $table->uuid('id')->primary();
            $table->uuid('article')->nullable(false);
            $table->unsignedSmallInteger('numeroOrdre')->nullable(false);
            $table->text('intitule')->nullable(true);
            $table->text('resume')->nullable(true);
            $table->text('contenu')->nullable(true);
            $table->timestamps();

            $table->foreign('article')->references('id')->on('newsletter_articles')->cascadeOnDelete();
        });

        Schema::create('newsletter_medias', function (Blueprint $table) {

            $table->uuid('id')->primary();
            $table->uuid('article')->nullable(false);
            $table->string('nom')->nullable(true);
            $table->string('chemin')->nullable(false);
            $table->string('typeMime')->nullable(false);
            $table->unsignedBigInteger('taille')->nullable(false);
            $table->timestamps();

            $table->foreign('article')->references('id')->on('newsletter_articles')->cascadeOnDelete();
        });

        Schema::create('newsletter_abonnes', function (Blueprint $table) {

            $table->uuid('id')->primary();
            $table->uuid('categorie')->nullable(false);
            $table->string('email')->nullable(false);
            $table->uuid('auteurCreation')->nullable(true);
            $table->uuid('auteurMiseAJour')->nullable(true);
            $table->timestamps();

            $table->foreign('categorie')->references('id')->on('newsletter_categories')->cascadeOnDelete();
            $table->foreign('auteurCreation')->references('id')->on('systeme_utilisateurs')->nullOnDelete();
            $table->foreign('auteurMiseAJour')->references('id')->on('systeme_utilisateurs')->nullOnDelete();
            $table->unique(['categorie', 'email']);
        });
    }

    /**
     * Annule migrations.
     */
    public function down(): void
    {

        Schema::dropIfExists('newsletter_abonnes');
        Schema::dropIfExists('newsletter_medias');
        Schema::dropIfExists('newsletter_pages');
        Schema::dropIfExists('newsletter_articles');
        Schema::dropIfExists('newsletter_categories');
        Schema::dropIfExists('blog_medias');
        Schema::dropIfExists('blog_pages');
        Schema::dropIfExists('blog_articles');
        Schema::dropIfExists('blog_categories');
    }
};
