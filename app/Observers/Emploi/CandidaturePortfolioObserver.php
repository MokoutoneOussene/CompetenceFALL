<?php

namespace App\Observers\Emploi;

use App\Jobs\Emploi\GenererPdfCandidatureJob;
use App\Models\Emploi\CandidaturePortfolio;

class CandidaturePortfolioObserver
{
	/**
	 * Evènement de pré-création.
	*/
	public function creating(CandidaturePortfolio $portfolio) { }

	/**
	 * Evènement de post-création.
	*/
	public function created(CandidaturePortfolio $portfolio) {

		// Récupérer la candidature.
		$candidature = $portfolio->candidature()->first();

		if($candidature->statutSoumission == TRUE) {

			GenererPdfCandidatureJob::dispatch($candidature);
		}
	}

	/**
	 * Evènement de pré-mise-à-jour.
	*/
	public function updating(CandidaturePortfolio $portfolio) { }

	/**
	 * Evènement de post-mise-à-jour.
	*/
	public function updated(CandidaturePortfolio $portfolio) { }

	/**
	 * Evènement de pré-suppression.
	*/
	public function deleting(CandidaturePortfolio $portfolio) { }

	/**
	 * Evènement de post-suppression.
	*/
	public function deleted(CandidaturePortfolio $portfolio) {

		// Récupérer la candidature.
		$candidature = $portfolio->candidature()->first();

		if($candidature->statutSoumission == TRUE) {

			GenererPdfCandidatureJob::dispatch($candidature);
		}
	 }
}
