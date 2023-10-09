<?php

namespace Database\Seeders\Systeme;

use App\Models\Systeme\Utilisateur;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UtilisateurSeeder extends Seeder
{
    use WithoutModelEvents;

    const ID_SYSTEME_LOG = '04487226-96a1-4ecb-9b37-8bdd07e0b38e';

    public function run(): void
    {

        /**
         * Création des utilisateurs systèmes.
         */
        Utilisateur::create([
            'cheminPhotoProfil' => null,
            'nomUtilisateur' => 'systemeLog',
            'motDePasse' => Hash::make(Str::random()),
            'email' => 'systeme.log@competenceforall.com',
            'indicatifTelephonique' => null,
            'telephone' => null,
            'boitePostale' => null,
            'siteWeb' => null,
            'description' => 'Utilisateur non humain qui est responsable des enregistrements des activités sur la plateforme.',
            'typeUtilisateur' => 'organisation',
            'statutDoubleAuthentification' => false,
            'dateVerificationEmail' => null,
            'statutNotificationEmail' => true,
            'otp' => null,
            'dateExpirationOtp' => null,
            'dateProchaineTentativeOtp' => null,
            'dateVerificationTelephone' => null,
            'statutNotificationSms' => false,
            'dateDerniereConnexion' => null,
        ]);

        Utilisateur::create([
            'cheminPhotoProfil' => null,
            'nomUtilisateur' => 'systemeJob',
            'motDePasse' => Hash::make(Str::random()),
            'email' => 'systeme.job@competenceforall.com',
            'indicatifTelephonique' => null,
            'telephone' => null,
            'boitePostale' => null,
            'siteWeb' => null,
            'description' => 'Utilisateur non humain qui est responsable des tâches plannifiées sur la plateforme.',
            'typeUtilisateur' => 'organisation',
            'statutDoubleAuthentification' => false,
            'dateVerificationEmail' => null,
            'statutNotificationEmail' => true,
            'otp' => null,
            'dateExpirationOtp' => null,
            'dateProchaineTentativeOtp' => null,
            'dateVerificationTelephone' => null,
            'statutNotificationSms' => false,
            'dateDerniereConnexion' => null,
        ]);

        /**
         * Utilisateurs pour tester les offres d'emploi.
         */
        Utilisateur::factory()->createMany([
            [
                'cheminPhotoProfil' => null,
                'nomUtilisateur' => 'candidat-alpha',
                'motDePasse' => Hash::make('C@ndid@t-4lph4'),
                'email' => 'candidat.alpha@competenceforall.com',
                'indicatifTelephonique' => 1,
                'telephone' => 12345678,
                'boitePostale' => '01 BP 1234 12345 Ouagadougou, Burkina Faso',
                'siteWeb' => 'https://candidat.alpha.competenceforall.org',
                'description' => 'Utilisateur devant tenir le rôle de candidat de test 1.',
                'typeUtilisateur' => 'personne',
                'statutDoubleAuthentification' => false,
                'dateVerificationEmail' => null,
                'statutNotificationEmail' => true,
                'otp' => null,
                'dateExpirationOtp' => null,
                'dateProchaineTentativeOtp' => null,
                'dateVerificationTelephone' => null,
                'statutNotificationSms' => false,
                'dateDerniereConnexion' => null,
            ],
            [
                'cheminPhotoProfil' => null,
                'nomUtilisateur' => 'candidat-beta',
                'motDePasse' => Hash::make('C@ndid@t-bet4'),
                'email' => 'candidat.beta@competenceforall.com',
                'indicatifTelephonique' => 1,
                'telephone' => 22345678,
                'boitePostale' => '01 BP 2234 12345 Ouagadougou, Burkina Faso',
                'siteWeb' => 'https://candidat.beta.competenceforall.org',
                'description' => 'Utilisateur devant tenir le rôle de candidat de test 2.',
                'typeUtilisateur' => 'personne',
                'statutDoubleAuthentification' => false,
                'dateVerificationEmail' => null,
                'statutNotificationEmail' => true,
                'otp' => null,
                'dateExpirationOtp' => null,
                'dateProchaineTentativeOtp' => null,
                'dateVerificationTelephone' => null,
                'statutNotificationSms' => false,
                'dateDerniereConnexion' => null,
            ],
            [
                'cheminPhotoProfil' => null,
                'nomUtilisateur' => 'candidat-gamma',
                'motDePasse' => Hash::make('C@ndid@t-g4mm4'),
                'email' => 'candidat.gamma@competenceforall.com',
                'indicatifTelephonique' => 1,
                'telephone' => 32345678,
                'boitePostale' => '01 BP 3234 12345 Ouagadougou, Burkina Faso',
                'siteWeb' => 'https://candidat.gamma.competenceforall.org',
                'description' => 'Utilisateur devant tenir le rôle de candidat de test 3.',
                'typeUtilisateur' => 'personne',
                'statutDoubleAuthentification' => false,
                'dateVerificationEmail' => null,
                'statutNotificationEmail' => true,
                'otp' => null,
                'dateExpirationOtp' => null,
                'dateProchaineTentativeOtp' => null,
                'dateVerificationTelephone' => null,
                'statutNotificationSms' => false,
                'dateDerniereConnexion' => null,
            ],
            [
                'cheminPhotoProfil' => null,
                'nomUtilisateur' => 'roo-alpha',
                'motDePasse' => Hash::make('Respon@ble-4lph4'),
                'email' => 'roo.alpha@competenceforall.com',
                'indicatifTelephonique' => 1,
                'telephone' => 11345678,
                'boitePostale' => '01 BP 1134 12345 Ouagadougou, Burkina Faso',
                'siteWeb' => 'https://roo.alpha.competenceforall.org',
                'description' => 'Utilisateur devant tenir le rôle de reponsable de test 1.',
                'typeUtilisateur' => 'personne',
                'statutDoubleAuthentification' => false,
                'dateVerificationEmail' => null,
                'statutNotificationEmail' => true,
                'otp' => null,
                'dateExpirationOtp' => null,
                'dateProchaineTentativeOtp' => null,
                'dateVerificationTelephone' => null,
                'statutNotificationSms' => false,
                'dateDerniereConnexion' => null,
            ],
            [
                'cheminPhotoProfil' => null,
                'nomUtilisateur' => 'roo-beta',
                'motDePasse' => Hash::make('Respon@ble-bet4'),
                'email' => 'roo.beta@competenceforall.com',
                'indicatifTelephonique' => 1,
                'telephone' => 13345678,
                'boitePostale' => '01 BP 1334 12345 Ouagadougou, Burkina Faso',
                'siteWeb' => 'https://roo.beta.competenceforall.org',
                'description' => 'Utilisateur devant tenir le rôle de reponsable de test 2.',
                'typeUtilisateur' => 'personne',
                'statutDoubleAuthentification' => false,
                'dateVerificationEmail' => null,
                'statutNotificationEmail' => true,
                'otp' => null,
                'dateExpirationOtp' => null,
                'dateProchaineTentativeOtp' => null,
                'dateVerificationTelephone' => null,
                'statutNotificationSms' => false,
                'dateDerniereConnexion' => null,
            ],
        ]);

        // Générer des utilisateurs aléatoirement.
        Utilisateur::factory(10)->create();

        echo Utilisateur::count()." utilisateur(s) créé(s).\n";
    }
}
