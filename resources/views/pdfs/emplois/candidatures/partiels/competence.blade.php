@if(isset($competence))
<h2>Compétences: </h2>
<p>
	@foreach ($competences as $competence)
	<ul>
        <li><strong>{{ $competence->intitule }}</strong></li>
	</ul>
	@endforeach
</p>
@endif
