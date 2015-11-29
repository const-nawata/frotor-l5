@extends('layouts.main')


@section('content')

{!! Form::open(['url'=>'/faucetation','method'=>'post', 'role'=>'form','id'=>'faucetForm','name'=>'faucetForm']) !!}
{!! Form::close() !!}

<div class="panel panel-info main-panel-content">
	<div class="panel-heading index-heard">

<table class="main-tbl">
	<tr>

@if( (bool)$faucet->id )
		<td class="faucet-id-td">Id: <span class="badge" id="faucet_id">{!! $faucet->id !!}</td>

		<td><div id="info" class="descr-txt">{!! $faucet->info !!}</div></td>

		<td class="last-payout-txt">Last payout on <span id="last_pay">{!! date('d-m-Y', strtotime($faucet->updated)) !!}</span></td>
		<td id="act_after_td" class="input-control-td"><span class="lbl-inp">Show after&nbsp;</span>
			{!! Form::text('cduration',$faucet->duration,['id'=>'cduration','class'=>'txt-inp']) !!} <span id="time_unit_name">{!! $time_units[$faucet->time_unit] !!}</span>
			{!! Form::hidden('oduration',$faucet->duration,['id'=>'oduration']) !!}
			{!! Form::hidden('time_unit',$faucet->time_unit,['id'=>'time_unit']) !!}
		</td>

		<td id="priority_td" class="input-control-td"><span class="lbl-inp">Priority&nbsp;</span>
			{!! Form::text('priority',$faucet->priority,['id'=>'priority','class'=>'txt-inp']) !!}
		</td>
@else
		<td class="no-active-td">&#8212; NO ACTIVE FAUCETS &#8212;</td>
@endif
		<td class="num-info-td">
			<table cellspacing="0" cellpadding="0" border="0" class="faucets-info-tbl">
				<tr><td rowspan="2" class="faucet-prompt-td">Faucets</td><td>all</td><td class="faucet-count-td" id="n_all">{!! $n_all !!}</td></tr>
				<tr><td>active</td><td id="n_act" class="faucet-count-td">{!! $n_act !!}</td></tr>
			</table>
		</td>

		<td class='tool-btn-td'>
			<div class="btn-group {!! $btn_grp_css !!} pull-right" role="group">
				{!! Form::button('',['id'=>'settings_btn','class'=>'btn btn-default glyphicon glyphicon-wrench','title'=>'Settings']) !!}

@if( (bool)$faucet->id )
				{!! Form::button('',['id'=>'disable_btn','class'=>'btn btn-default glyphicon glyphicon-remove','title'=>'Disable']) !!}
				{!! Form::button('',['id'=>'load_btn','class'=>'btn btn-default glyphicon glyphicon-play','title'=>'Show current faucet']) !!}
@endif

				{!! Form::button('',['id'=>'next_btn','class'=>'btn btn-default glyphicon glyphicon-forward','title'=>'Next']) !!}
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
	var btn_id;

	faucet_id = {!! $faucet->id !!};
	faucet_url = "{!! $faucet->url !!}";

	$("button").click(function(ev){
		btn_id	= $(this).attr("id");

		switch( btn_id ){
			case "next_btn":
				$('#faucetForm').submit();
				break;

			case "disable_btn":
				affirm( "Confirmation required", "Are you sure you want to disable this faucet?", function(){
					$('#faucetForm').submit();
				});
				break;

			case "load_btn":
				loadFaucet();
				break;

			case "settings_btn":
				window.location="/set/"+faucet_id;
				break;

			default:
		}
	});

	$('#faucetForm').submit(function(event){
		event.preventDefault();
		postFaucet($(this).attr('action'),btn_id);
		return false;
	});

});
</script>
@stop
