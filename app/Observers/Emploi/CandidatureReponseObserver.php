<?php

namespace App\Observers\Emploi;

use App\Jobs\Emploi\CalculerNoteReponseJob;
use App\Jobs\Emploi\GenererPdfCandidatureJob;
use App\Models\Emploi\CandidatureReponse;

class CandidatureReponseObserver
{
	/**
	 * Evènement de pré-création.
	*/
	public function creating(CandidatureReponse $reponse) { }

	/**
	 * Evènement de post-création.
	*/
	public function created(CandidatureReponse $reponse) {

		// Récupérer la candidature.
		$candidature = $reponse->candidature()->first();

		if($candidature->statutSoumission == TRUE) {

			CalculerNoteReponseJob::dispatch($candidature);

			GenererPdfCandidatureJob::dispatch($candidature);
		}
	}

	/**
	 * Evènement de pré-mise-à-jour.
	*/
	public function updating(CandidatureReponse $reponse) { }

	/**
	 * Evènement de post-mise-à-jour.
	*/
	public function updated(CandidatureReponse $reponse) { }

	/**
	 * Evènement de pré-suppression.
	*/
	public function deleting(CandidatureReponse $reponse) { }

	/**
	 * Evènement de post-suppression.
	*/
	public function deleted(CandidatureReponse $reponse) { }
}
