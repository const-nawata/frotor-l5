@include('blocks/header')

<div class="panel panel-info main-panel-content">
	<div class="panel-heading index-heard">
		<div class="btn-group" role="group" aria-label="...">
			<button onclick="getNextFaucet();" type="button" class="btn btn-default">Next</button>
			<button type="button" class="btn btn-default">Load</button>
			<button type="button" class="btn btn-default">Settins</button>
		</div>
	</div>

	<div class="panel-body ifraim-panel">
	   <iframe id="main_fraim" class="main-fraim" src="http://rollingfaucet.com/"></iframe>
	</div>
</div>

@include('blocks/footer')