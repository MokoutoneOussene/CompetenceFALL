<?php

namespace App\Observers\Emploi;

use App\Jobs\Emploi\GenererPdfCandidatureJob;
use App\Models\Emploi\CandidatureCentre;

class CandidatureCentreObserver
{
	/**
	 * Evènement de pré-création.
	*/
	public function creating(CandidatureCentre $centre) { }

	/**
	 * Evènement de post-création.
	*/
	public function created(CandidatureCentre $centre) {

		// Récupérer la candidature.
		$candidature = $centre->candidature()->first();

		if($candidature->statutSoumission == TRUE) {

			GenererPdfCandidatureJob::dispatch($candidature);
		}
	}

	/**
	 * Evènement de pré-mise-à-jour.
	*/
	public function updating(CandidatureCentre $centre) { }

	/**
	 * Evènement de post-mise-à-jour.
	*/
	public function updated(CandidatureCentre $centre) { }

	/**
	 * Evènement de pré-suppression.
	*/
	public function deleting(CandidatureCentre $centre) { }

	/**
	 * Evènement de post-suppression.
	*/
	public function deleted(CandidatureCentre $centre) {

		// Récupérer la candidature.
		$candidature = $centre->candidature()->first();

		if($candidature->statutSoumission == TRUE) {

			GenererPdfCandidatureJob::dispatch($candidature);
		}
	}
}
