<?php

namespace App\Rules\Emploi\Candidature;

use App\Models\Emploi\CandidatureCertificat;
use Closure;
use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Contracts\Validation\ValidationRule;

class CandidatureCertificatUniqueRule implements DataAwareRule, ValidationRule
{
    private $donnees = [];

    /**
     * Règle de validation pour qu'un candidat ne postule pas deux fois à la même offre d'emploi.
     */
    public function validate(string $attribut, mixed $valeur, Closure $echec): void
    {

        if (CandidatureCertificat::where([
            ['candidature', $this->donnees['candidature']],
            ['certificat', $this->donnees['certificat']],
        ])->exists()

        ) {
            $echec('Vous avez déjà joint ce certificat à cette candidature.');
        }
    }

    public function setData(array $donnees): static
    {
        $this->donnees = $donnees;

        return $this;
    }
}
