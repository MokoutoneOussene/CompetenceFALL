<?php

namespace App\Observers\Emploi;

use App\Jobs\Emploi\GenererPdfConvocationJob;
use App\Models\Emploi\CandidatureConvocation;

class CandidatureConvocationObserver
{
	/**
	 * Evènement de pré-création.
	*/
	public function creating(CandidatureConvocation $convocation) { }

	/**
	 * Evènement de post-création.
	*/
	public function created(CandidatureConvocation $convocation) {

		GenererPdfConvocationJob::dispatch($convocation);
	}

	/**
	 * Evènement de pré-mise-à-jour.
	*/
	public function updating(CandidatureConvocation $convocation) { }

	/**
	 * Evènement de post-mise-à-jour.
	*/
	public function updated(CandidatureConvocation $convocation) {

		GenererPdfConvocationJob::dispatch($convocation);
	}

	/**
	 * Evènement de pré-suppression.
	*/
	public function deleting(CandidatureConvocation $convocation) { }

	/**
	 * Evènement de post-suppression.
	*/
	public function deleted(CandidatureConvocation $convocation) { }
}
