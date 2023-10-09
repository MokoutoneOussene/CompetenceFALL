<?php

namespace App\Observers\Emploi;

use App\Jobs\Emploi\GenererPdfCandidatureJob;
use App\Models\Emploi\CandidatureCompetence;

class CandidatureCompetenceObserver
{
	/**
	 * Evènement de pré-création.
	*/
	public function creating(CandidatureCompetence $competence) { }

	/**
	 * Evènement de post-création.
	*/
	public function created(CandidatureCompetence $competence) {

		// Récupérer la candidature.
		$candidature = $competence->candidature()->first();

		if($candidature->statutSoumission == TRUE) {

			GenererPdfCandidatureJob::dispatch($candidature);
		}
	}

	/**
	 * Evènement de pré-mise-à-jour.
	*/
	public function updating(CandidatureCompetence $competence) { }

	/**
	 * Evènement de post-mise-à-jour.
	*/
	public function updated(CandidatureCompetence $competence) { }

	/**
	 * Evènement de pré-suppression.
	*/
	public function deleting(CandidatureCompetence $competence) { }

	/**
	 * Evènement de post-suppression.
	*/
	public function deleted(CandidatureCompetence $competence) {

		// Récupérer la candidature.
		$candidature = $competence->candidature()->first();

		if($candidature->statutSoumission == TRUE) {

			GenererPdfCandidatureJob::dispatch($candidature);
		}
	}
}
