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

        Schema::create('finance_factures', function (Blueprint $table) {

            $table->uuid('id')->primary();
            $table->uuid('client')->nullable(false);
            $table->string('numeroFacture')->nullable(false);
            $table->enum('statutTraitement', [
                'enAttente', 'valide', 'paye', 'annule', 'EnLitige', 'echue',
            ])->default('enAttente');
            $table->unsignedBigInteger('montantHT')->nullable(true);
            $table->boolean('statutApplicationTva')->default(false);
            $table->unsignedSmallInteger('tauxTva')->nullable(true);
            $table->unsignedBigInteger('montantTva')->nullable(true);
            $table->unsignedBigInteger('montantTTC')->nullable(true);
            $table->text('modePaiement')->nullable(true);
            $table->text('modalitesPaiement')->nullable(true);
            $table->dateTime('dateLimitePaiement')->nullable(false);
            $table->string('cheminSignature')->nullable(false);
            $table->uuid('auteurCreation')->nullable(true);
            $table->uuid('auteurMiseAJour')->nullable(true);
            $table->timestamps(); // Date de création

            $table->foreign('client')->references('id')->on('systeme_utilisateurs')->cascadeOnDelete();
            $table->foreign('auteurCreation')->references('id')->on('systeme_utilisateurs')->nullOnDelete();
            $table->foreign('auteurMiseAJour')->references('id')->on('systeme_utilisateurs')->nullOnDelete();
        });

        Schema::create('finance_biens', function (Blueprint $table) {

            $table->uuid('id')->primary();
            $table->uuid('facture')->nullable(false);
            $table->string('numeroOrdre')->nullable(false);
            $table->string('designation')->nullable(false);
            $table->string('unite')->nullable(false);
            $table->unsignedSmallInteger('quantite')->nullable(false);
            $table->unsignedSmallInteger('priUnitaire')->nullable(false);
            $table->unsignedBigInteger('montant')->nullable(false);
            $table->uuid('auteurCreation')->nullable(true);
            $table->uuid('auteurMiseAJour')->nullable(true);
            $table->timestamps(); // Date de création

            $table->foreign('facture')->references('id')->on('finance_factures')->cascadeOnDelete();
            $table->foreign('auteurCreation')->references('id')->on('systeme_utilisateurs')->nullOnDelete();
            $table->foreign('auteurMiseAJour')->references('id')->on('systeme_utilisateurs')->nullOnDelete();
        });

        Schema::create('finance_remises', function (Blueprint $table) {

            $table->uuid('id')->primary();
            $table->uuid('facture')->nullable(false);
            $table->string('intitule');
            $table->text('description')->nullable(false);
            $table->unsignedBigInteger('montant')->nullable(false);
            $table->unsignedDecimal('pourcentage', 5, 2)->nullable(false);
            $table->dateTime('dateLimite')->nullable(false);
            $table->uuid('auteurCreation')->nullable(true);
            $table->uuid('auteurMiseAJour')->nullable(true);
            $table->timestamps();

            $table->foreign('facture')->references('id')->on('finance_factures')->cascadeOnDelete();
            $table->foreign('auteurCreation')->references('id')->on('systeme_utilisateurs')->nullOnDelete();
            $table->foreign('auteurMiseAJour')->references('id')->on('systeme_utilisateurs')->nullOnDelete();

        });

        Schema::create('finance_paiements', function (Blueprint $table) {

            $table->uuid('id')->primary();
            $table->uuid('facture')->nullable(false);
            $table->enum('mode', ['especes', 'mobileMoney', 'virementBancaire', 'carteCredit', 'chequeBancaire'])->default('especes');
            $table->text('details')->nullable(true);
            $table->unsignedBigInteger('montant')->nullable(false);
            $table->boolean('statutAnnulation')->default(false);
            $table->text('motifAnnulation')->nullable(true);
            $table->uuid('auteurCreation')->nullable(true);
            $table->uuid('auteurMiseAJour')->nullable(true);
            $table->timestamps();

            $table->foreign('facture')->references('id')->on('finance_factures')->cascadeOnDelete();
            $table->foreign('auteurCreation')->references('id')->on('systeme_utilisateurs')->nullOnDelete();
            $table->foreign('auteurMiseAJour')->references('id')->on('systeme_utilisateurs')->nullOnDelete();
        });

        Schema::create('finance_remboursements', function (Blueprint $table) {

            $table->uuid('id')->primary();
            $table->uuid('paiement')->nullable(false);
            $table->unsignedBigInteger('montant')->nullable(false);
            $table->text('details')->nullable(false);
            $table->boolean('statutAnnulation')->default(false);
            $table->uuid('auteurCreation')->nullable(true);
            $table->uuid('auteurMiseAJour')->nullable(true);
            $table->timestamps();

            $table->foreign('paiement')->references('id')->on('finance_paiements')->cascadeOnDelete();
            $table->foreign('auteurCreation')->references('id')->on('systeme_utilisateurs')->nullOnDelete();
            $table->foreign('auteurMiseAJour')->references('id')->on('systeme_utilisateurs')->nullOnDelete();
        });

        Schema::create('marketing_marketeurs', function (Blueprint $table) {

            $table->uuid('id')->primary();
            $table->uuid('utilisateur')->nullable(false);
            $table->string('intitule')->nullable(true);
            $table->string('description')->nullable(true);
            $table->string('code')->nullable(true);
            $table->boolean('statutActivation')->default(true);
            $table->uuid('auteurCreation')->nullable(true);
            $table->uuid('auteurMiseAJour')->nullable(true);
            $table->timestamps();

            $table->foreign('utilisateur')->references('id')->on('systeme_utilisateurs')->cascadeOnDelete();
            $table->foreign('auteurCreation')->references('id')->on('systeme_utilisateurs')->nullOnDelete();
            $table->foreign('auteurMiseAJour')->references('id')->on('systeme_utilisateurs')->nullOnDelete();
        });

        Schema::create('marketing_paiements', function (Blueprint $table) {

            $table->uuid('id')->primary();
            $table->uuid('marketeur')->nullable(false);
            $table->unsignedSmallInteger('montant')->nullable(true);
            $table->text('details')->nullable(true);
            $table->text('statut')->nullable(true);
            $table->uuid('auteurCreation')->nullable(true);
            $table->uuid('auteurMiseAJour')->nullable(true);
            $table->timestamps();

            $table->foreign('marketeur')->references('id')->on('marketing_marketeurs')->cascadeOnDelete();
            $table->foreign('auteurCreation')->references('id')->on('systeme_utilisateurs')->nullOnDelete();
            $table->foreign('auteurMiseAJour')->references('id')->on('systeme_utilisateurs')->nullOnDelete();
        });

        Schema::create('marketing_ventes', function (Blueprint $table) {

            $table->uuid('id')->primary();
            $table->uuid('marketeur')->nullable(false);
            $table->uuid('paiement')->nullable(true);
            $table->unsignedSmallInteger('tauxCommission')->nullable(true);
            $table->unsignedSmallInteger('montantCommission')->nullable(true);
            $table->text('details')->nullable(true);
            $table->timestamps();

            $table->foreign('marketeur')->references('id')->on('marketing_marketeurs')->cascadeOnDelete();
            $table->foreign('paiement')->references('id')->on('marketing_paiements')->nullOnDelete();
        });
    }

    /**
     * Annule migrations.
     */
    public function down(): void
    {

        Schema::dropIfExists('marketing_ventes');
        Schema::dropIfExists('marketing_paiements');
        Schema::dropIfExists('marketing_marketeurs');
        Schema::dropIfExists('finance_remboursements');
        Schema::dropIfExists('finance_paiements');
        Schema::dropIfExists('finance_remises');
        Schema::dropIfExists('finance_biens');
        Schema::dropIfExists('finance_factures');
    }
};
