<?php

namespace App\Rules\Systeme\Organisation;

use App\Models\Systeme\Organisation;
use Closure;
use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Contracts\Validation\ValidationRule;

class IdentifiantUniqueRule implements DataAwareRule, ValidationRule
{
    protected $donnees = [];

    /**
     * Régle de validation pour l'unicité de la dénominiation pour les entreprises dans un même pays.
     */
    public function validate(string $attribut, mixed $valeur, Closure $echec): void
    {

        if (Organisation::where([
            ['identifiant', $this->donnees['identifiant']],
            ['paysSiege', $this->donnees['paysSiege']],
        ])->exists()

        ) {
            $echec('La valeur selectionnée pour identifiant est déjà prise dans votre pays.');
        }
    }

    public function setData(array $donnees): static
    {
        $this->donnees = $donnees;

        return $this;
    }
}
