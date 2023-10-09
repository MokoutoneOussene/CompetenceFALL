<?php

namespace App\Traits\Reponse;

use Exception;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

trait ReponseJsonTrait
{
    /**
     * Retourner une réponse HTTP Json.
     *
     *
     *
     * @param  bool  $typeReponse : TRUE = Succès, FALSE = Echec
     * @return JsonResponse $reponseHttp
     */
    protected static function ReponseJson(

        int $statutHttp,
        string $message,
        bool $typeReponse,
        array $contenu = [],
        array $enTetes = []

    ): JsonResponse {

        // Formattage du corps de la réponse.
        $reponse = [];
        $reponse['message'] = $message;
        if ($typeReponse == true) {
            $reponse['donnees'] = $contenu;
        } else {
            $reponse['erreurs'] = $contenu;
        }

        return response()->json(data: $reponse, status: $statutHttp, headers: $enTetes);
    }

    /**
     * Retourner une réponse HTTP Json de succès.
     *
     *
     *
     *
     *
     * @return JsonResponse $reponseHttp
     */
    protected static function ReponseJsonSucces(

        int $statutHttp = Response::HTTP_OK,
        string $message = 'La requête a été traitée avec succès.',
        array $donnees = [],
        array $enTetes = []

    ): JsonResponse {

        return self::ReponseJson(
            statutHttp: $statutHttp,
            message: $message,
            typeReponse: true,
            contenu: $donnees,
            enTetes: $enTetes
        );
    }

    /**
     * Retourner une réponse HTTP Json de succès pour une requête de création.
     *
     *
     *
     * @return JsonResponse $reponseHttp
     */
    protected static function ReponseJsonSuccesCreation(

        string $message = 'La ressource a été créée avec succès.',
        array $donnees = []

    ): JsonResponse {

        return self::ReponseJsonSucces(

            statutHttp: Response::HTTP_CREATED,
            message: $message,
            donnees: $donnees,
            enTetes: []
        );
    }

    /**
     * Retourner une réponse HTTP Json de succès pour une requête de visualisation.
     *
     *
     * @return JsonResponse $reponseHttp
     */
    protected static function ReponseJsonSuccesVisualisation(array $donnees): JsonResponse
    {

        return self::ReponseJsonSucces(

            statutHttp: Response::HTTP_OK,
            message: 'La ressource a été récupérée avec succès.',
            donnees: $donnees
        );
    }

    /**
     * Retourner une réponse HTTP Json de succès pour une requête de traitée mais pas de contenu.
     *
     *
     *
     * @return JsonResponse $reponseHttp
     */
    protected static function ReponseJsonSuccesSansContenu(

        string $message = 'La requête a été traitée avec succès, mais pas de contenu à retourner.',
        array $donnees = [],
        array $enTetes = []

    ): JsonResponse {

        return self::ReponseJsonSucces(

            statutHttp: Response::HTTP_ACCEPTED,
            message: $message,
            donnees: $donnees,
            enTetes: $enTetes
        );
    }

    /**
     * Retourner une réponse HTTP Json de succès pour une liste.
     *
     *
     *
     * @return JsonResponse $reponseHttp
     */
    protected static function ReponseJsonSuccesContenuPartiel(

        string $message = 'La requête a été traitée avec succès, une partie de la ressource est retourné.',
        array $donnees = []

    ): JsonResponse {

        return self::ReponseJsonSucces(

            statutHttp: Response::HTTP_PARTIAL_CONTENT,
            message: $message,
            donnees: $donnees,
            enTetes: []
        );
    }

    /**
     * Retourner une réponse HTTP Json de succès pour une mise à jour.
     *
     *
     *
     * @return JsonResponse $reponse
     */
    protected static function ReponseJsonSuccesMiseAJour(

        string $message = 'La ressource a été mise à jour avec succès.',
        array $donnees = []

    ): JsonResponse {

        return self::ReponseJsonSucces(

            statutHttp: Response::HTTP_OK,
            message: $message,
            donnees: $donnees,
            enTetes: []
        );
    }

    /**
     * Retourner une réponse HTTP Json de succès pour une suppression.
     *
     *
     * @param  array  $donnees
     * @return JsonResponse $reponse
     */
    protected static function ReponseJsonSuccesSuppression(

        string $message = 'La ressource a été supprimée avec succès.'

    ): JsonResponse {
        return response()->json(['message' => $message], Response::HTTP_OK);
    }

    /**
     * Retourner une réponse HTTP Json d'échec.
     *
     *
     *
     *
     * @return JsonResponse $reponseHttp
     */
    protected static function ReponseJsonEchec(

        int $statutHttp,
        string $message,
        array $erreurs = []

    ): JsonResponse {

        return self::ReponseJson(
            statutHttp: $statutHttp,
            message: $message,
            typeReponse: false,
            contenu: $erreurs
        );
    }

    /**
     * Retourner une réponse HTTP Json d'échec : Requêtes clientes.
     *
     *
     *
     *
     * @return JsonResponse $reponseHttp
     */
    protected static function ReponseJsonEchecClient(

        int $statutHttp = Response::HTTP_BAD_REQUEST,
        string $message = 'La requête est incorrecte ou ne peut pas être traitée.',
        array $erreurs = []

    ): JsonResponse {

        return self::ReponseJsonEchec(
            statutHttp: $statutHttp,
            message: $message,
            erreurs: $erreurs
        );
    }

    /**
     * Retourner une réponse HTTP Json d'échec pour ressource introuvavle.
     *
     *
     * @param  array  $erreurs
     * @return JsonResponse $reponseHttp
     */
    protected static function ReponseJsonEchecNonTrouve(

        string $message = 'La ressource est introuvable.'

    ): JsonResponse {

        return response()->json([

            'message' => $message,

        ], Response::HTTP_NOT_FOUND);
    }

    /**
     * Retourner une réponse HTTP Json d'échec pour problème de validation.
     *
     *
     *
     * @return JsonResponse $reponseHttp
     */
    protected static function ReponseJsonEchecValidation(

        string $message = 'Les entrées de la requête cliente ne peuvent pas être traitées.',
        array $erreurs = []

    ): JsonResponse {

        return self::ReponseJsonEchecClient(
            statutHttp: Response::HTTP_UNPROCESSABLE_ENTITY,
            message: $message,
            erreurs: $erreurs
        );
    }

    /**
     * Retourner une réponse HTTP Json d'échec : Erreurs serveurs.
     *
     * @param  int  $statutHttp
     * @param  array  $erreurs
     * @return JsonResponse $reponseHttp
     */
    protected static function ReponseJsonEchecServeur(

        Exception $exception,
        string $message = 'Le serveur a rencontré une erreur lors du traitement de la requête.'

    ): JsonResponse {

        $erreurs = env('APP_DEBUG') == true ? [
            'code' => $exception->getCode(),
            'message' => $exception->getMessage(),
            'trace' => $exception->getTrace(),
        ] : [];

        return self::ReponseJsonEchec(
            statutHttp: Response::HTTP_INTERNAL_SERVER_ERROR,
            message: $message,
            erreurs: $erreurs
        );
    }

    protected static function ReponseJsonEchecRessource()
    {

        return response()->json([
            'message' => 'Aucunne ressouce disponible.',
        ], Response::HTTP_NOT_FOUND);
    }

    protected static function ReponseJsonEchecAutorisation(string $message = "Vous n'êtres pas autorisé à éffectuer cette action sur ces ressources.")
    {

        return response()->json([
            'message' => $message,
        ], Response::HTTP_FORBIDDEN);
    }

    protected static function ReponseJsonEchecAuthentification(string $message = "Vous n'êtres pas authentifié.")
    {

        return response()->json([
            'message' => $message,
        ], Response::HTTP_UNAUTHORIZED);
    }
}
