@if(isset($diplomes))
<h2>Diplômes: </h2>
<p>
	@foreach ($diplomes as $diplome)
	<ul>
		<li><strong>Statut d'obtention du diplôme: </strong>{{ $diplome->statutObtention }}</li>
		<li><strong>Identifiant du diplôme: </strong>{{ $diplome->identifiant }}<</li>
		<li><strong>Intitulé du diplôme: </strong>{{ $diplome->intitule }}<</li>
		<li><strong>Domaine d'études: </strong>{{ $diplome->domaineEtude()->first()->intitule }}<</li>
		<li><strong>Niveau d'études: </strong>{{ $diplome->niveauEtude()->first()->intitule }}<</li>
		<li><strong>Niveau de spécialisation: </strong>{{ $diplome->niveauSpecialisation()->first()->intitule }}<</li>
		<li><strong>Structure formatrice: </strong>{{ $diplome->organisation }}<</li>
		<li><strong>Date de début: </strong>{{ $diplome->dateDebut }}<</li>
		<li><strong>Date de fin: </strong>{{ $diplome->dateFin }}<</li>
		<li><strong>Date de délivrance: </strong>{{ $diplome->dateDelivrance }}<</li>
	</ul><br>
	@endforeach
</p>
@endif
