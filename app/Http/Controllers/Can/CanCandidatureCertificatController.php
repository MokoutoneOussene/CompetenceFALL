<?php

namespace App\Http\Controllers\Can;

use App\Http\Controllers\Controller;
use App\Models\Emploi\CandidatCertificat;
use App\Models\Emploi\Candidature;
use App\Models\Emploi\CandidatureCertificat;
use App\Rules\Emploi\Candidature\CandidatureCertificatUniqueRule;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\UnauthorizedException;

class CanCandidatureCertificatController extends Controller
{
    /**
     * Ajouter un certificat à sa candidature.
	 *
	 * @param Request $requete
	 *
	 * @return JsonResponse $reponse
     */
    public function lier(Request $requete): JsonResponse
    {
        try {

            // Récupérer les entrées.
            $entrees = Arr::only($requete->json()->all(), [
                'candidature',
                'certificat'
            ]);

            // Valider les entrées.
            $validateur = Validator::make($entrees, [
                'candidature' => 'required|exists:emploi_candidatures,id',
                'certificat' => [
                    'required',
                    'exists:emploi_candidat_certificats,id',
                    new CandidatureCertificatUniqueRule,
                ],
            ]);

            // Retourner un message d'échec des validations.
            if ($validateur->fails()) {
                return parent::ReponseJsonEchecValidation(erreurs: $validateur->errors()->toArray());
            }

            // Récupérer l'utilisateur.
            $utilisateur = $requete->utilisateur;

            // Récupérer la candidature.
            $candidature = Candidature::find($entrees['candidature']);

            // Vérifier les autorisations.
            $porte = Gate::forUser($utilisateur);

            if ($porte->denies('proprietaire-modele', $candidature)) { throw new UnauthorizedException();  }

            // Récupérer le certificat.
            $certificat = CandidatCertificat::find($entrees['certificat']);

            if ($porte->denies('proprietaire-modele', $certificat)) { throw new UnauthorizedException(); }

            // Créer un lien certificats.
            $lien = CandidatureCertificat::create($entrees);

            // Raffraichir le modèle.
            $lien->refresh();

            // Retourner une reponse de succès.
            return parent::ReponseJsonSuccesCreation(donnees: $lien->toArray());
        }

		catch (UnauthorizedException $e) { return parent::ReponseJsonEchecAutorisation(); }

		catch (Exception $e) {  return parent::ReponseJsonEchecServeur(exception: $e); }
    }

    /**
     * Supprimer un certificat de sa canidature.
	 *
	 * @param Request $requete
	 *
	 * @return JsonResponse $reponse
     */
    public function delier(Request $requete, string $id): JsonResponse
    {
        try {

            // Rechercher le lien.
            $lien = CandidatureCertificat::findOrFail($id);

            $candidature = $lien->candidature()->first();

            // Récupérer l'utilisateur.
            $utilisateur = $requete->utilisateur;

            // Vérifier les autorisations.
            $porte = Gate::forUser($utilisateur);

            if ($porte->denies('proprietaire-modele', $candidature)) {
                throw new UnauthorizedException();
            }

            $lien->delete();

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
