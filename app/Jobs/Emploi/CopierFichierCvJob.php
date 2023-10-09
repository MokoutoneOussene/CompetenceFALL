<?php

namespace App\Jobs\Emploi;

use App\Models\Emploi\CandidatureCv;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class CopierFichierCvJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public CandidatureCv $lienCv;

    public function __construct(CandidatureCv $lienCv) { $this->lienCv = $lienCv; }

    public function handle(): void
    {
		$candidature = $this->lienCv->candidature()->first();

		$cv = $this->lienCv->cv()->first();

		$cheminDestination = "prive/emplois/" . $candidature->offre . "/candidats/" . $candidature->utilisateur .
			"/cvs/";

		$nomFichier = "cv_" . date('Y') . "_" . date('m') . "_" . date('d') . "_" . date('H')
			. "_" . date('i') . "_" . date('s') . ".pdf";

		$cheminSource = "public/utilisateurs/" . $candidature->utilisateur . "/cvs/" . $cv->slug;

		if(Storage::exists($cheminSource)) {

			Storage::makeDirectory($cheminDestination);

			Storage::copy($cheminSource, $cheminDestination . $nomFichier);
		}
	}
}
