<?php

namespace App\Rules\Emploi\Candidature;

use App\Models\Emploi\CandidatureCompetence;
use Closure;
use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Contracts\Validation\ValidationRule;

class CandidatureCompetenceUniqueRule implements DataAwareRule, ValidationRule
{
    private $donnees = [];

    /**
     * Règle de validation pour qu'un candidat ne postule pas deux fois à la même offre d'emploi.
     */
    public function validate(string $attribut, mixed $valeur, Closure $echec): void
    {

        if (CandidatureCompetence::where([
            ['candidature', $this->donnees['candidature']],
            ['competence', $this->donnees['competence']],
        ])->exists()

        ) {
            $echec('Vous avez déjà joint cette compétence à cette candidature.');
        }
    }

    public function setData(array $donnees): static
    {
        $this->donnees = $donnees;

        return $this;
    }
}
