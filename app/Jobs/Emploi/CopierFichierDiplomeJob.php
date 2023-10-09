<?php

namespace App\Jobs\Emploi;

use App\Models\Emploi\CandidatureDiplome;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class CopierFichierDiplomeJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public CandidatureDiplome $lienDiplome;

    public function __construct(CandidatureDiplome $lienDiplome) { $this->lienDiplome = $lienDiplome; }

    public function handle(): void
    {
		$candidature = $this->lienDiplome->candidature()->first();

		$diplome = $this->lienDiplome->diplome()->first();

		$cheminDestination = "prive/emplois/" . $candidature->offre . "/candidats/" . $candidature->utilisateur .
			"/diplomes/";

		$nomFichier = "diplome_" . date('Y') . "_" . date('m') . "_" . date('d') . "_" . date('H') . "_" . date('i') . "_"
		. date('s') . ".pdf";

		$cheminSource = "public/utilisateurs/" . $candidature->utilisateur . "/diplomes/" . $diplome->slug;

		if(Storage::exists($cheminSource)) {

			Storage::makeDirectory($cheminDestination);

			Storage::copy($cheminSource, $cheminDestination . $nomFichier);
		}
	}
}
