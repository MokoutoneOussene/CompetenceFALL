<?php

namespace App\Rules\Emploi\Candidature;

use App\Models\Emploi\CandidatureCentre;
use Closure;
use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Contracts\Validation\ValidationRule;

class CandidatureCentreUniqueRule implements DataAwareRule, ValidationRule
{
    private $donnees = [];

    /**
     * Règle de validation pour qu'un candidat ne postule pas deux fois à la même offre d'emploi.
     */
    public function validate(string $attribut, mixed $valeur, Closure $echec): void
    {

        if (CandidatureCentre::where([
            ['candidature', $this->donnees['candidature']],
            ['centre', $this->donnees['centre']],
        ])->exists()

        ) {
            $echec("Vous avez déjà joint ce centre d'intérêt à cette candidature.");
        }
    }

    public function setData(array $donnees): static
    {
        $this->donnees = $donnees;

        return $this;
    }
}
