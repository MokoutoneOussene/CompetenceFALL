<?php

namespace App\Models\Emploi;

use App\Models\Systeme\Utilisateur;
use App\Traits\Pdf\PdfTrait;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Candidature extends Model
{
	use HasFactory, PdfTrait;

	protected $table = 'emploi_candidatures';

	protected $fillable = [
		'utilisateur',
		'offre',
		'examinateur',
		'intitule',
		'lettreMotivation',
		'statutSoumission',
		'statutExamination',
		'noteDiplomes',
		'noteCertificats',
		'noteExperiences',
		'noteLangues',
		'noteReponses',
		'noteGlobale',
		'observations',
		'auteurMiseAJour'
	];

	protected $hidden = [
		'auteurCreation'
	];

	public function retournerCheminPdf() : string {

		return "prive/emplois/" . $this->offre . "/candidats/"
			. $this->utilisateur . "/candidatures/";
	}

	public function retournerNomPdf() : string {

		return "candidature_" . date('Y') . '_' . date('m') . '_' . date('d') .
			'_' . date('H') . '_' . date('i') . '_' . date('s') . '.pdf';
	}

	private string $vueBlade = 'pdfs.emplois.candidatures.test-candidature';

	/**
	 * Méthode pour générer le fichier PDF d'une candidature.
	*/
	public function recupererDonneesPdf() : array {

		try {

			return [
				'offre' => $this->offreEmploi()->with(['questions'])->first(),
				'examinateur' => $this->examinateur()->with(['personne'])->first(),
				'diplomes' => $this->diplomes()->with([
					'domaineEtude',
					'niveauEtude',
					'niveauSpecialisation'
				])->get(),
				'certificats' => $this->certificats()->with(['domaineEtude'])->get(),
				'experiences' => $this->experiences()->with(['domaineEtude'])->get(),
				'references' => $this->references()->get(),
				'competences' => $this->competences()->get(),
				'langues' => $this->langues()->get(),
				'portfolios' => $this->portfolios()->get(),
				'centres' => $this->centres()->get(),
				'candidat' => $this->utilisateur()->with(['personne'])->first()
			];
		}

		catch(Exception $e) { return []; }
	}

	public function toArray(): array
	{

		$donnees = parent::toArray();

		if (isset($donnees['noteDiplome'])) {
			$donnees['noteDiplome'] = (int) $this->noteDiplome;
		}
		if (isset($donnees['noteCertificat'])) {
			$donnees['noteCertificat'] = (int) $this->noteCertificat;
		}
		if (isset($donnees['noteExperience'])) {
			$donnees['noteExperience'] = (int) $this->noteExperience;
		}
		if (isset($donnees['noteLangue'])) {
			$donnees['noteLangue'] = (int) $this->noteLangue;
		}
		if (isset($donnees['noteQuestion'])) {
			$donnees['noteQuestion'] = (int) $this->noteQuestion;
		}
		if (isset($donnees['noteGlobale'])) {
			$donnees['noteGlobale'] = (int) $this->noteGlobale;
		}

		if (isset($donnees['statutSoumission'])) {
			$donnees['statutSoumission'] = (bool) $this->statutSoumission;
		}
		if (isset($donnees['statutExamination'])) {
			$donnees['statutExamination'] = (bool) $this->statutExamination;
		}

		if (isset($donnees['created_at'])) {
			$donnees['created_at'] = Carbon::parse($this->created_at)->format('Y-m-d H:i:s');
		}
		if (isset($donnees['dateMiseAjour'])) {
			$donnees['dateMiseAjour'] = Carbon::parse($this->dateMiseAjour)->format('Y-m-d H:i:s');
		}

		return $donnees;
	}

	public function utilisateur()
	{
		return $this->belongsTo(Utilisateur::class, 'utilisateur', 'id');
	}

	public function offreEmploi()
	{
		return $this->belongsTo(OffreEmploi::class, 'offre', 'id');
	}

	public function examinateur()
	{
		return $this->belongsTo(Utilisateur::class, 'examinateur', 'id');
	}

	public function convocation()
	{
		return $this->hasOne(CandidatureConvocation::class, 'candidature', 'id');
	}

	public function cv()
	{

		return $this->hasOneThrough(
            CandidatCv::class,		// Le modèle cible
            CandidatureCv::class,	// Le modèle intermédiaire (table pivot)
            'candidature',			// Clé étrangère dans la table "candidatures"
            'id',					// Clé primaire de la table "candidatures"
            'id',					// Clé primaire de la table "candidature_cv"
            'cv'					// Clé étrangère dans la table "candidature_cv"
        );
	}

	public function diplomes()
	{

		return $this->belongsToMany(
			related: CandidatDiplome::class, // Modèle cible
			table: 'emploi_candidature_diplomes', // Table intermédiare
			foreignPivotKey: 'candidature', // Clé étrangère du modèle principal sur le table intermédiaire
			relatedPivotKey: 'diplome', // Clé primaire du modèle cible sur la table intermédiaire
		);
	}

	public function certificats()
	{

		return $this->belongsToMany(
			related: CandidatCertificat::class, // Modèle cible
			table: 'emploi_candidature_certificats', // Table intermédiare
			foreignPivotKey: 'candidature', // Clé étrangère du modèle principal sur le table intermédiaire
			relatedPivotKey: 'certificat', // Clé primaire du modèle cible sur la table intermédiaire
		);
	}

	public function experiences()
	{

		return $this->belongsToMany(
			related: CandidatExperience::class, // Modèle cible
			table: 'emploi_candidature_experiences', // Table intermédiare
			foreignPivotKey: 'candidature', // Clé étrangère du modèle principal sur le table intermédiaire
			relatedPivotKey: 'experience', // Clé primaire du modèle cible sur la table intermédiaire
		);
	}

	public function langues()
	{

		return $this->belongsToMany(
			related: CandidatLangue::class, // Modèle cible
			table: 'emploi_candidature_langues', // Table intermédiare
			foreignPivotKey: 'candidature', // Clé étrangère du modèle principal sur le table intermédiaire
			relatedPivotKey: 'langue', // Clé primaire du modèle cible sur la table intermédiaire
		);
	}

	public function references()
	{

		return $this->belongsToMany(
			related: CandidatReference::class, // Modèle cible
			table: 'emploi_candidature_references', // Table intermédiare
			foreignPivotKey: 'candidature', // Clé étrangère du modèle principal sur le table intermédiaire
			relatedPivotKey: 'reference', // Clé primaire du modèle cible sur la table intermédiaire
		);
	}

	public function portfolios()
	{

		return $this->belongsToMany(
			related: CandidatPortfolio::class, // Modèle cible
			table: 'emploi_candidature_portfolios', // Table intermédiare
			foreignPivotKey: 'candidature', // Clé étrangère du modèle principal sur le table intermédiaire
			relatedPivotKey: 'portfolio', // Clé primaire du modèle cible sur la table intermédiaire
		);
	}

	public function centres()
	{

		return $this->belongsToMany(
			related: CandidatCentre::class, // Modèle cible
			table: 'emploi_candidature_centres', // Table intermédiare
			foreignPivotKey: 'candidature', // Clé étrangère du modèle principal sur le table intermédiaire
			relatedPivotKey: 'centre', // Clé primaire du modèle cible sur la table intermédiaire
		);
	}

	public function competences()
	{

		return $this->belongsToMany(
			related: CandidatCompetence::class, // Modèle cible
			table: 'emploi_candidature_competences', // Table intermédiare
			foreignPivotKey: 'candidature', // Clé étrangère du modèle principal sur le table intermédiaire
			relatedPivotKey: 'competence', // Clé primaire du modèle cible sur la table intermédiaire
		);
	}

	public function reponses()
	{
		return $this->hasMany(CandidatureReponse::class, 'candidature', 'id');
	}

	public function auteurCreation()
	{
		return $this->belongsTo(Utilisateur::class, 'auteurCreation', 'id');
	}

	public function auteurMiseAJour()
	{
		return $this->belongsTo(Utilisateur::class, 'auteurMiseAJour', 'id');
	}

	/**
	 * Fonction de calcul de la note de la candidature.
	 */
	public function calculerNoteGlobale(): void
	{
		$this->calculerNoteDiplomes();
		$this->calculerNoteCertificats();
		$this->calculerNoteExperiences();
		$this->calculerNoteLangue();
		$this->calculerNoteReponses();
	}

	public function calculerNoteDiplomes(): void
	{
		// Initialiser la note de retour.
		$note = 0;

		// Récupérer les préréquis des diplomes.
		$pDiplomes = $this->offreEmploi()->prerequisDiplomes()->get();

		// Récupérer les diplômes joints à la candidature.
		$cDiplomes = $this->diplomes()->get();

		// Commencer l'évaluation que s'il y des préréquis diplômes et des diplômes joints à la candidature.
		if ($pDiplomes->count() && $cDiplomes->count()) {

			foreach ($pDiplomes as $pDiplome) {

				foreach ($cDiplomes as $cDiplome) {

					// Comparaison des domaines d'études.
					if ($pDiplome->domaineEtude != null) {

						if ($pDiplome->domaineEtude == $cDiplome->domaineEtude) {

							$note += $pDiplome->noteDomaine;
						}
					}

					// Comparaison des niveaux d'études.
					if ($pDiplome->niveauEtude != null) {

						$pNiveauEtude = $pDiplome->niveauEtude()->first();

						$cNiveauEtude = $cDiplome->niveauEtude()->first();

						if ($pNiveauEtude->niveau <= $cNiveauEtude->niveau) {

							$note += $pNiveauEtude->niveau;
						}

						else { $note += $cNiveauEtude->niveau; }
					}

					// Comparaison des niveaux de spécialisation.
					if ($pDiplome->niveauSpecialisation != null) {

						$pNiveauSpecialisation = $pDiplome->niveauSpecialisation()->first();

						$cNiveauSpecialisation = $cDiplome->niveauSpecialisation()->first();

						if ($pNiveauSpecialisation->niveau <= $cNiveauSpecialisation->niveau) {

							$note += $pNiveauSpecialisation->niveau;
						}

						else { $note += $cNiveauSpecialisation->niveau; }
					}
				}
			}

			// Raffraichir la note aux question et la note globale.
			$this->noteGlobale -= $this->noteDiplomes;

			$this->noteDiplomes = $note;

			$this->noteGlobale += $this->noteDiplomes;

			$this->save();
		}
	}

	public function calculerNoteCertificats(): void
	{
		// Initialiser la note de retour.
		$note = 0;

		// Récupération des préréquis certificats.
		$pCertificats = $this->offreEmploi()->prerequisCertificats()->get();

		// Récupérer les certififcats de la candidature.
		$cCertificats = $this->certificats()->get();

		// Commencer l'évaluation que si il y a des préréquis diplômes et des diplômes joints à la candidature.
		if ($pCertificats->count() && $cCertificats->count()) {

			foreach ($pCertificats as $pCertificat) {

				foreach ($cCertificats as $cCertificat) {

					// Comparaison des domaines d'études.
					if ($pCertificat->domaineEtude == $cCertificat->domaineEtude) {

						$note += $pCertificat->noteDomaine;
					}
				}

			}

			// Raffraichir la note aux question et la note globale.
			$this->noteGlobale -= $this->noteCertificats;

			$this->noteCertificats = $note;

			$this->noteGlobale += $this->noteCertificats;

			$this->save();
		}
	}

	public function calculerNoteExperiences(): void
	{
		// Initialiser la note de retour.
		$note = 0;

		// Récupérer les préréquis expériences professionnelles.
		$pExperiences = $this->offreEmploi()->prerequisExperiences()->get();

		// Récupérer les expériences professionnelles de la candidature.
		$cExperiences = $this->experiences()->get();

		// Commencer l'évaluation uniquement que s'il y a des préréquis expériences et des expériences de la candidature.
		if ($pExperiences->count() && $cExperiences->count()) {

			foreach ($pExperiences as $pExperience) {

				foreach ($cExperiences as $cExperience) {

					// Comparaison des domaines.
					if ($pExperience->domaineEtude == $cExperience->domaineEtude) {

						// Comparaison des durées.
						if ($pExperience->duree <= $cExperience->duree) { $note += $pExperience->duree; }

						else { $note += $cExperience->duree; }
					}
				}
			}

			// Raffraichir la note aux question et la note globale.
			$this->noteGlobale -= $this->noteExperiences;

			$this->noteExperiences = $note;

			$this->noteGlobale += $this->noteExperiences;

			$this->save();
		}
	}

	public function calculerNoteLangues() : void
	{
		// Initialiser la note de retour.
		$note = 0;

		// Récupérer les préréquis langues de l'offre.
		$pLangues = $this->offreEmploi()->prerequisLangues()->get();

		// Récupérer les langues de la candidature.
		$cLangues = $this->langues()->get();

		// Commencer l'évaluation uniquement s'il y a des préréquis langues et des langues pour la candidature.
		if ($pLangues->count() && $cLangues->count()) {

			foreach ($pLangues as $pLangue) {

				foreach ($cLangues as $cLangue) {

					// Comparaison des langues.
					if (Str::is(
						Str::ascii(Str::replace(" ", "", $cLangue->intitule)),
						Str::ascii(Str::replace(" ", "", $pLangue->intitule)))
					) {
						// Vérifier le niveau de langue.
						if(isset($pLangue->niveau)) {

							if(Str::is($pLangue->niveau, $cLangue->niveau)) $note += $pLangue->noteNiveau;
						}
						if($pLangue->statutParle) {

							if($cLangue->statutParle) $note += $pLangue->noteStatutParle;
						}
						if($pLangue->statutLu) {

							if($cLangue->statutLu) $note += $pLangue->noteStatutLu;
						}
						if($pLangue->statutEcrit) {

							if($cLangue->statutEcrit) $note += $pLangue->noteStatutEcrit;
						}
					}
				}
			}

			// Raffraichir la note aux question et la note globale.
			$this->noteGlobale -= $this->noteLangues;

			$this->noteLangues = $note;

			$this->noteGlobale += $this->noteLangues;

			$this->save();
		}
	}

	public function calculerNoteReponses() : void
	{
		// Initialiser la note de retour à 0.
		$note = 0;

		// Récupérer les questions de l'offre d'emploi.
		$questions = $this->offreEmploi()->questions()->get();

		// Récupérer les réponses de la candidature.
		$reponses = $this->reponses()->get();

		// Commencer l'évaluation uniquement s'il y a des questions et des réponses.
		if ($questions->count() && $reponses->count()) {

			foreach ($questions as $question) {

				// Vérifier s'il s'agit d'une question notée.
				if($question->typeQuestion == 'vraiFaux') {

					foreach($reponses as $reponse) {

						// Vérifier s'il s'agit d'une reponse à la question courante.
						if($reponse->question == $question->id) {

							// Incrémenter la note à retourner de la note de la question si la bonne reponse.
							if($reponse->reponse == $question->bonneReponse) { $note += $question->note; }
						}
					}
				}
			}

			// Raffraichir la note aux question et la note globale.
			$this->noteGlobale -= $this->noteReponses;

			$this->noteReponses = $note;

			$this->noteGlobale += $this->noteReponses;

			$this->save();
		}
	}
}
