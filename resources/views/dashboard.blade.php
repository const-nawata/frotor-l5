@extends('layouts.main')

@section('content')
<div class="jumbotron">
</div>

<div class="container">

{!! Form::open(['url'=>'/save','method'=>'post', 'class'=>'form-horizontal', 'role'=>'form','id'=>'dashboardForm','name'=>'dashboardForm']) !!}
	<div class="row">



		<div class="col-sm-4">
			<div class="form-group">
				<label for="wait_time" class="col-sm-4 control-label wait-time">Time to wait</label>
				<div class="col-sm-8">
					<input type="text" class="form-control" id="wait_time" placeholder="Time" />
				</div>
			</div>
		</div>


		<div class="col-sm-8"></div>

	</div>

	<div class="row">
		<div class="col-sm-4">
			<div class="form-group">
				<div class="col-sm-offset-9 col-sm-3">
					<button type="submit" class="btn btn-default">Save</button>
				</div>
			</div>

		</div>


		<div class="col-sm-8"></div>

	</div>




{!! Form::close() !!}
</div>
@stop

@section('js_extra')
<script type="text/javascript">
$(document).ready(function(){
	$('#dashboardForm').submit(function(event){
		event.preventDefault();
		postDashboardData($(this).attr('action'));
		return false;
	});
});
</script>
@stop