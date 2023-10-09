@if(isset($portfolios))
<h2>Réalisations: </h2>
<p>
	@foreach ($portfolios as $portfolio)
	<ul>
        <li><strong>Intitule de la réalisation: </strong>{{ $portfolio->intitule }}</li>
        <li><strong>Date de la réalisation: </strong>{{ $portfolio->date }}</li>
		<li><strong>Description de la réalisation: </strong>{{ $portfolio->description }}</li>
		<li><strong>URL: </strong>{{ $portfolio->url }}</li>
	</ul><br>
	@endforeach
</p>
@endif
