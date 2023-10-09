<?php

namespace App\Rules\Emploi\Candidature;

use App\Models\Emploi\CandidatureLangue;
use Closure;
use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Contracts\Validation\ValidationRule;

class CandidatureLangueUniqueRule implements DataAwareRule, ValidationRule
{
    private $donnees = [];

    /**
     * Règle de validation pour qu'un candidat ne postule pas deux fois à la même offre d'emploi.
     */
    public function validate(string $attribut, mixed $valeur, Closure $echec): void
    {

        if (CandidatureLangue::where([
            ['candidature', $this->donnees['candidature']],
            ['langue', $this->donnees['langue']],
        ])->exists()

        ) {
            $echec('Vous avez déjà joint cette langue à cette candidature.');
        }
    }

    public function setData(array $donnees): static
    {
        $this->donnees = $donnees;

        return $this;
    }
}
