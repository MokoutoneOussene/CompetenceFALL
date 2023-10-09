<?php

namespace App\Rules\Systeme\Utilisateur;

use App\Models\Systeme\Utilisateur;
use Closure;
use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Contracts\Validation\ValidationRule;

class TelephoneUniqueRule implements DataAwareRule, ValidationRule
{
    protected $donnees = [];

    /**
     * Régle de validation pour l'unicité des numéros de téléphone.
     */
    public function validate(string $attribut, mixed $valeur, Closure $echec): void
    {

        if (Utilisateur::where([
            ['telephone', $this->donnees['telephone']],
            ['indicatifTelephonique', $this->donnees['indicatifTelephonique']],
        ])->exists()

        ) {
            $echec('La valeur sélectionner pour le téléphone a déjà été pris.');
        }
    }

    public function setData(array $donnees): static
    {
        $this->donnees = $donnees;

        return $this;
    }
}
