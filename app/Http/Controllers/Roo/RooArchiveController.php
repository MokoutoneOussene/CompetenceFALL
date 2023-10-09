<?php

namespace App\Http\Controllers\Roo;

use App\Http\Controllers\Controller;
use App\Models\Emploi\Archive;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class RooArchiveController extends Controller
{
     /**
     * Créer une nouvelle archive.
     */
    public function creer(Request $requete, string $id): JsonResponse
    {
        try {

            // Récupération des entrées.
            $entrees = ['offre' => $id ];

            // Valider les entrées.
            $validateur = Validator::make($entrees, [
                'offre' => 'required|exists:emploi_offre_emplois,id'
            ]);

            // Retourner un réponse d'échec des validations.
            if ($validateur->fails()) {
                return parent::ReponseJsonEchecValidation(erreurs: $validateur->errors()->toArray());
            }

            // Récupérer l'utilisateur.
            $utilisateur = $requete->utilisateur;

            // Ajouter l'utilisateur comme auteurCreation.
            $entrees['utilisateur'] = $utilisateur->id;

            // Créer une nouvelle convocation.
            $archive = Archive::create($entrees);

			$archive->refresh();

			$archive = Archive::where('id', $archive->id)->first(['id', 'utilisateur', 'created_at']);

            return parent::ReponseJsonSuccesCreation(message: "Création de l'archive en cours...", donnees: $archive->toArray());
        }

		catch (Exception $e) {
            return parent::ReponseJsonEchecServeur(exception: $e);
        }
    }

    /**
     * Lister les archives.
     *
     * @return JsonResponse $reponse
     */
    public function voir(string $id): JsonResponse
    {

        try {

            $archive = Archive::findOrFail($id);

			return parent::ReponseJsonSucces(donnees: $archive->toArray());
        }

		catch (Exception $e) {

            return parent::ReponseJsonEchecServeur(exception: $e);
        }
    }

	/**
     * Lister les archives.
     */
    public function telecharger(string $id)
    {
        try {

            $archive = Archive::findOrFail($id);

			return Storage::download($archive->chemin);
        }

		catch (Exception $e) {
            return parent::ReponseJsonEchecServeur(exception: $e);
        }
    }

	/**
     * Lister les archives.
     *
     * @return JsonResponse $reponse
     */
    public function lister(): JsonResponse
    {
        try {

            // Rétourner la liste des convocations.

			if(Archive::count())
            	return parent::ReponseJsonSucces(donnees: Archive::all()->toArray());

			else return parent::ReponseJsonEchecRessource();
        }

		catch (Exception $e) {
            return parent::ReponseJsonEchecServeur(exception: $e);
        }
    }
}
