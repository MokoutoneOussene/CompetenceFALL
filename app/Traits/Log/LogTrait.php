<?php

namespace App\Traits\Log;

use App\Jobs\Systeme\Log\EnregistrerActiviteJob;
use App\Models\Systeme\Utilisateur;
use Exception;

trait LogTrait
{
    /**
     * Enregistre une activité de création.
     *
     *
     *
     *
     *
     * @return bool $reponse
     *
     * @throws Exception $e
     */
    public static function enregistrerCreation(Utilisateur $utilisateur, array $entrees, string $model, string $id): bool
    {

        try {

            EnregistrerActiviteJob::dispatch([
                'utilisateur' => $utilisateur->id,
                'action' => "Création d'une instance de : ".$model,
                'date' => now()->format('Y-m-d H:i:s'),
                'champs' => json_encode($entrees),
                'details' => $model.' : '.$id.' a été créé avec succès.',
            ]);

            return true;
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Enregistre une activité de mise à jour.
     *
     *
     *
     *
     *
     * @return bool $reponse
     *
     * @throws Exception $e
     */
    public static function enregistrerMiseAJour(Utilisateur $utilisateur, array $entrees, string $model, string $id): bool
    {

        try {

            EnregistrerActiviteJob::dispatch([
                'utilisateur' => $utilisateur->id,
                'action' => "Mise à jour d'une instance de : ".$model,
                'date' => now()->format('Y-m-d H:i:s'),
                'champs' => json_encode($entrees),
                'details' => $model.' : '.$id.' a été mis à jour avec succès.',
            ]);

            return true;
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Enregistre une activité de suppression.
     *
     *
     *
     *
     * @return bool $reponse
     *
     * @throws Exception $e
     */
    public static function enregistrerSuppression(Utilisateur $utilisateur, string $model, string $id): bool
    {

        try {

            EnregistrerActiviteJob::dispatch([
                'utilisateur' => $utilisateur->id,
                'action' => "Suprression d'une instance de : ".$model,
                'date' => now()->format('Y-m-d H:i:s'),
                'champs' => null,
                'details' => $model.' : '.$id.' a été supprimé avec succès.',
            ]);

            return true;
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Enregistre une activité d'archivage.
     *
     *
     *
     * @return bool $reponse
     *
     * @throws Exception $e
     */
    public static function enregistrerArchivage(Utilisateur $utilisateur, string $model): bool
    {

        try {

            EnregistrerActiviteJob::dispatch([
                'utilisateur' => $utilisateur->id,
                'action' => 'Archivage des instances de : '.$model,
                'date' => now()->format('Y-m-d H:i:s'),
                'champs' => null,
                'details' => "L'archivage des instances de (".$model.') a été exécuté avec succès.',
            ]);

            return true;
        } catch (Exception $e) {
            throw $e;
        }
    }
}
