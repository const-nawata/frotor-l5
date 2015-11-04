@extends('layouts.main')


@section('content')

{!! Form::open(['url'=>'/faucetation','method'=>'post', 'role'=>'form','id'=>'faucetForm','name'=>'faucetForm']) !!}
{!! Form::close() !!}


<div class="panel panel-info main-panel-content">
	<div class="panel-heading index-heard">

<table class="main-tbl">
	<tr>
		<td>

<table border="0" class="desc-tbl">
	<tr>
		<td class="faucet-id-td">Id: <span class="badge" id="faucet_id">{!! $faucet->id !!}</td>
		<td><div class="descr-txt">Keffiyeh food truck humblebrag, next level +1 cornhole letterpress brooklyn austin try-hard direct trade cliche VHS. Pork belly small batch brooklyn butcher. Waistcoat tumblr shabby chic, scenester austin irony squid chillwave tilde humblebrag salvia franzen.</div></td>
		<td class="last-payout-txt">Last payout on <span>10-10-2015</span></td>
	</tr>
</table>

		</td>

		<td id="act_after_td" class="input-control-td">Show after&nbsp;
			{!! Form::text('cduraion',$faucet->duration,['id'=>'cduraion','class'=>'txt-inp']) !!} sec.
			{!! Form::hidden('oduraion',$faucet->duration,['id'=>'oduraion']) !!}
		</td>

		<td id="priority_td" class="input-control-td">Priority&nbsp;
			{!! Form::text('priority',$faucet->priority,['id'=>'priority','class'=>'txt-inp']) !!}
		</td>

		<td class="num-info-td">
			<table cellspacing="0" cellpadding="0" border="0" class="faucets-info-tbl">
				<tr><td rowspan="2" class="faucet-prompt-td">Faucets</td><td>all</td><td>{!! $n_all !!}</td></tr>
				<tr><td>active</td><td>{!! $n_act !!}</td></tr>
			</table>
		</td>

		<td>
			<div class="btn-group" role="group">
				{!! Form::button('',['id'=>'settings_btn','class'=>'btn btn-default glyphicon glyphicon glyphicon-cog','title'=>'Settings']) !!}
				{!! Form::button('',['id'=>'disable_btn','class'=>'btn btn-default glyphicon glyphicon glyphicon-remove','title'=>'Disable']) !!}
				{!! Form::button('',['id'=>'load_btn','class'=>'btn btn-default glyphicon glyphicon-refresh','title'=>'(re-)Load']) !!}
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
			case "disable_btn":
				$('#faucetForm').submit();
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
