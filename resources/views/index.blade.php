@extends('layouts.main')

@section('content')
<div class="panel panel-info main-panel-content">
	<div class="panel-heading index-heard">


<table class="main-tbl">
	<tr>
		<td><p class="faucet-id-p" style="float: right;">Id: <span class="badge">42</span></p></td>

		<td id="act_after_td" class="input-control-td hided">Show after
			<input type="text" id="cduraion" name="cduraion" class="time-inp" /> sec.
			<input type="hidden" id="oduraion" name="oduraion" />
		</td>

		<td id="priority_td" class="input-control-td">Priority&nbsp;
			<input type="text" id="priority" name="priority" class="time-inp" />
		</td>

		<td class="num-info-td">
			Faucets (all / active): <span id="n_all_span"></span> / <span id="n_active_span"></span>
			<span id="last_payment" class="last-payment"></span>
		</td>

		<td>
			<div class="btn-group" role="group">
				<button type="button" class="btn btn-default btn-sm">Settins</button>
				<button type="button" class="btn btn-default btn-sm">Load</button>
				<button type="button" class="btn btn-default btn-sm" onclick="getNextFaucet();">Next</button>
			</div>
		</td>

	</tr>
</table>


	</div>

	<div class="panel-body ifraim-panel">
	   <iframe id="main_fraim" class="main-fraim" src="http://rollingfaucet.com/"></iframe>
	</div>
</div>
@stop
