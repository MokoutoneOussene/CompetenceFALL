<?php

namespace App\Models\Emploi;

use App\Models\Systeme\Pays;
use App\Models\Systeme\Utilisateur;
use App\Traits\Pdf\PdfTrait;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

class OffreEmploi extends Model
{
    use HasFactory, PdfTrait;

    protected $table = 'emploi_offre_emplois';

    protected $fillable = [
        'poste',
        'contrat',
        'nomOrganisation',
        'infosOrganisation',
        'domaine',
        'description',
        'prerequis',
        'dateLimite',
        'lieu',
        'pays',
        'typeLieu',
        'remuneration',
        'avantages',
        'places',
        'dateDebutPoste',
        'consignes',
        'infosComplementaires',
        'pourcentageMoyenne',
        'statutPublication',
        'dateDebutPublication',
        'dateFinPublication',
        'auteurCreation',
        'auteurMiseAJour',
    ];

	private function retournerCheminPdf() : string {

		return "prive/emplois/" . $this->id . "/offres/";
	}

	private function retournerNomPdf() : string {

		return "offre_" . date('Y') . '_' . date('m') . '_' . date('d') .
			'_' . date('H') . '_' . date('i') . '_' . date('s') . '.pdf';
	}

	private string $vueBlade = 'pdfs.emplois.offres.test-offre';

	/**
	 * Méthode pour générer le fichier PDF d'une candidature.
	*/
	public function recupererDonneesPdf() : array {

		try {

			return [
				'offre' => $this->with([
					'pays',
					'auteurCreation' => [
						'personne' => [
							'paysNaissance',
							'paysResidence',
						],
						'organisation' => ['paysSiege'],
					],
					'auteurMiseAJour' => [
						'personne' => [
							'paysNaissance',
							'paysResidence',
						],
						'organisation' => ['paysSiege'],
					],
					'prerequisDiplomes' => [
						'domaineEtude',
						'niveauEtude',
						'niveauSpecialisation',
					],
					'prerequisCertificats' => ['domaineEtude'],
					'prerequisExperiences' => ['domaineEtude'],
					'prerequisLangues',
					'questions'
				])->first()
			];
		}

		catch(Exception $e) { return []; }
	}

	/**
	 * Rechercher des offres d'emplois.
	 *
	 * @param Builder $requete
	 *
	 * @param array $donnees
	 *
	 * @param bool $booleenPays
	 *
	 * @return Collection $reponse
	*/
	public static function rechercher(Builder $requete, array $donnees, bool $booleenPays = FALSE)
    {
        return $requete->where(function ($requete) use ($donnees) {
            foreach ($donnees as $champs => $valeur) {
                $requete->orWhere($champs, 'LIKE', "%". $valeur ."%");
            }
        })->when($booleenPays, function ($requete) use ($donnees) {
            $requete->orWhereHas('pays', function ($requete) use ($donnees) {
                $requete->where('nom', 'LIKE', "%". $donnees['pays'] ."%");
            });
        })->get();
    }

	/**
	 * Filtrer la recherche des offres d'emplois en fonction du statutPublication.
	 *
	 * @param Collection $resultats
	 *
	 * @return Collection $reponse
	*/
	public static function filtrerRecherche(Collection $resultats)
    {
        return $resultats->filter(function ($item) {
			return $item->statutPublication === TRUE;
		})->sortBy('dateDebutPublication');
    }

    public function toArray()
    {

        $donnees = parent::toArray();

        if (isset($donnees['statutPublication'])) {
            $donnees['statutPublication'] = (bool) $donnees['statutPublication'];
        }
        if (isset($donnees['created_at'])) {
            $donnees['created_at'] = Carbon::parse($donnees['created_at'])->format('Y-m-d H:i:s');
        }
        if (isset($donnees['updated_at'])) {
            $donnees['updated_at'] = Carbon::parse($donnees['updated_at'])->format('Y-m-d H:i:s');
        }

        return $donnees;
    }

    public function prerequisDiplomes(): HasMany
    {
        return $this->hasMany(PrerequisDiplome::class, 'offre', 'id');
    }

    public function prerequisCertificats(): HasMany
    {
        return $this->hasMany(PrerequisCertificat::class, 'offre', 'id');
    }

    public function prerequisExperiences(): HasMany
    {
        return $this->hasMany(PrerequisExperience::class, 'offre', 'id');
    }

    public function prerequisLangues(): HasMany
    {
        return $this->hasMany(PrerequisLangue::class, 'offre', 'id');
    }

    public function questions(): HasMany
    {
        return $this->hasMany(QuestionOffre::class, 'offre', 'id');
    }

    public function pays(): BelongsTo
    {
        return $this->belongsTo(Pays::class, 'pays', 'id');
    }

    public function candidatures(): HasMany
    {
        return $this->hasMany(Candidature::class, 'offre', 'id');
    }

    public function auteurCreation(): BelongsTo
    {
        return $this->belongsTo(Utilisateur::class, 'auteurCreation', 'id');
    }

    public function auteurMiseAJour(): BelongsTo
    {
        return $this->belongsTo(Utilisateur::class, 'auteurMiseAJour', 'id');
    }
}
