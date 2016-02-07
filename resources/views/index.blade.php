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

		<td class="last-payout-txt">Last payout on <span id="last_pay">{!! $last_pay !!}</span></td>

		<td id="priority_td" class="priority-td">
			<div class="input-group">
				<span class="input-group-addon">Priority&nbsp;</span>
				{!! Form::text('priority',$faucet->priority,['id'=>'priority','class'=>'form-control']) !!}
				{!! Form::hidden('order',$order,['id'=>'order']) !!}
				<span class="input-group-btn">
		        	{!! Form::button('',['id'=>'change_order_btn','class'=>'btn btn-default glyphicon glyphicon-arrow-'.($order=='asc'?'up':'down').' order-btn','title'=>'Set order '.($order!='asc'?'ascended':'descended')]) !!}
				</span>
			</div>
		</td>

		<td id="act_after_td" class="duration-td">
			<div class="input-group">
				<span class="input-group-addon">Minutes to wait&nbsp;</span>
				{!! Form::text('cduration',$faucet->duration,['id'=>'cduration','class'=>'form-control']) !!}
				<span class="input-group-btn">
		        	{!! Form::button('',['id'=>'save_duration_btn','class'=>'btn btn-default glyphicon glyphicon-floppy-disk save-btn','title'=>'Save']) !!}
				</span>
			</div>
			{!! Form::hidden('oduration',$faucet->duration,['id'=>'oduration']) !!}
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
	var btn_id
	;

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

			case "save_duration_btn":
				$('#faucetForm').submit();
				break;

			case "change_order_btn":

				if($('#order').val()=='asc'){
					$('#order').val('desc');

					$('#change_order_btn')
						.removeClass('glyphicon-arrow-up')
						.addClass('glyphicon-arrow-down')
						.attr("title","Set order ascended");
				}else{
					$('#order').val('asc');

					$('#change_order_btn')
					.removeClass('glyphicon-arrow-down')
					.addClass('glyphicon-arrow-up')
					.attr("title","Set order descended");
				}

				$('#faucetForm').submit();
				break;

			default:
				alert("Undefind button (link). Button id: "+btn_id);
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
