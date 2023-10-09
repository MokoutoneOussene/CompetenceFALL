@if (isset($personne))
<h2>Informations personnelles du candidat: </h2>
<p>
	<ul>
		<li><strong>Nom: </strong>{{ $personne->nom }}</li>
		<li><strong>Prénoms: </strong>{{ $personne->prenoms }}</li>
		<li><strong>Date de naissance: </strong>{{ $personne->dateNaissance }}</li>
		<li><strong>Genre: </strong>{{ $personne->genre }}</li>
		<li><strong>Lieu de naissance: </strong>{{ $personne->lieuNaissance }}</li>
		<li><strong>Pays de naissance: </strong>{{ $personne->paysNaissance()->first()->nom }}</li>
		<li><strong>Lieu de résidence: </strong>{{ $personne->lieuResidence }}</li>
		<li><strong>Pays de résidence: </strong>{{ $personne->paysResidence()->first()->nom }}</li>
		<li><strong>Nationalités: </strong>{{ $personne->nationalites }}</li>
	</ul>
</p>
@endif
