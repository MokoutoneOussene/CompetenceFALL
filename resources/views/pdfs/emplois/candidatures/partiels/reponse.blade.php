@if(isset($reponses))
<h2>Réponses aux questions: </h2>
<p>
	@foreach ($reponses as $reponse)
	<ul>
		<li><strong>Question: </strong>{{ $reponse->question()->first()->contenu }}</li>
		<li><strong>Question notée : </strong>{{ $reponse->question()->first()->typeQuestion == 'vraiFaux' ? "Oui" : "Non" }}</li>
		<li><strong>Bonne reponse à la question: </strong>{{ $reponse->question()->first()->typeQuestion == 'vraiFaux' ? ($reponse->question()->first()->bonneReponse ? "Oui" : "Non" ) : "___"}}</li>
		<li><strong>Reponse du candidat: </strong>{{ $reponse->question()->first()->typeQuestion == 'vraiFaux' ? ($reponse->reponse ? "Oui" : "Non") : "___" }}</li>
		<li><strong>Contenu de la reponse: </strong>{{ $reponse->question()->first()->typeQuestion == 'reponseCourte' ? $reponse->contenu : "___" }}</li>
	<</ul><br>
	@endforeach
</p>
@endif
