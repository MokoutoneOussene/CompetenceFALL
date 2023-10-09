<?php

namespace App\Http\Middleware\Compte;

use App\Models\Systeme\Session;
use App\Traits\Reponse\ReponseJsonTrait;
use Carbon\Carbon;
use Closure;
use Exception;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ComAuthentificationMiddleware
{
    use ReponseJsonTrait;

    /**
     * Authentifier les utilisateurs de l'API.
     *
     *
     *
     * @return Response $next
     */
    public function handle(Request $requete, Closure $suivant): Response
    {

        try {

            // Récupérer le jeton d'authentification.
            $cleUti = $requete->header(config('autorisation.utilisateur.jeton.nom'));

            // Valider le jeton d'authentification.
            $session = Session::where('jeton', $cleUti)->with('utilisateur')->first();

            // Si la valeur du jeton est incorrecte.
            if ($session === null) {
                return self::ReponseJsonEchecValidation(erreurs: [
                    config('autorisation.utilisateur.jeton.nom') => "Cette clé d'authentification est invalide.",
                ]);
            }

            // Vérifier la validité de la session.
            if (! $session->verifierJeton()) {

                $dateExpiration = $session->dateExpiration;

                $session->delete();

                return self::ReponseJsonEchecValidation(erreurs: [
                    config('autorisation.utilisateur.jeton.nom') => "Cette clé d'authentification a expirée.",
                ]);
            }

            // Vérifier si l'utilisateur a des blocages.
            $utilisateur = $session->utilisateur()->with('blocages')->first();

            if ($utilisateur->blocages()->where('statutActivation', true)->exists()) {

                // Vider les sessions de l'utilisateur.
                $utilisateur->sessions()->delete();

                // Vérifier les blocages administrateurs.
                if ($utilisateur->blocages()->where([
                    ['statutActivation', true],
                    ['statutDeblocable', false],
                ])->exists()) {
                    return self::ReponseJsonEchecAutorisation(message: "Ce compte a été bloqué par l'administration.");
                }

                // Vérifier les blocages automatiques.
                if ($utilisateur->blocages()->where([
                    ['statutActivation', true],
                    ['statutDeblocable', true],
                ])->exists()) {
                    return self::ReponseJsonEchecAutorisation(message: 'Ce compte a été bloqué suite à trop de tentatives infructueuses.');
                }
            }

            // Raffraichir la date d'expiration de la session.
            $session->update(['dateExpiration' => Carbon::parse(now())->addWeeks(2)->format('Y-m-d H:i:s')]);

            // Ajouter l'utilisateur à la suite de la requête
            unset($utilisateur->blocages);
            $requete->merge(['utilisateur' => $utilisateur]);

            return $suivant($requete);

        } catch (Exception $e) {
            return self::ReponseJsonEchecServeur(exception: $e);
        }
    }
}
