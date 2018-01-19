@extends('layouts.app')

@section('guia')
	<li>
		<i class="ace-icon fa fa-users"></i>
		<a href="{{ url('mgclientes') }}">Reporte General</a>
	</li>
@stop

@section('content')
    <div class="row">
		<div class="col-xs-12">
			<!-- PAGE CONTENT BEGINS -->
			
			<div class="row">
				<div class="col-xs-12">
					<h3 class="header smaller lighter blue">Reporte General</h3>

					<form>
						<div class="col-md-4">
							<label>Fecha Inicial</label>
							<input type="date" name="fecha_inicial" class="form-control" >
						</div>
						<div class="col-md-4">
							<label>Fecha Final</label>
							<input type="date" name="fecha_final" class="form-control" >
						</div>
					</form>
					
				</div>
			</div>		

			<!-- PAGE CONTENT ENDS -->
		</div><!-- /.col -->
	</div><!-- /.row -->
	<div class="row">
		<div class="col-xs-12">
			<div class="reportes">
				
			</div>
		</div>
	</div>
@stop

@section('modales')
	
@stop

@section('script')
	
@stop