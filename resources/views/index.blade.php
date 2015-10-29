@extends('layouts.main')

<?php
/*
//$tt='&nbsp;';

//	http://frotor-l5.btc/showdummy

//		{{ url('/showdummy') }}

//	http://rollingfaucet.com/

*/
?>

@section('content')

<div class="panel panel-info main-panel-content">
	<div class="panel-heading index-heard">

<input type="hidden" name="_token" value="{{ csrf_token() }}">

<table class="main-tbl">
	<tr>
		<td><p class="faucet-id-p" style="float: right;">Id: <span class="badge" id="id_faucet">{!! $faucet->id !!}</span></p></td>

		<td id="act_after_td" class="input-control-td hided">Show after
			<input type="text" id="cduraion" name="cduraion" class="time-inp" value="{!! $faucet->duration !!}" /> sec.
			<input type="hidden" id="oduraion" name="oduraion" value="{!! $faucet->duration !!}" />
		</td>

		<td id="priority_td" class="input-control-td">Priority&nbsp;
			<input type="text" id="priority" name="priority" class="time-inp" value="{!! $faucet->priority !!}" />
		</td>

		<td class="num-info-td">
			<table cellspacing="0" cellpadding="0" border="0" class="faucets-info-tbl">
				<tr><td rowspan="2" class="faucet-prompt-td">Faucets</td><td>all</td><td>{!! $all !!}</td></tr>
				<tr><td>active</td><td>{!! $active !!}</td></tr>
			</table>
		</td>

		<td>
			<div class="btn-group" role="group">
				<button type="button" class="btn btn-default btn-sm">Settins</button>
				<button type="button" class="btn btn-default btn-sm" onclick="loadFaucet({!! $faucet->id !!},'{!! $faucet->url !!}');">Load</button>
				<button type="button" class="btn btn-default btn-sm" onclick="getNextFaucet();">Next</button>
			</div>
		</td>

	</tr>
</table>


	</div>

	<div class="panel-body ifraim-panel">
	   <iframe id="main_fraim" class="main-fraim" src="{{ url('/showdummy') }}"></iframe>
	</div>


</div>
@stop
