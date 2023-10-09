<?php

namespace App\Http\Middleware\Compte;

use App\Models\Interface\Application;
use App\Traits\Reponse\ReponseJsonTrait;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AppCompteMiddleware
{
    use ReponseJsonTrait;

    /**
     * Visualer son compte application cliente de l'API.
     *
     *
     * @return JsonResponse $reponse
     */
    public function handle(Request $requete): JsonResponse
    {

        try {

            // Récupérer le jeton d'authentification.
            $cleApi = $requete->header(config('autorisation.application.jeton.nom'));

            // Récupérer les informations du jeton d'application.
            $application = Application::where('jeton', $cleApi)->first([
                'denomination',
                'statutActivation',
                'dateExpiration',
            ]);

            return self::ReponseJsonSucces(donnees: $application->toArray());

        } catch (Exception $e) {
            return self::ReponseJsonEchecServeur(exception: $e);
        }
    }
}
