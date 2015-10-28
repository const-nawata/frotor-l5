@include('blocks/header')
































<div class="panel panel-info main-panel-content">
	<div class="panel-heading index-heard">


<table class="main-tbl">
	<tr>


		<td><p class="faucet-id-p" style="float: right;">Id: <span class="badge">42</span></p></td>

		<td id="act_after_td" class="input-control-td hided">Show after
			<input type="text" id="cduraion" name="cduraion" class="time-inp" /> sec.
			<input type="hidden" id="oduraion" name="oduraion" />
		</td>

		<td>
			<div class="btn-group" role="group">
				<button onclick="getNextFaucet();" type="button" class="btn btn-default btn-sm">Next</button>
				<button type="button" class="btn btn-default btn-sm">Load</button>
				<button type="button" class="btn btn-default btn-sm">Settins</button>
			</div>
		</td>

	</tr>
</table>


	</div>

	<div class="panel-body ifraim-panel">
	   <iframe id="main_fraim" class="main-fraim" src="http://rollingfaucet.com/"></iframe>
	</div>
</div>



<?php /* ?>

<div class="panel panel-info main-panel-content">
<div class="panel-heading index-heard">


		<div class="btn-group navbar-left" role="group" aria-label="...">
			<button onclick="getNextFaucet();" type="button" class="btn btn-default btn-sm">Next</button>
			<button type="button" class="btn btn-default btn-sm">Load</button>
			<button type="button" class="btn btn-default btn-sm">Settins</button>
		</div>

		<ul class="nav navbar-nav navbar-left">
			<li><h4>Id: <span class="badge">42</span></h4></li>
			<li>HHHHHH</li>
			<li>HHHHHH</li>
		</ul>

</div>
</div>

<?php */ ?>

@include('blocks/footer')