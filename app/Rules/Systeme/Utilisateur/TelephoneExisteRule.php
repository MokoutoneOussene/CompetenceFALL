<?php

namespace App\Rules\Systeme\Utilisateur;

use App\Models\Systeme\Utilisateur;
use Closure;
use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Contracts\Validation\ValidationRule;

class TelephoneExisteRule implements DataAwareRule, ValidationRule
{
    protected $donnees = [];

    /**
     * Régle de validation pour l'existence des numéros de téléphone.
     */
    public function validate(string $attribut, mixed $valeur, Closure $echec): void
    {

        if (Utilisateur::where([
            ['telephone', $this->donnees['telephone']],
            ['indicatifTelephonique', $this->donnees['indicatifTelephonique']],
        ])->exists()

        ) {
            $echec("La valeur selectionnée pour téléphone n'existe pas.");
        }
    }

    public function setData(array $donnees): static
    {
        $this->donnees = $donnees;

        return $this;
    }
}
