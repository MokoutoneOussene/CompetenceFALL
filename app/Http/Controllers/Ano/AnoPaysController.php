<?php

namespace App\Http\Controllers\Ano;

use App\Http\Controllers\Controller;
use App\Models\Systeme\Pays;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AnoPaysController extends Controller
{
    /**
     * Lister les pays.
     *
     *
     * @return JsonResponse $reponse
     */
    public function lister(Request $requete): JsonResponse
    {

        try {

            $pays = Pays::orderBy('nom')->get();

            if ($pays->isEmpty()) {
                return parent::ReponseJsonEchecRessource();
            }

            return parent::ReponseJsonSucces(donnees: $pays->toArray());
        } catch (Exception $e) {
            return parent::ReponseJsonEchecServeur(exception: $e);
        }
    }
}
