@if(isset($experiences))
<h2>Expériences professionnelles: </h2>
<p>
	@foreach ($experiences as $experience)
	<ul>
        <li><strong>Titre du poste: </strong>{{ $experience->poste }}</li>
		<li><strong>Type de contrat: </strong>{{ $experience->contrat }}</li>
		<li><strong>Nom de l'organisation: </strong>{{ $experience->organisation }}</li>
        <li><strong>Domaine d'expertise réquise: </strong>{{ $experience->domaine }}</li>
        <li><strong>Durée (en années): </strong>{{ $experience->duree }}</li>
        <li><strong>Date de début: </strong>{{ $experience->dateDebut }}</li>
        <li><strong>Date de fin: </strong>{{ $experience->dateFin }}</li>
        <li><strong>Lieu: </strong>{{ $experience->lieu }}</li>
        <li><strong>Pays: </strong>{{ $experience->pays()->first()->nom }}</li>
        <li><strong>Type de lieu: </strong>{{ $experience->typeLieu }}</li>
        <li><strong>Tâches: </strong>{{ $experience->taches }}</li>
        <li><strong>Nom et prénoms du supérieur: </strong>{{ $experience->nomSuperieur }} {{ $experience->prenomsSuperieur }}</li>
        <li><strong>Poste du supérieur: </strong>{{ $experience->posteSuperieur }}</li>
        <li><strong>Contact téléphonique du supérieur: </strong>+{{ $experience->indicatifTelephoniqueSuperieur }} {{ $experience->telephoneSuperieur }}</li>
	</ul><br>
	@endforeach
</p>
@endif
