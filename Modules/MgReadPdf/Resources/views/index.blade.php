@extends('layouts.app')

@section('guia')
	<li>
		<i class="ace-icon fa fa-child"></i>
		<a href="#">Leer PDF</a>
	</li>
@stop

@section('content')
    <div class="row">
		<div class="col-xs-12">
			<!-- PAGE CONTENT BEGINS -->
			
			<p>
				{{$texto}}
			</p>
		</div><!-- /.col -->
	</div><!-- /.row -->
@stop

@section('modales')
@stop

@section('script')
	<script>
	</script>
@stop
@extends('mgreadpdf::layouts.master')

@section('content')
@stop
