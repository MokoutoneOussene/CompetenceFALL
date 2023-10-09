<?php

namespace App\Rules\Emploi\Candidature;

use App\Models\Emploi\CandidatureReponse;
use Closure;
use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Contracts\Validation\ValidationRule;

class CandidatureReponseUniqueRule implements DataAwareRule, ValidationRule
{
    private $donnees = [];

    /**
     * Règle de validation pour qu'un candidat ne postule pas deux fois à la même offre d'emploi.
     */
    public function validate(string $attribut, mixed $valeur, Closure $echec): void
    {

        if (CandidatureReponse::where([
            ['candidature', $this->donnees['candidature']],
            ['question', $this->donnees['question']],
        ])->exists()

        ) {
            $echec('Vous avez déjà répondu à cette question pour cette candidature.');
        }
    }

    public function setData(array $donnees): static
    {
        $this->donnees = $donnees;

        return $this;
    }
}
