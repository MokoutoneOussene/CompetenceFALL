<?php

namespace App\Http\Controllers\Can;

use App\Http\Controllers\Controller;
use App\Models\Emploi\Candidature;
use App\Models\Emploi\CandidatureConvocation;
use App\Models\Systeme\Extenssion\Candidat;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\UnauthorizedException;

class CanConvocationController extends Controller
{
    /**
     * Voir une convocation.
     */
    public function voir(Request $requete, string $id): JsonResponse
    {
        try {

            // Rechercher l'instance.
            $convocation = CandidatureConvocation::with(
                ['candidature' => ['utilisateur' => [
                    'personne' => [
                        'paysNaissance',
                        'paysResidence',
                    ],
                ],
                ],
                ]
            )->findOrFail($id);

            // Récupérer l'utilisateur.
            $utilisateur = $requete->utilisateur;

            // Vérifier les autorisations.
            if ($utilisateur->id != $convocation->candidature()->first(['utilisateur'])->utilisateur) {
                throw new UnauthorizedException();
            }

            return parent::ReponseJsonSuccesVisualisation(donnees: $convocation->toArray());
        } catch (ModelNotFoundException $e) {
            return parent::ReponseJsonEchecNonTrouve();
        } catch (UnauthorizedException $e) {
            return parent::ReponseJsonEchecAutorisation();
        } catch (Exception $e) {
            return parent::ReponseJsonEchecServeur(exception: $e);
        }
    }

    /**
     * Lister ses convocations.
     *
     *
     * @return JsonResponse $reponse
     */
    public function lister(Request $requete): JsonResponse
    {
        try {

            // Récupérer l'utilisateur.
            $utilisateur = $requete->utilisateur;

            // Récuéprer les fonctionnalités du candidat.
            $candidat = Candidat::where('id', $utilisateur->id)->first(['id']);

            $candidatures = Candidature::with([
                'convocation' => [
                    'pays',
                ],
            ])->get();

            if ($candidatures->isEmpty()) {
                throw new ModelNotFoundException();
            }

            $convocations = new Collection();

            foreach ($candidatures as $candidature) {

                if (isset($candidature->convocation)) {

                    $convocation = $candidature->convocation->makeHidden([
                        'consignes',
                        'auteurCreation',
                        'auteurMiseAJour',
                    ]);

                    $convocations = $convocations->push($convocation);
                }
            }

            if ($convocations->isEmpty()) {
                return parent::ReponseJsonEchecRessource();
            }

            return parent::ReponseJsonSucces(donnees: $convocations->toArray());
        } catch (Exception $e) {
            return parent::ReponseJsonEchecServeur(exception: $e);
        }
    }
}
