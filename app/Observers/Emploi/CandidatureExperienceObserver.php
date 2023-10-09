<?php

namespace App\Observers\Emploi;

use App\Jobs\Emploi\CalculerNoteExperienceJob;
use App\Jobs\Emploi\GenererPdfCandidatureJob;
use App\Models\Emploi\CandidatureExperience;

class CandidatureExperienceObserver
{
	/**
	 * Evènement de pré-création.
	*/
	public function creating(CandidatureExperience $experience) { }

	/**
	 * Evènement de post-création.
	*/
	public function created(CandidatureExperience $experience) {

		// Récupérer la candidature.
		$candidature = $experience->candidature()->first();

		if($candidature->statutSoumission == TRUE) {

			CalculerNoteExperienceJob::dispatch($candidature);

			GenererPdfCandidatureJob::dispatch($candidature);
		}
	}

	/**
	 * Evènement de pré-mise-à-jour.
	*/
	public function updating(CandidatureExperience $experience) { }

	/**
	 * Evènement de post-mise-à-jour.
	*/
	public function updated(CandidatureExperience $experience) { }

	/**
	 * Evènement de pré-suppression.
	*/
	public function deleting(CandidatureExperience $experience) { }

	/**
	 * Evènement de post-suppression.
	*/
	public function deleted(CandidatureExperience $experience) {

		// Récupérer la candidature.
		$candidature = $experience->candidature()->first();

		if($candidature->statutSoumission == TRUE) {

			CalculerNoteExperienceJob::dispatch($candidature);
		}
	}
}
