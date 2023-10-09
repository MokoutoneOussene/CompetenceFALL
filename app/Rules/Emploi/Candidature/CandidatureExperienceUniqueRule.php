<?php

namespace App\Rules\Emploi\Candidature;

use App\Models\Emploi\CandidatureExperience;
use Closure;
use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Contracts\Validation\ValidationRule;

class CandidatureExperienceUniqueRule implements DataAwareRule, ValidationRule
{
    private $donnees = [];

    /**
     * Règle de validation pour qu'un candidat ne postule pas deux fois à la même offre d'emploi.
     */
    public function validate(string $attribut, mixed $valeur, Closure $echec): void
    {

        if (CandidatureExperience::where([
            ['candidature', $this->donnees['candidature']],
            ['experience', $this->donnees['experience']],
        ])->exists()

        ) {
            $echec('Vous avez déjà joint cette expérience professionnelle à cette candidature.');
        }
    }

    public function setData(array $donnees): static
    {
        $this->donnees = $donnees;

        return $this;
    }
}
