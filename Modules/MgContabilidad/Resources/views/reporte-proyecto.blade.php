@extends('layouts.app')

@section('guia')
	<li>
		<i class="ace-icon fa fa-users"></i>
		<a href="{{ url('mgclientes') }}">Reporte por Proyecto</a>
	</li>
@stop

@section('content')
    <div class="row">
		<div class="col-xs-12">
			<!-- PAGE CONTENT BEGINS -->
			
			<div class="row">
				<div class="col-xs-12">
					<h3 class="header smaller lighter blue">Reporte por Proyecto</h3>
	
					<form id="form_search">
						<div class="col-md-4">
							<label>Proyectos</label>
							<select name="proyecto" class="form-control" id="proyectos" data-style="btn-primary" data-show-subtext="true" name="ajaxEpisodio" data-live-search="true" >
								<option value="">Seleccionar...</option>
								@foreach($proyectos as $item)
									<option >{{ $item->titulo_original }}</option>
								@endforeach()
							</select>
						</div>
						<div class="col-md-4">
							<label>Fecha Inicial</label>
							<input type="text" name="fecha_inicial_search" id="fecha_inicial_search" class="form-control" >
						</div>
						{{ csrf_field() }}
						<div class="col-md-4">
							<label>Fecha final</label>
							<input type="text" name="fecha_final_search" id="fecha_final_search" class="form-control" >
						</div>
						<div class="col-md-offset-4 col-md-4">
							<br>
							<button type="submit" class="btn btn-success btn-lg btn-block">Enviar</button>
						</div>
					</form>
				</div>
			</div>		

			<!-- PAGE CONTENT ENDS -->
		</div><!-- /.col -->
	</div><!-- /.row -->
@stop

@section('modales')
	
@stop

@section('script')
	<script type="text/javascript">
		
		$(document).on('ready', function(){

			$('#proyectos').selectpicker();
		});

	</script>
@stop