@if(isset($references))
<h2>Personnes de référence: </h2>
<p>
	@foreach ($references as $reference)
	<ul>
        <li><strong>Nom et prénoms: </strong>{{ $reference->nom }} {{ $reference->prenoms }}</li>
        <li><strong>Poste: </strong>{{ $reference->poste }}</li>
		<li><strong>Nom de l'organisation: </strong>{{ $reference->organisation }}</li>
		<li><strong>Email: </strong>{{ $reference->email }}</li>
		<li><strong>Contact téléphonique: </strong>+{{ $reference->indicatifTelephonique }} {{ $reference->telephone }}</li>
		<li><strong>Relation avec la personne de référence: </strong>{{ $reference->relation }}</li>
		<li><strong>Date de début: </strong>{{ $reference->dateDebut }}</li>
        <li><strong>Date de fin: </strong>{{ $reference->dateFin }}</li>
	</ul><br>
	@endforeach
</p>
@endif
