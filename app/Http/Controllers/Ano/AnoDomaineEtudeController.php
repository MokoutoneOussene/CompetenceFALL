<?php

namespace App\Http\Controllers\Ano;

use App\Http\Controllers\Controller;
use App\Models\Emploi\DomaineEtude;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AnoDomaineEtudeController extends Controller
{
    /**
     * Lister les domaines d'études.
     *
     *
     * @return JsonResponse $reponse
     */
    public function lister(Request $requete): JsonResponse
    {
        try {

            $domainesEtudes = DomaineEtude::orderBy('intitule')->get();

            if ($domainesEtudes->isEmpty()) {
                return parent::ReponseJsonEchecRessource();
            }

            return parent::ReponseJsonSucces(donnees: $domainesEtudes->toArray());
        } catch (Exception $e) {
            return parent::ReponseJsonEchecServeur(exception: $e);
        }
    }
}
