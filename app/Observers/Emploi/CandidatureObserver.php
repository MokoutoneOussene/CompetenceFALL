<?php

namespace App\Observers\Emploi;

use App\Jobs\Emploi\GenererPdfCandidatureJob;
use App\Models\Emploi\Candidature;

class CandidatureObserver
{
	/**
	 * Evènement de pré-création.
	*/
	public function creating(Candidature $candidature) { }

	/**
	 * Evènement de post-création.
	*/
	public function created(Candidature $candidature) {

		if($candidature->statutSoumission == TRUE) {

			GenererPdfCandidatureJob::dispatch($candidature);}
		}

	/**
	 * Evènement de pré-mise-à-jour.
	*/
	public function updating(Candidature $candidature) { }

	/**
	 * Evènement de post-mise-à-jour.
	*/
	public function updated(Candidature $candidature) {

		if($candidature->statutSoumission == TRUE) {

			GenererPdfCandidatureJob::dispatch($candidature);
		}
	}

	/**
	 * Evènement de pré-suppression.
	*/
	public function deleting(Candidature $candidature) { }

	/**
	 * Evènement de post-suppression.
	*/
	public function deleted(Candidature $candidature) { }
}
