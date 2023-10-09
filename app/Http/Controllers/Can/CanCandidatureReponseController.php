<?php

namespace App\Http\Controllers\Can;

use App\Http\Controllers\Controller;
use App\Jobs\Emploi\CalculerNoteCandidatureJob;
use App\Models\Emploi\Candidature;
use App\Models\Emploi\CandidatureReponse;
use App\Rules\Emploi\Candidature\CandidatureReponseUniqueRule;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\UnauthorizedException;

class CanCandidatureReponseController extends Controller
{
    /**
     * Repondre à une question d'offre d'emploi.
     */
    public function repondre(Request $requete): JsonResponse
    {
        try {

            // Récupérer les entrées.
            $entrees = Arr::only($requete->json()->all(), [
                'candidature',
                'question',
                'reponse'
            ]);

            // Valider les entrées.
            $validateur = Validator::make($entrees, [
                'candidature' => 'required|exists:emploi_candidatures,id',
                'question' => 'required|exists:emploi_question_offres,id',
                'reponse' => [
                    'nullable',
                    'boolean',
                    new CandidatureReponseUniqueRule,
                ],
				'contenu' => 'nullable|string|max:255'
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

            if ($porte->denies('proprietaire-modele', $candidature)) {
                throw new UnauthorizedException();
            }

            // Créer la réponse.
			$reponse = CandidatureReponse::create($entrees);

            // Retourner une reponse de succès.
            return parent::ReponseJsonSuccesCreation(donnees: $reponse->toArray());
        } catch (UnauthorizedException $e) {
            return parent::ReponseJsonEchecAutorisation();
        } catch (Exception $e) {
            return parent::ReponseJsonEchecServeur(exception: $e);
        }
    }

    /**
     * Demander la question suivante.
     */
    public function demander(string $id): JsonResponse
    {
        try {

            // Rechercher la candidature.
            $candidature = Candidature::findOrFail($id);

			// Récupérer l'offre.
			$offre = $candidature->offre()->first();

			// Récupérer les questions.
			$questions = $offre->questions()->get();

			if($questions->isEmpty()) return parent::ReponseJsonEchecNonTrouve();

			// Récupérer les réponses.
			$reponses = CandidatureReponse::where('candidature', $candidature->id)->get();

			// Etablir les questions non repondues.
			$questionsNonRepondues = new Collection();

			foreach($reponses as $reponse) {

				$repondu = FALSE;

				foreach($questions as $question) {

					if($reponse->question == $question->id) {

						$repondu = TRUE;

						break;
					}
				}

				if($repondu == FALSE) $questionsNonRepondues = $questionsNonRepondues->push($question);
			}

			// Rétourner une question.

			if($questionsNonRepondues->isEmpty()) return parent::ReponseJsonEchecNonTrouve();

            return parent::ReponseJsonSucces(donnees: $questionsNonRepondues->random()->toArray());
        } catch (ModelNotFoundException $e) {
            return parent::ReponseJsonEchecNonTrouve();
        } catch (UnauthorizedException $e) {
            return parent::ReponseJsonEchecAutorisation();
        } catch (Exception $e) {
            return parent::ReponseJsonEchecServeur(exception: $e);
        }
    }
}
