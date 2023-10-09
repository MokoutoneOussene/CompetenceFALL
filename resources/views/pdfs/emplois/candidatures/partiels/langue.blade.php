@if(isset($langues))
<h2>Langues: </h2>
<p>
	@foreach ($langues as $langue)
	<ul>
		<li><strong>Intitulé de la langue: </strong>{{ $langue->intitule }}</li>
		<li><strong>Niveau de langue: </strong>{{ $langue->niveau }}</li>
		<li><strong>Langue parlée: </strong>{{ $langue->parle ? "Oui" : "Non" }}</li>
		<li><strong>Langue lue: </strong>{{ $langue->lu ? "Oui" : "Non" }}</li>
		<li><strong>Langue écrite: </strong>{{ $langue->ecrit ? "Oui" : "Non" }}</li>
	<</ul><br>
	@endforeach
</p>
@endif
