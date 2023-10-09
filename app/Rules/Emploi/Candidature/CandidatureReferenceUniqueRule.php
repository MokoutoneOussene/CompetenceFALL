<?php

namespace App\Rules\Emploi\Candidature;

use App\Models\Emploi\CandidatureReference;
use Closure;
use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Contracts\Validation\ValidationRule;

class CandidatureReferenceUniqueRule implements DataAwareRule, ValidationRule
{
    private $donnees = [];

    /**
     * Règle de validation pour qu'un candidat ne postule pas deux fois à la même offre d'emploi.
     */
    public function validate(string $attribut, mixed $valeur, Closure $echec): void
    {

        if (CandidatureReference::where([
            ['candidature', $this->donnees['candidature']],
            ['reference', $this->donnees['reference']],
        ])->exists()

        ) {
            $echec('Vous avez déjà joint cette personne de référence à cette candidature.');
        }
    }

    public function setData(array $donnees): static
    {
        $this->donnees = $donnees;

        return $this;
    }
}
