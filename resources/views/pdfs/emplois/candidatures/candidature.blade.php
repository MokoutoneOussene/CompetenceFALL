<!DOCTYPE html>
<html lang="fr">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title>Candidature n° </title>
	@include('pdfs.emplois.candidatures.partiels.css')
</head>

<body>
	<div class="container">

		@include('pdfs.emplois.candidatures.partiels.header')

		@include('pdfs.emplois.candidatures.partiels.organization-info')

		@php
			$candidature = $donnees['candidature'];
			$offre = $donnees['offre'];
			$motivation = $donnees['offre'];
			$diplomes = $donnees['diplomes'];
			$certificats = $donnees['certificats'];
			$experiences = $donnees['experiences'];
			$references = $donnees['references'];
			$competences = $donnees['competences'];
			$langues = $donnees['langues'];
			$portfolios = $donnees['portfolios'];
			$langues = $donnees['langues'];
			$centres = $donnees['centres'];
			$personne = $donnees['personne'];
			$reponses = $candidature->reponses()->get();
		@endphp

		<h1>Candidature : {{ $candidature->id }}</h1>

		<h3>Identifiant de l'offre : {{ $candidature->offre }}</h3>
		<h3>Identifiant du candidat : {{ $candidature->utilisateur }}</h3>

		<h2>Informations sur la candidature</h2>
		<p>
			<ul>
				<li><strong>Intitule de la candidature: </strong>{{ $candidature->intitule }}</li>
				<li><strong>Statut de soumission: </strong>{{ $candidature->statutSoumission }}</li>
				<li><strong>Statut d'examination: </strong>{{ $candidature->statutExamination }}</li>
				<li><strong>Note pour les préréquis diplômes: </strong>{{ $candidature->noteDiplome }}</li>
				<li><strong>Note pour les préréquis certififcats: </strong>{{ $candidature->noteCertificat }}</li>
				<li><strong>Note pour l'expérience professionnelle: </strong>{{ $candidature->noteExperience }}</li>
				<li><strong>Note pour les langues: </strong>{{ $candidature->noteLangue }}</li>
				<li><strong>Note pour les réponses aux questions: </strong>{{ $candidature->noteQuestion }}</li>
				<li><strong>Note globale: </strong>{{ $candidature->noteGlobale }}</li>
				<li><strong>Observations de l'examinateur: </strong>{{ $candidature->observations }}</li>
			</ul>
		</p>

		@include('pdfs.emplois.candidatures.partiels.personne')
		@include('pdfs.emplois.candidatures.partiels.diplome')
		@include('pdfs.emplois.candidatures.partiels.certificat')
		@include('pdfs.emplois.candidatures.partiels.experience')
		@include('pdfs.emplois.candidatures.partiels.reference')
		@include('pdfs.emplois.candidatures.partiels.portfolio')
		@include('pdfs.emplois.candidatures.partiels.langue')
		@include('pdfs.emplois.candidatures.partiels.competence')
		@include('pdfs.emplois.candidatures.partiels.centre')
		@include('pdfs.emplois.candidatures.partiels.reponse')

		<div class="footer">
			<p>Imprimé par : </p>
		</div>
		<div><p>© 2023 - Competence For All</p></div>
	</div>
</body>
