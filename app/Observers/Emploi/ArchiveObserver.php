<?php

namespace App\Observers\Emploi;

use App\Jobs\Emploi\ArchiverOffreEmploiJob;
use App\Models\Emploi\Archive;

class ArchiveObserver
{
	/**
	 * Evènement de pré-création.
	*/
	public function creating(Archive $archive) {

	}

	/**
	 * Evènement de post-création.
	*/
	public function created(Archive $archive) {

		ArchiverOffreEmploiJob::dispatch($archive);
	}

	/**
	 * Evènement de pré-mise-à-jour.
	*/
	public function updating(Archive $archive) {

	}

	/**
	 * Evènement de post-mise-à-jour.
	*/
	public function updated(Archive $archive) {

	}

	/**
	 * Evènement de pré-suppression.
	*/
	public function deleting(Archive $archive) {

	}

	/**
	 * Evènement de post-suppression.
	*/
	public function deleted(Archive $archive) {

	}
}
