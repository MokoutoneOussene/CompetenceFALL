<?php

namespace App\Observers\Emploi;

use App\Jobs\Emploi\CalculerNoteLangueJob;
use App\Jobs\Emploi\GenererPdfCandidatureJob;
use App\Models\Emploi\CandidatureLangue;

class CandidatureLangueObserver
{
	/**
	 * Evènement de pré-création.
	*/
	public function creating(CandidatureLangue $langue) { }

	/**
	 * Evènement de post-création.
	*/
	public function created(CandidatureLangue $langue) {

		// Récupérer la candidature.
		$candidature = $langue->candidature()->first();

		if($candidature->statutSoumission == TRUE) {

			CalculerNoteLangueJob::dispatch($candidature);

			GenererPdfCandidatureJob::dispatch($candidature);
		}
	}

	/**
	 * Evènement de pré-mise-à-jour.
	*/
	public function updating(CandidatureLangue $langue) { }

	/**
	 * Evènement de post-mise-à-jour.
	*/
	public function updated(CandidatureLangue $langue) { }

	/**
	 * Evènement de pré-suppression.
	*/
	public function deleting(CandidatureLangue $langue) { }

	/**
	 * Evènement de post-suppression.
	*/
	public function deleted(CandidatureLangue $langue) {

		// Récupérer la candidature.
		$candidature = $langue->candidature()->first();

		if($candidature->statutSoumission == TRUE) {

			CalculerNoteLangueJob::dispatch($candidature);

			GenererPdfCandidatureJob::dispatch($candidature);
		}
	}
}
