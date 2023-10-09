<?php

namespace App\Rules\Emploi\Candidature;

use App\Models\Emploi\Candidature;
use Closure;
use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Contracts\Validation\ValidationRule;

class CandidatureUniqueRule implements DataAwareRule, ValidationRule
{
    private $donnees = [];

    /**
     * Règle de validation pour qu'un candidat ne postule pas deux fois à la même offre d'emploi.
     */
    public function validate(string $attribut, mixed $valeur, Closure $echec): void
    {

        if (Candidature::where([
            ['utilisateur', $this->donnees['utilisateur']],
            ['offre', $this->donnees['offre']],
        ])->exists()

        ) {
            $echec("Vous avez déjà postuler à cette offre d'emploi.");
        }
    }

    public function setData(array $donnees): static
    {
        $this->donnees = $donnees;

        return $this;
    }
}
