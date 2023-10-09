@if(isset($centres))
<h2>Centres d'intérêts: </h2>
<p>
	@foreach ($centres as $centre)
	<ul>
        <li><strong>{{ $centre->intitule }}</strong></li>
	</ul>
	@endforeach
</p>
@endif
