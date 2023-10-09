<?php

namespace App\Observers\Emploi;

use App\Jobs\Emploi\CalculerNoteDiplomeJob;
use App\Jobs\Emploi\CopierFichierDiplomeJob;
use App\Jobs\Emploi\GenererPdfCandidatureJob;
use App\Models\Emploi\CandidatureDiplome;

class CandidatureDiplomeObserver
{
	/**
	 * Evènement de pré-création.
	*/
	public function creating(CandidatureDiplome $diplome) { }

	/**
	 * Evènement de post-création.
	*/
	public function created(CandidatureDiplome $lienDiplome) {

		// Récupérer la candidature.
		$candidature = $lienDiplome->candidature()->first();

		if($candidature->statutSoumission == TRUE) {

			CalculerNoteDiplomeJob::dispatch($candidature);

			GenererPdfCandidatureJob::dispatch($candidature);

			CopierFichierDiplomeJob::dispatch($lienDiplome);
		}
	}

	/**
	 * Evènement de pré-mise-à-jour.
	*/
	public function updating(CandidatureDiplome $diplome) {

	}

	/**
	 * Evènement de post-mise-à-jour.
	*/
	public function updated(CandidatureDiplome $diplome) {

	}

	/**
	 * Evènement de pré-suppression.
	*/
	public function deleting(CandidatureDiplome $diplome) { }

	/**
	 * Evènement de post-suppression.
	*/
	public function deleted(CandidatureDiplome $diplome) {

		// Récupérer la candidature.
		$candidature = $diplome->candidature()->first();

		if($candidature->statutSoumission == TRUE) {

			CalculerNoteDiplomeJob::dispatch($candidature);

			GenererPdfCandidatureJob::dispatch($candidature);
		}
	}
}
