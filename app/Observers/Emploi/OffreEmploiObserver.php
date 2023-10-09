<?php

namespace App\Observers\Emploi;

use App\Jobs\Emploi\GenererPdfOffreEmploiJob;
use App\Models\Emploi\OffreEmploi;
use Illuminate\Support\Facades\Storage;

class OffreEmploiObserver
{
	/**
	 * Evènement de pré-création.
	*/
	public function creating(OffreEmploi $offreEmploi) { }

	/**
	 * Evènement de post-création.
	*/
	public function created(OffreEmploi $offreEmploi) {

		if($offreEmploi->statutPublication == TRUE) {

			GenererPdfOffreEmploiJob::dispatch($offreEmploi);
		}
	}

	/**
	 * Evènement de pré-mise-à-jour.
	*/
	public function updating(OffreEmploi $offreEmploi) { }

	/**
	 * Evènement de post-mise-à-jour.
	*/
	public function updated(OffreEmploi $offreEmploi) {

		if($offreEmploi->statutPublication == TRUE) {

			GenererPdfOffreEmploiJob::dispatch($offreEmploi);
		}
	}

	/**
	 * Evènement de pré-suppression.
	*/
	public function deleting(OffreEmploi $offreEmploi) { }

	/**
	 * Evènement de post-suppression.
	*/
	public function deleted(OffreEmploi $offreEmploi) {

		// Vérifier si l'offre avait été déjà publiée.
		if(Storage::exists("prive/emplois/". $offreEmploi->id . "/offres/")) {

			GenererPdfOffreEmploiJob::dispatch($offreEmploi);
		}
	}
}
