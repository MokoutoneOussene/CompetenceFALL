<?php

namespace App\Models\Systeme\Extenssion;

use App\Models\Emploi\CandidatCentre;
use App\Models\Emploi\CandidatCertificat;
use App\Models\Emploi\CandidatCompetence;
use App\Models\Emploi\CandidatDiplome;
use App\Models\Emploi\CandidatExperience;
use App\Models\Emploi\CandidatLangue;
use App\Models\Emploi\CandidatPortfolio;
use App\Models\Emploi\CandidatReference;
use App\Models\Emploi\Candidature;
use App\Models\Systeme\Utilisateur;

class Candidat extends Utilisateur
{
	public function diplomes()
	{
		return $this->hasMany(CandidatDiplome::class, 'utilisateur', 'id');
	}

	public function certificats()
	{
		return $this->hasMany(CandidatCertificat::class, 'utilisateur', 'id');
	}

	public function experiences()
	{
		return $this->hasMany(CandidatExperience::class, 'utilisateur', 'id');
	}

	public function references()
	{
		return $this->hasMany(CandidatReference::class, 'utilisateur', 'id');
	}

	public function portfolios()
	{
		return $this->hasMany(CandidatPortfolio::class, 'utilisateur', 'id');
	}

	public function competences()
	{
		return $this->hasMany(CandidatCompetence::class, 'utilisateur', 'id');
	}

	public function centres()
	{
		return $this->hasMany(CandidatCentre::class, 'utilisateur', 'id');
	}

	public function langues()
	{
		return $this->hasMany(CandidatLangue::class, 'utilisateur', 'id');
	}

	public function candidatures()
	{
		return $this->hasMany(Candidature::class, 'utilisateur', 'id');
	}
}
