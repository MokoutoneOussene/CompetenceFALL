<?php

namespace App\Http\Middleware\Compte;

use App\Traits\Reponse\ReponseJsonTrait;
use Closure;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class ComAutorisationMiddleware
{
    use ReponseJsonTrait;

    /**
     * Autoriser les utilisateurs en fonction des routes.
     *
     *
     *
     * @return Response $next
     */
    public function handle(Request $requete, Closure $suivant): Response
    {

        try {

            // Récupérer l'utilisateur.
            $utilisateur = $requete->utilisateur;

            // Initialiser la porte de vérification.
            $porte = Gate::forUser($utilisateur);

            // Récupérer le nom de la route.
            $route = $requete->route()->getName();

            // ZONE DE VERIFICATION EN FONCTION DE LA ROUTE
            /*------------------------------------------------------------------------*/

            // Roo
            if (Str::startsWith($route, 'cfai.roo.') && $porte->denies('responsable-roo')) {
                throw new Exception(code: Response::HTTP_FORBIDDEN);
            }

            // Can
            if(Str::startsWith($route, "cfai.can.") && $porte->denies('personne-physique')) throw new Exception(code: Response::HTTP_FORBIDDEN);

            /*------------------------------------------------------------------------*/
            // FIN DE LA ZONE DE VERIFICATION EN FONCTION DE LA ROUTE

            // Ajouter l'instance de l'utilisateur connecté à la suite des traitements.
            $requete->merge(['utilisateur' => $utilisateur]);

            return $suivant($requete);
        } catch (Exception $e) {

            if ($e->getCode() == Response::HTTP_FORBIDDEN) {

                return self::ReponseJsonEchecAutorisation("Vous n'avez pas les permissions pour cette ressource/route.");

            } else {
                return self::ReponseJsonEchecServeur(exception: $e);
            }
        }
    }
}
