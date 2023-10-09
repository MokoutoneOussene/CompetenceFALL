<?php

namespace App\Jobs\Emploi;

use App\Models\Emploi\CandidatureCertificat;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class CopierFichierCertificatJob implements ShouldQueue
{
	use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

	public CandidatureCertificat $lienCertificat;

	public function __construct(CandidatureCertificat $lienCertificat) { $this->lienCertificat = $lienCertificat; }

	public function handle(): void
	{
		$candidature = $this->lienCertificat->candidature()->first();

		$certificat = $this->lienCertificat->certificat()->first();

		$cheminDestination = "prive/emplois/" . $candidature->offre . "/candidats/" . $candidature->utilisateur .
			"/certificats/";

		$nomFichier = "certificat_" . date('Y') . "_" . date('m') . "_" . date('d') . "_" . date('H') . "_" . date('i') . "_"
		. date('s') . ".pdf";

		$cheminSource = "public/utilisateurs/" . $candidature->utilisateur . "/certificats/" . $certificat->slug;

		if(Storage::exists($cheminSource)) {

			Storage::makeDirectory($cheminDestination);

			Storage::copy($cheminSource, $cheminDestination . $nomFichier);
		}
	}
}
