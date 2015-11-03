@extends('layouts.main')


@section('content')

{!! Form::open(['url'=>'/faucetation','method'=>'post', 'role'=>'form','id'=>'faucetForm','name'=>'faucetForm']) !!}
{!! Form::close() !!}


<div class="panel panel-info main-panel-content">
	<div class="panel-heading index-heard">

<table class="main-tbl">
	<tr>
		<td><p class="faucet-id-p pull-right">Id: <span class="badge" id="faucet_id">{!! $faucet->id !!}</span></p></td>

		<td id="act_after_td" class="input-control-td hided">Show after
			{!! Form::text('cduraion',$faucet->duration,['id'=>'cduraion','class'=>'time-inp']) !!} sec.
			{!! Form::hidden('oduraion',$faucet->duration,['id'=>'oduraion']) !!}
		</td>

		<td id="priority_td" class="input-control-td">Priority&nbsp;
			{!! Form::text('priority',$faucet->priority,['id'=>'priority','class'=>'time-inp']) !!}
		</td>

		<td class="num-info-td">
			<table cellspacing="0" cellpadding="0" border="0" class="faucets-info-tbl">
				<tr><td rowspan="2" class="faucet-prompt-td">Faucets</td><td>all</td><td>{!! $all !!}</td></tr>
				<tr><td>active</td><td>{!! $active !!}</td></tr>
			</table>
		</td>

		<td>
			<div class="btn-group" role="group">
				{!! Html::link('/set/'.$faucet->id,'',['class'=>'btn btn-default glyphicon glyphicon-cog']) !!}
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
