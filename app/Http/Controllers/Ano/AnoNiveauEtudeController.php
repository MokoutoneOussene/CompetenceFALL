<?php

namespace App\Http\Controllers\Ano;

use App\Http\Controllers\Controller;
use App\Models\Emploi\NiveauEtude;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AnoNiveauEtudeController extends Controller
{
    /**
     * Lister les niveaux d'études.
     *
     *
     * @return JsonResponse $reponse
     */
    public function lister(Request $requete): JsonResponse
    {
        try {

            $niveauxEtudes = NiveauEtude::orderBy('niveau')->get();

            if ($niveauxEtudes->isEmpty()) {
                return parent::ReponseJsonEchecRessource();
            }

            return parent::ReponseJsonSucces(donnees: $niveauxEtudes->toArray());
        } catch (Exception $e) {
            return parent::ReponseJsonEchecServeur(exception: $e);
        }
    }
}
