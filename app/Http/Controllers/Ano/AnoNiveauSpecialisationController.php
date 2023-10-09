<?php

namespace App\Http\Controllers\Ano;

use App\Http\Controllers\Controller;
use App\Models\Emploi\NiveauSpecialisation;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AnoNiveauSpecialisationController extends Controller
{
    /**
     * Lister les niveaux de spécialisation.
     *
     *
     * @return JsonResponse $reponse
     */
    public function lister(Request $requete): JsonResponse
    {

        try {

            $niveauxSpecialisations = NiveauSpecialisation::orderBy('niveau')->get();

            if ($niveauxSpecialisations->isEmpty()) {
                return parent::ReponseJsonEchecRessource();
            }

            return parent::ReponseJsonSucces(donnees: $niveauxSpecialisations->toArray());
        } catch (Exception $e) {
            return parent::ReponseJsonEchecServeur(exception: $e);
        }
    }
}
