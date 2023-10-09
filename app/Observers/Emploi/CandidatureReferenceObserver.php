<?php

namespace App\Observers\Emploi;

use App\Jobs\Emploi\GenererPdfCandidatureJob;
use App\Models\Emploi\CandidatureReference;

class CandidatureReferenceObserver
{
	/**
	 * Evènement de pré-création.
	*/
	public function creating(CandidatureReference $reference) { }

	/**
	 * Evènement de post-création.
	*/
	public function created(CandidatureReference $reference) {

		// Récupérer la candidature.
		$candidature = $reference->candidature()->first();

		if($candidature->statutSoumission == TRUE) {

			GenererPdfCandidatureJob::dispatch($candidature);
		}
	}

	/**
	 * Evènement de pré-mise-à-jour.
	*/
	public function updating(CandidatureReference $reference) { }

	/**
	 * Evènement de post-mise-à-jour.
	*/
	public function updated(CandidatureReference $reference) { }

	/**
	 * Evènement de pré-suppression.
	*/
	public function deleting(CandidatureReference $reference) { }

	/**
	 * Evènement de post-suppression.
	*/
	public function deleted(CandidatureReference $reference) {

		// Récupérer la candidature.
		$candidature = $reference->candidature()->first();

		if($candidature->statutSoumission == TRUE) {

			GenererPdfCandidatureJob::dispatch($candidature);
		}
	 }
}
