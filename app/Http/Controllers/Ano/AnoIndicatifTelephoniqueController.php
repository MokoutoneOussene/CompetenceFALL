<?php

namespace App\Http\Controllers\Ano;

use App\Http\Controllers\Controller;
use App\Models\Systeme\IndicatifTelephonique;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AnoIndicatifTelephoniqueController extends Controller
{
    /**
     * Lister les indicatifs téléphoniques.
     *
     * @param  Request  $requete
     * @return JsonResponse $reponse
     */
    public function lister(): JsonResponse
    {
        try {

            $indicatifsTelephoniques = IndicatifTelephonique::with('pays')->orderBy('valeur')->get();

            if ($indicatifsTelephoniques->isEmpty()) {
                return parent::ReponseJsonEchecRessource();
            }

            return parent::ReponseJsonSucces(donnees: $indicatifsTelephoniques->toArray());
        } catch (Exception $e) {
            return parent::ReponseJsonEchecServeur(exception: $e);
        }
    }
}
