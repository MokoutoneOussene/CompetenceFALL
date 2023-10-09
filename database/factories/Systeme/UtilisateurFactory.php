<?php

namespace Database\Factories\Systeme;

use App\Models\Systeme\IndicatifTelephonique;
use App\Models\Systeme\Utilisateur;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UtilisateurFactory extends Factory
{
    protected $model = Utilisateur::class;

    public function definition()
    {

        $typeUtilisateur = $this->faker->randomElement(['personne', 'organisation']);

        $nomUtilisateur = $typeUtilisateur == 'personne' ? Str::ascii(Str::lower($this->faker->lastName().'.'.$this->faker->firstName())) :
            Str::ascii(Str::replace(' ', '.', Str::lower($this->faker->unique()->company())));

        $motDePasse = Hash::make($nomUtilisateur);

        $telephone = $this->faker->randomElement([
            substr(Str::replace([' ', '-', '+', '(', ')'], '', $this->faker->phoneNumber()), 0, rand(8, 10)), null,
        ]);

        $indicatifTelephonique = $telephone == null ? null : IndicatifTelephonique::inRandomOrder()->first(['valeur'])->valeur;

        $created_at = Carbon::parse($this->faker->dateTimeBetween('-4 years', '-6 months'))->format('Y-m-d H:i:s');

        $dateVerificationEmail = Carbon::parse($this->faker->dateTimeBetween($created_at, 'now'))->format('Y-m-d H:i:s');

        $statutDoubleAuthentification = $dateVerificationEmail == null ? false :
            $this->faker->boolean();

        $statutNotificationEmail = $dateVerificationEmail == null ? false :
            $this->faker->boolean();

        $otp = $telephone == null ? null : sprintf('%06d', mt_rand(10000, 999999));

        $dateExpirationOtp = $otp == null ? null : Carbon::parse($this->faker->dateTimeBetween($created_at, 'now'))->format('Y-m-d H:i:s');

        $dateProchaineTentativeOtp = $dateExpirationOtp == null ? null :
            Carbon::parse($dateExpirationOtp)->addMinutes(Utilisateur::DUREE_TENTATIVE_OTP)->format('Y-m-d H:i:s');

        $dateVerificationTelephone = $telephone == null ? null :
            Carbon::parse($this->faker->randomElement([$created_at, now()]))->format('Y-m-d H:i:s');

        $statutNotificationSms = $dateVerificationTelephone == null ? false : $this->faker->boolean();

        return [

            'cheminPhotoProfil' => 'app/utilisateurs/photoProfils/defaut.png',
            'nomUtilisateur' => $nomUtilisateur,
            'motDePasse' => $motDePasse,
            'email' => $nomUtilisateur.'@competenceforall.com',
            'indicatifTelephonique' => $indicatifTelephonique,
            'telephone' => $telephone,
            'siteWeb' => 'https://www.'.$nomUtilisateur.$this->faker->randomElement(['.com', '.net', '.org']),
            'description' => $this->faker->paragraph(1, false),
            'typeUtilisateur' => $typeUtilisateur,
            'statutDoubleAuthentification' => $statutDoubleAuthentification,
            'dateVerificationEmail' => $dateVerificationEmail,
            'statutNotificationEmail' => $statutNotificationEmail,
            'otp' => $otp,
            'dateExpirationOtp' => $dateExpirationOtp,
            'dateProchaineTentativeOtp' => $dateProchaineTentativeOtp,
            'dateVerificationTelephone' => $dateVerificationTelephone,
            'statutNotificationSms' => $statutNotificationSms,
            'dateDerniereConnexion' => $this->faker->dateTimeThisMonth()->format('Y-m-d H:i:s'),
        ];
    }
}
