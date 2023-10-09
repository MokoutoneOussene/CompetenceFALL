<?php

namespace App\Models\Emploi;

use App\Models\Systeme\Utilisateur;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

class Archive extends Model
{
    use HasFactory;

	public $table = 'emploi_archives';

    public $timestamps = false;

    protected $fillable = [
        'utilisateur',
		'offre',
		'intitule',
		'chemin',
		'taille',
		'statut',
		'details'
    ];

    protected $hidden = [];

	public function genererArchive() : void {

		try {

			$cheminDossierOffre = "prive/emplois/" . $this->id;

			$cheminDossierDestination = "public/emplois/archives/";

			$nomFichierArchive = $this->id ."_". date('Y') ."_". date('m') ."_".
				date('d') ."_". date('H') ."_". date('i') ."_". date('s') .".zip";

			// Vérifier l'existence du dossier de l'offre.
			if(Storage::exists($cheminDossierOffre)) {

				// Récupérer les fichiers du dossier de l'offre.
				$fichiers = File::allFiles(storage_path("app/" . $cheminDossierOffre));

				// Vérifier l'exsitence d'au moins un fichier.
				if(count($fichiers) >= 1) {

					// Garantir l'existence du dossier de sauvegarde des archives des offres d'emploi.
					Storage::makeDirectory($cheminDossierDestination);

					// Vérifier si le répertoire est inscriptible.
					if(File::isWritable(storage_path("app/" . $cheminDossierDestination))) {

						// Instancier le zipper.
						$zipper = new ZipArchive;

						// Ouvrir le zipper.
						if($zipper->open(storage_path("app/" . $cheminDossierDestination) ."/".  $nomFichierArchive, ZipArchive::CREATE)) {

							// Inscrire les fichiers dans le zipper.
							foreach($fichiers as $fichier) { $zipper->addFile($fichier, $fichier->getFilename()); }

							// Fermer au savegarder l'archive.
							if($zipper->close()) {

								// Mettre à jour le modèle.
								$this->updateQuietly([
									'intitule' => $nomFichierArchive,
									'statut' => TRUE,
									'chemin' => $cheminDossierDestination ."/". $nomFichierArchive,
									'taille' => File::size(storage_path("app/" . $cheminDossierDestination) ."/".  $nomFichierArchive) / 2048,
									'details' => count($fichiers) . " fichiers présents dans cette archive."
								]);

							} else {

								$this->updateQuietly([
									'statut' => FALSE,
									'details' => "Des erreurs sont survenues lors de la finalisation de l'archive."
								]);
							}

						} else {

							$this->updateQuietly([
								'statut' => FALSE,
								'details' => "Des erreurs sont survenues lors de l'ouverture de l'archive."
							]);
						}

					} else {

						$this->updateQuietly([
							'statut' => FALSE,
							'details' => "L'archivage a rencontré des problèmes de droits d'écriture."
						]);
					}

				} else {

					$this->updateQuietly([
						'statut' => FALSE,
						'details' => "Cette offre d'emploi ne contient aucun fichier en sauvegarde."
					]);
				}

			} else {

				$this->updateQuietly([
					'statut' => FALSE,
					'details' => "Le dossier de sauvegarde de cette offre est innexistant."
				]);
			}
		}

		catch(Exception $e) { Log::error($e->getMessage()); }
	}

    public function utilisateur(): BelongsTo
    {
        return $this->belongsTo(Utilisateur::class, 'utilisateur', 'id');
    }

	public function offre(): BelongsTo
    {
        return $this->belongsTo(OffreEmploi::class, 'offre', 'id');
    }
}
