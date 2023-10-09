<?php

namespace App\Traits\Pdf;

use Barryvdh\DomPDF\Facade\Pdf;
use Exception;
use Illuminate\Support\Facades\Storage;

trait PdfTrait
{
	public function genererPdf() : bool {

		try {

			// Créer le chemin de stockage s'il n'existe pas.
			Storage::makeDirectory($this->retournerCheminPdf());

			// Récupérer les données.
			$donnees = []; //$this->recupererDonnees();

			// Faire le rendu du PDF.
			$pdf = Pdf::loadView($this->vueBlade, compact('donnees'));

			if(isset($pdf)) {

				// Stocker le PDF.
				if(Storage::put($this->retournerCheminPdf() . $this->retournerNomPdf(), $pdf->output())) { return TRUE; }

				else return FALSE;
			}

			else return FALSE;

		} catch(Exception $e) { throw $e; }
	}

	public function copierPdf() : bool {

		try {

			$cheminPlusNomFichier = $this->chemin;

			$cheminDestination = $this->cheminDestnation;

			// Créer le chemin de destination s'il n'existe pas.
			Storage::makeDirectory($cheminDestination);

			// Copier le fichier.
			return Storage::copy($cheminPlusNomFichier, $cheminDestination);

		} catch(Exception $e) { throw $e; }
	}
}
