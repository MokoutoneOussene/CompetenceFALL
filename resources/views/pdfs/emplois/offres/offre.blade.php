<!DOCTYPE html>
<html>
<head>
	<title>Offre d'emploi pour {{ ucfirst($donnees['offre']->poste) }}</title>
	<style>
		body {
			font-family: Arial, sans-serif;
			background-color: #f4f4f4;
			margin: 0;
			padding: 0;
		}
		.container {
			width: 80%;
			max-width: 800px;
			margin: 20mm auto; /* Marges de 20 mm pour toutes les côtés (A4) */
			background-color: #fff;
			padding: 20px;
			border-radius: 5px;
			box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
		}
		.header {
			text-align: right;
			margin-bottom: 20px;
		}
		.header img {
			max-width: 100px;
			height: auto;
		}
		.organization-info {
			text-align: right;
			color: #1e2a78; /* Bleu foncé */
			margin-bottom: 20px;
		}
		h1 {
			color: #1e2a78; /* Bleu foncé */
			margin-bottom: 20px;
		}
		p {
			line-height: 1.6;
			margin-bottom: 10px; /* Marge entre les paragraphes */
		}
		h2 {
			color: #ff6600; /* Orange */
			margin-top: 20px;
		}
		ol {
			margin-left: 20px; /* Marge pour la liste ordonnée */
			margin-bottom: 10px; /* Marge entre les listes ordonnées */
		}
		ul {
			margin-left: 20px; /* Marge pour la liste à puces */
			margin-bottom: 10px; /* Marge entre les listes à puces */
		}
		li {
			margin-bottom: 5px;
		}
		.footer {
			margin-top: 30px;
			border-top: 1px solid #ccc;
			padding-top: 10px;
			text-align: right;
			font-size: 12px;
			color: #777;
		}
	</style>
</head>
<body>
	<div class="container">
		<div class="header">
			<img src="{{ public_path('storage/cfai-logo-transparent.png') }}" alt="Logo de Competence For All">
		</div>

		<div class="organization-info">
			<p><strong>Competence For All</strong></p>
			<p><i>La clé des compétences</i></p>
			<p>Adresse : Rue 25.16, Somgandé, Ouagadougou</p>
			<p>Téléphone : <a href="tel:+22676006655" alt="Cliquer pour appeler.">+226 76 00 66 55</a></p>
			<p>Site Web : <a href="https://www.competenceforall.com" alt="Cliquer pour visiter.">www.competenceforall.com</a></p>
		</div>

		<h1>Offre d'emploi : {{ $donnees['offre']->poste }}</h1>

		<h3>Identifiant de l'offre : {{ $donnees['offre']->id }}</h3>

		<h2>Détails sur l'offre :</h2>
		<p>
			<ul>
				<li><strong>Titre du poste: </strong>{{ $donnees['offre']->poste }}</li>
				<li><strong>Type de contrat: </strong>{{ $donnees['offre']->contrat }}</li>
				<li><strong>Nom de l'organisation: </strong>{{ ucfirst($donnees['offre']->nomOrganisation) }}</li>
				<li><strong>Domaine d'activités: </strong>{{ ucfirst($donnees['offre']->domaine) }}</li>
				<li><strong>Nombre de postes à pourvoir: </strong>{{ $donnees['offre']->places }}</li>
				<li><strong>Ville du poste: </strong>{{  $donnees['offre']->lieu }}</li>
				<li><strong>Pays du poste: </strong>{{  $donnees['offre']->pays()->first(['nom'])->nom }}</li>
				<li><strong>Type de lieu: </strong>{{ $donnees['offre']->typeLieu }}</li>
				<li><strong>Rémunération: </strong>@if($donnees['offre']->remuneration) {{ $donnees['offre']->remuneration }} F CFA @else __ @endif</li>
				<li><strong>Date limite pour postuler: </strong>@if($donnees['offre']->dateLimite) {{ $donnees['offre']->dateLimite }} @else __ @endif</li>
				<li><strong>Date de prise de fonction: </strong>@if($donnees['offre']->dateDebutPoste) {{ $donnees['offre']->dateDebutPoste }} @else __ @endif</li>
				<li><strong>Description de l'offre: </strong>@if($donnees['offre']->description) {{ $donnees['offre']->description }} @else __ @endif</li>
				<li><strong>Avantages du poste: </strong>@if($donnees['offre']->avantages) {{ $donnees['offre']->avantages }} @else __ @endif</li>
				<li><strong>Préréquis pour postuler: </strong>@if($donnees['offre']->prerequis) {{ $donnees['offre']->prerequis }} @else __ @endif</li>
				<li><strong>Consignes pour postuler: </strong>@if($donnees['offre']->consignes) {{ $donnees['offre']->consignes }} @else __ @endif</li>
				<li><strong>Informations sur l'organisation: </strong>@if($donnees['offre']->infosOrganisation) {{ $donnees['offre']->infosOrganisation }} @else __ @endif</li>
				<li><strong>Informations complémentaires: </strong>@if($donnees['offre']->infosComplementaires) {{ $donnees['offre']->infosComplementaires }} @else __ @endif</li>
				<li><strong>Moyenne minimale des critères à remplir: </strong>{{ $donnees['offre']->pourcentageMoyenne }}%</li>
			</ul>
		</p>

		@if($donnees['offre']->prerequisDiplomes()->count())
		<h2>Préréquis - Diplômes :</h2>
		<ol>
			@php $i = 0; @endphp
			@foreach($donnees['offre']->prerequisDiplomes()->get() as $diplome)
			<li>
				Prerequis diplôme {{ $i + 1 }} :
				<ul>
					<li>Domaine d'études: @if($diplome->domaineEtude) {{ $diplome->domaineEtude()->first(['intitule'])->intitule }} @else __ @endif</li>
					<li>Note domaine d'études: @if($diplome->domaineEtude) {{ $diplome->noteDomaine }} @else __ @endif</li>
					<li>Niveau d'études: @if($diplome->niveauEtude) {{ $diplome->niveauEtude()->first()->intitule }} @else __ @endif</li>
					<li>Note niveau d'études: @if($diplome->niveauEtude) {{ $diplome->niveauEtude()->first()->niveau }} @else __ @endif</li>
					<li>Niveau de spécialisation: @if($diplome->niveauSpecialisation) {{ $diplome->niveauSpecialisation()->first()->intitule }} @else __ @endif</li>
					<li>Note niveau de spécialisation: @if($diplome->niveauSpecialisation) {{ $diplome->niveauSpecialisation()->first()->niveau }} @else __ @endif</li>
				</ul>
			</li>
			@php $i++; @endphp
			@endforeach
		</ol>
		@endif

		@if($donnees['offre']->prerequisCertificats()->count())
		<h2>Préréquis - Certificats :</h2>
		<ol>
			@php $i = 0; @endphp
			@foreach($donnees['offre']->prerequisCertificats()->get() as $certificat)
			<li>
				Prerequis certificat {{ $i + 1 }} :
				<ul>
					<li>Domaine d'études: {{ $certificat->domaineEtude()->first(['intitule'])->intitule }}</li>
					<li>Note domaine d'études: {{ $certificat->noteDomaine }}</li>
				</ul>
			</li>
			@php $i++; @endphp
			@endforeach
		</ol>
		@endif

		@if($donnees['offre']->prerequisExperiences()->count())
		<h2>Préréquis - Expériences professionnelles :</h2>
		<ol>
			@php $i = 0; @endphp
			@foreach($donnees['offre']->prerequisExperiences()->get() as $experience)
			<li>
				Prerequis expérience professionnelles {{ $i + 1 }} :
				<ul>
					<li>Domaine d'études: {{ $experience->domaineEtude()->first(['intitule'])->intitule }}</li>
					<li>Note domaine d'études: @if($experience->noteDomaine) {{ $experience->noteDomaine }} @else __ @endif</li>
					<li>Durée de l'expérience professionnelle (en années): @if($experience->duree) {{ $experience->duree }} @else __ @endif</li>
				</ul>
			</li>
			@php $i++; @endphp
			@endforeach
		</ol>
		@endif

		@if($donnees['offre']->prerequisLangues()->count())
		<h2>Préréquis - Langues :</h2>
		<ol>
			@php $i = 0; @endphp
			@foreach($donnees['offre']->prerequisLangues()->get() as $langue)
			<li>
				Prerequis langue {{ $i + 1 }} :
				<ul>
					<li>Intitulé de la langue: {{ $langue->intitule }}</li>
					<li>Note de la langue: @if($langue->noteLangue) {{ $langue->noteLangue }} @else __ @endif</li>
					<li>Niveau de langue: @if($langue->niveau) {{ $langue->niveau }} @else __ @endif</li>
					<li>Note niveau de langue: @if($langue->niveau) {{ $langue->noteNiveau }} @else __ @endif</li>
					<li>Langue parlée: @if($langue->statutParle) Oui @else Non @endif</li>
					<li>Note langue parlée: @if($langue->statutParle) {{ $langue->noteStatutParle }} @else __ @endif</li>
					<li>Langue lue: @if($langue->statutLu) Oui @else Non @endif</li>
					<li>Note langue lue: @if($langue->statutLu) {{ $langue->noteStatutLu }} @else __ @endif</li>
					<li>Langue écrite: @if($langue->statutEcrit) Oui @else Non @endif</li>
					<li>Note langue écrite: @if($langue->statutEcrit) {{ $langue->noteStatutEcrit }} @else __ @endif</li>
				</ul>
			</li>
			@php $i++; @endphp
			@endforeach
		</ol>
		@endif

		@if($donnees['offre']->questions()->count())
		<h2>Questions complémentaires à l'offre :</h2>
		<ol>
			@php $i = 0; @endphp
			@foreach($donnees['offre']->questions()->get() as $question)
			<li>
				Question {{ $i + 1 }} :
				<ul>
					<li>Contenu de la question: {{ $question->contenu }}</li>
					<li>Question notée: @if($question->typeQuestion == 'vraiFaux') Oui @else Non @endif</li>
					<li>Note pour la bonne réponse: @if($question->typeQuestion == 'vraiFaux') {{ $question->note }} @else __ @endif</li>
					<li>Bonne réponse: @if($question->typeQuestion == 'vraiFaux') @if($question->bonneReponse) Vrai @else Faux @endif @else __ @endif</li>
				</ul>
			</li>
			@php $i++; @endphp
			@endforeach
		</ol>
		@endif

		<!-- Ajoutez d'autres détails de l'offre ici -->

		<div class="footer">
			<p>Créé par : @if($donnees['offre']->auteurCreation) {{ $donnees['offre']->auteurCreation()->first(['email'])->email }} @else __ @endif</p>
			<p>Créé le : {{ $donnees['offre']->dateCreation }}</p>
			<p>Début de publication : @if($donnees['offre']->dateDebutPublication) {{ $donnees['offre']->dateDebutPublication }} @else __ @endif</p>
			<p>Fin de publication : @if($donnees['offre']->dateFinPublication) {{ $donnees['offre']->dateFinPublication }} @else __ @endif</p>
			<p>Dernière mise à jour par : @if($donnees['offre']->auteurMiseAJour) {{ $donnees['offre']->auteurMiseAJour()->first(['email'])->email }} @else __ @endif</p>
			<p>Dernière mise à jour le : @if($donnees['offre']->dateMiseAJour) {{ $donnees['offre']->dateMiseAJour }} @else __ @endif</p>
		</div>
		<div><p>© {{ date('Y') }} - Competence For All</p></div>
	</div>
</body>
</html>
