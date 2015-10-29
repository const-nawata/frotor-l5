@extends('layouts.main')


@section('content')

{!! Form::open(['url'=>'/nextfaucet','method'=>'post', 'role'=>'form','id'=>'faucetForm','name'=>'faucetForm']) !!}
{!! Form::close() !!}


<div class="panel panel-info main-panel-content">
	<div class="panel-heading index-heard">

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
				<button type="button" class="btn btn-default glyphicon glyphicon-cog" title="Settigs"></button>
				<button type="button" class="btn btn-default glyphicon glyphicon glyphicon-remove" title="Disable"></button>
				<button type="button" class="btn btn-default glyphicon glyphicon-refresh" onclick="loadFaucet();" title="(re-)Load"></button>
				<button type="button" class="btn btn-default glyphicon glyphicon-forward" onclick="$('#faucetForm').submit();" title="Next"></button>
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

@section('js_extra')
<script type="text/javascript">

$(document).ready(function(){
	faucet_id = {!! $faucet->id !!};
	faucet_url = "{!! $faucet->url !!}";

	$("#faucetForm").on('submit', function(event){
		event.preventDefault();
		getNextFaucet($(this).attr('action'));
        return false;
	});

});
</script>

@stop
