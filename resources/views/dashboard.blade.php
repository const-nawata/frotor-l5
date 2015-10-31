@extends('layouts.main')

@section('content')
<div class="jumbotron">
</div>

<div class="container dasboard-frotor">

{!! Form::open(['url'=>'/save','method'=>'post', 'class'=>'form-horizontal', 'role'=>'form','id'=>'dashboardForm','name'=>'dashboardForm']) !!}

	<div class="row">
		<div class="col-sm-8">
			<div class="form-group">

				<label for="faucet_id" class="col-sm-4 control-label id-dasboard-frotor-label">Id </label>
				<div class="col-sm-8">
					<div id="faucet_id" class="badge id-dasboard-frotor-div">{!! $faucet->id !!}</div>
				</div>

			</div>
		</div>
		<div class="col-sm-4"></div>
	</div>

	<div class="row">
		<div class="col-sm-8">
			<div class="form-group">
				<label for="info" class="col-sm-4 control-label">Description</label>
				<div class="col-sm-8">
					{!! Form::text('info', $faucet->info, ['class'=>'form-control','id'=>'info','placeholder'=>'Description']) !!}
				</div>
			</div>
		</div>
		<div class="col-sm-4"></div>
	</div>

	<div class="row">
		<div class="col-sm-8">
			<div class="form-group">
				<label for="wait_time" class="col-sm-4 control-label">Time to wait</label>
				<div class="col-sm-8">

					{!! Form::text('duration', $faucet->duration, ['class'=>'form-control','id'=>'duration','placeholder'=>'Time']) !!}

				</div>
			</div>
		</div>
		<div class="col-sm-4"></div>
	</div>

	<div class="row">
		<div class="col-sm-8">
			<div class="form-group">
				<div class="col-sm-offset-9 col-sm-3">

					{!! Form::submit( 'Save', ['class'=>'btn btn-default pull-right']) !!}

				</div>
			</div>
		</div>
		<div class="col-sm-4"></div>
	</div>

{!! Form::close() !!}
</div>
@stop

@section('js_extra')
<script type="text/javascript">
$(document).ready(function(){

	$("#faucet_id").change(function(event){
		alert("id: "+$(this).val());
	});

	$('#dashboardForm').submit(function(event){
		event.preventDefault();
		postDashboardData($(this).attr('action'));
		return false;
	});
});
</script>
@stop