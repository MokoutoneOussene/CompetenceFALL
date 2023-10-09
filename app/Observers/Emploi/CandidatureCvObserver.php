<?php

namespace App\Observers\Emploi;

use App\Jobs\Emploi\CopierFichierCvJob;
use App\Models\Emploi\CandidatureCv;

class CandidatureCvObserver
{
	/**
	 * Evènement de pré-création.
	*/
	public function creating(CandidatureCv $lienCv) { }

	/**
	 * Evènement de post-création.
	*/
	public function created(CandidatureCv $lienCv) {

		// Récupérer la candidature.
		$candidature = $lienCv->candidature()->first();

		if($candidature->statutSoumission == TRUE) {

			CopierFichierCvJob::dispatch($lienCv);
		}
	}

	/**
	 * Evènement de pré-mise-à-jour.
	*/
	public function updating(CandidatureCv $lienCv) { }

	/**
	 * Evènement de post-mise-à-jour.
	*/
	public function updated(CandidatureCv $lienCv) { }

	/**
	 * Evènement de pré-suppression.
	*/
	public function deleting(CandidatureCv $lienCv) { }

	/**
	 * Evènement de post-suppression.
	*/
	public function deleted(CandidatureCv $lienCv) { }
}
