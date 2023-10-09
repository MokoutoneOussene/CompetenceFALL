<?php

namespace App\Http\Middleware\Compte;

use App\Models\Interface\Application;
use App\Traits\Reponse\ReponseJsonTrait;
use Closure;
use Exception;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AppAuthentificationMiddleware
{
    use ReponseJsonTrait;

    /**
     * Authentifier les applications tierces.
     *
     *
     *
     * @return Response $next
     */
    public function handle(Request $requete, Closure $suivant): Response
    {

        try {

            // Récupérer le jeton d'authentification.
            $cleApi = $requete->header(config('autorisation.application.jeton.nom'));

            // Valider le jeton d'authentification.
            $application = Application::where('jeton', $cleApi)->first();

            // Si la valeur du jeton est incorrecte.
            if ($application === null) {
                return self::ReponseJsonEchecValidation(erreurs: [
                    config('autorisation.application.jeton.nom') => "Cette clé d'authentification est invalide.",
                ]);
            }

            // Vérifier la validité de la application.
            if (! $application->verifierJeton()) {

                return self::ReponseJsonEchecValidation(erreurs: [
                    config('autorisation.application.jeton.nom') => "Cette clé d'authentification a expirée.",
                ]);
            }

            // Vérifier le statut d'activation.
            if ($application->statutActivation == false) {

                return self::ReponseJsonEchecValidation(erreurs: [
                    config('autorisation.application.jeton.nom') => "Cette clé d'authentification est désactivée.",
                ]);
            }

            return $suivant($requete);

        } catch (Exception $e) {
            return self::ReponseJsonEchecServeur(exception: $e);
        }
    }
}
