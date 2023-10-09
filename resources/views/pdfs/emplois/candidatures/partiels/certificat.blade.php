@if(isset($certificats))
<h2>Certificats: </h2>
<p>
	@foreach ($certificats as $certificat)
	<ul>
		<li><strong>Identifiant du certificat: </strong>{{ $certificat->identifiant }}<</li>
		<li><strong>Intitulé du certificat: </strong>{{ $certificat->intitule }}<</li>
		<li><strong>Domaine d'études: </strong>{{ $certificat->domaineEtude()->first()->intitule }}<</li>
		<li><strong>Structure formatrice: </strong>{{ $certificat->organisation }}<</li>
		<li><strong>Date de début: </strong>{{ $certificat->dateDebut }}<</li>
		<li><strong>Date de fin: </strong>{{ $certificat->dateFin }}<</li>
		<li><strong>Date de délivrance: </strong>{{ $certificat->dateDelivrance }}<</li>
	</ul><br>
	@endforeach
</p>
@endif
