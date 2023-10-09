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
			$convocation = $donnees['convocation'];
		@endphp

		<h1>Convocation : {{ $convocation->id }}</h1>

		<h3>Identifiant de la candidature : {{ $convocation->candidature }}</h3>

		<h2>Informations</h2>
		<p>
			<ul>
				<li><strong>Objet: </strong>{{ $candidature->objet }}</li>
				<li><strong>Lieu: </strong>{{ $candidature->lieu }}</li>
				<li><strong>Pays: </strong>{{ $candidature->pays()->first()->nom }}</li>
				<li><strong>Adresse: </strong>{{ $candidature->adresse }}</li>
				<li><strong>Date: </strong>{{ $candidature->date }}</li>
				<li><strong>Contact: </strong>+{{ $candidature->indicatifTelephonique }} {{ $candidature->telephone }}</li>
				<li><strong>Consignes: </strong>{{ $candidature->consignes }}</li>
			</ul>
		</p>
		<div class="footer">
			<p>Imprimé par : </p>
		</div>
		<div><p>© 2023 - Competence For All</p></div>
	</div>
</body>
