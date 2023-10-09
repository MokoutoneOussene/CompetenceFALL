<?php

namespace App\Observers\Emploi;

use App\Jobs\Emploi\CalculerNoteCertificatJob;
use App\Jobs\Emploi\CopierFichierCertificatJob;
use App\Jobs\Emploi\GenererPdfCandidatureJob;
use App\Models\Emploi\CandidatureCertificat;

class CandidatureCertificatObserver
{
	/**
	 * Evènement de pré-création.
	*/
	public function creating(CandidatureCertificat $certificat) { }

	/**
	 * Evènement de post-création.
	*/
	public function created(CandidatureCertificat $certificat) {

		// Récupérer la candidature.
		$candidature = $certificat->candidature()->first();

		if($candidature->statutSoumission == TRUE) {

			CalculerNoteCertificatJob::dispatch($candidature);

			GenererPdfCandidatureJob::dispatch($candidature);

			CopierFichierCertificatJob::dispatch($certificat);
		}
	}

	/**
	 * Evènement de pré-mise-à-jour.
	*/
	public function updating(CandidatureCertificat $certificat) { }

	/**
	 * Evènement de post-mise-à-jour.
	*/
	public function updated(CandidatureCertificat $certificat) { }

	/**
	 * Evènement de pré-suppression.
	*/
	public function deleting(CandidatureCertificat $certificat) { }

	/**
	 * Evènement de post-suppression.
	*/
	public function deleted(CandidatureCertificat $certificat) {

		// Récupérer la candidature.
		$candidature = $certificat->candidature()->first();

		if($candidature->statutSoumission == TRUE) {

			CalculerNoteCertificatJob::dispatch($candidature);

			GenererPdfCandidatureJob::dispatch($candidature);
		}
	}
}
