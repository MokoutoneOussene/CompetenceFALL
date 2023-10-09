<?php

namespace App\Http\Controllers\Can;

use App\Http\Controllers\Controller;
use App\Models\Emploi\CandidatCv;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\UnauthorizedException;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class CanCvController extends Controller
{
	/**
	 * Uploader un cv.
	 */
	public function uploader(Request $requete): JsonResponse
	{
		try {

			// Récupérer l'entrée.
			$cv = $requete->only(['cv']);

			// Valider les entrées.
			$validateur = Validator::make(
				['cv' => $requete->cv],
				['cv' => 'required|file|max:10240|mimes:pdf,doc,docx']
			);

			if ($validateur->fails()) {
				return parent::ReponseJsonEchecValidation(erreurs: $validateur->errors()->toArray());
			}

			// Vérifier le fichier a pu être chargé.
			if ($requete->hasFile('cv')) {
				$cheminCv = $requete->file('cv')->store('utilisateurs/cvs');
			} else {
				return parent::ReponseJsonEchecValidation();
			}

			// Créer une nouvelle candidature.
			if (isset($cheminCv)) {
				$cv = CandidatCv::create([
					'intitule' => 'nomUtilisateur'.rand(1, 10),
					'chemin' => $cheminCv,
				]);
			}

			// Raffraichir le modèle.
			$cv->refresh();

			return parent::ReponseJsonSuccesCreation(donnees: $cv->toArray());
		} catch (Exception $e) {
			return parent::ReponseJsonEchecServeur(exception: $e);
		}
	}

	/**
	 * Lister ses cvs.
	 *
	 *
	 * @return JsonResponse $reponse
	 */
	public function lister(Request $requete): JsonResponse
	{

		try {

			// Récupérer l'utlisateur.
			$utilisateur = $requete->utilisateur;

			$cvs = CandidatCv::where('utilisateur', $utilisateur->id)->orderBy('intitule')->get();

			if ($cvs->isEmpty()) {
				return parent::ReponseJsonEchecRessource();
			}

			return parent::ReponseJsonSucces(donnees: $cvs->toArray());
		} catch (ModelNotFoundException $e) {
			return parent::ReponseJsonEchecNonTrouve();
		} catch (Exception $e) {
			return parent::ReponseJsonEchecServeur(exception: $e);
		}
	}

	/**
	 * Downloader un cv.
	 */
	public function downloader(Request $requete, string $id): BinaryFileResponse|JsonResponse
	{

		try {

			// Rechercher le CV par son identifiant.
			$cv = CandidatCv::findOrFail($id);

			// Récupérer l'utilisateur.
			$utilisateur = $requete->utilisateur;

			// Vérifier les autorisations.
			$porte = Gate::forUser($utilisateur);

			if ($porte->denies('proprietaire-modele', $cv)) {
				throw new UnauthorizedException();
			}

			// Obtenir le chemin du fichier CV.
			$cheminCv = storage_path('app/'.$cv->chemin);

			// Vérifier si le fichier existe.
			if (! file_exists($cheminCv)) {
				return parent::ReponseJsonEchecRessource();
			}

			// Télécharger le fichier CV en tant que réponse.
			return response()->download($cheminCv, $cv->intitule.'.pdf');
		} catch (ModelNotFoundException $e) {
			return parent::ReponseJsonEchecNonTrouve();
		} catch (UnauthorizedException $e) {
			return parent::ReponseJsonEchecAutorisation();
		} catch (Exception $e) {
			return parent::ReponseJsonEchecServeur(exception: $e);
		}
	}

	/**
	 * Supprimer une candidature.
	 */
	public function supprimer(Request $requete, string $id): JsonResponse
	{
		try {

			// Rechercher le CV par son identifiant
			$cv = CandidatCv::findOrFail($id);

			// Récupérer l'utilisateur.
			$utilisateur = $requete->utilisateur;

			// Vérifier les autorisations.
			$porte = Gate::forUser($utilisateur);

			if ($porte->denies('proprietaire-modele', $cv)) {
				throw new UnauthorizedException();
			}

			// Supprimer le fichier CV s'il existe
			if (file_exists(storage_path('app/'.$cv->chemin))) {
				unlink(storage_path('app/'.$cv->chemin));
			}

			// Supprimer le CV de la base de données
			$cv->delete();

			return parent::ReponseJsonSuccesSuppression();
		} catch (ModelNotFoundException $e) {
			return parent::ReponseJsonEchecNonTrouve();
		} catch (UnauthorizedException $e) {
			return parent::ReponseJsonEchecAutorisation();
		} catch (Exception $e) {
			return parent::ReponseJsonEchecServeur(exception: $e);
		}
	}
}
