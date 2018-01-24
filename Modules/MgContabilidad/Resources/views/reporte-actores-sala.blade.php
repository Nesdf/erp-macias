@extends('layouts.app')

@section('guia')
	<li>
		<i class="ace-icon fa fa-users"></i>
		<a href="{{ url('mgclientes') }}">Reporte por Actores y Sala</a>
	</li>
@stop

@section('content')
    <div class="row">
		<div class="col-xs-12">
			<!-- PAGE CONTENT BEGINS -->
			

			<div class="row">
				<div class="col-xs-12">
					<h3 class="header smaller lighter blue">Reporte por Actores y Sala</h3>

					<form>
						<div class="col-md-4">
							<label>Salas</label>
							<select name="proyecto" class="form-control" id="salas" data-style="btn-primary" data-show-subtext="true" name="ajaxEpisodio" data-live-search="true" >
								<option value="">Seleccionar...</option>
								@foreach($salas as $item)
									<option >{{ $item->sala }}</option>
								@endforeach()
							</select>
						</div>
						<div class="col-md-4">
							<label>Fecha Final</label>
							<input type="text" name="fecha_search" class="form-control" >
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

			$('#salas').selectpicker();
			//Calendarios
			$('#fecha_search').datepicker({
					dateFormat: "yy-mm-dd",
					//minDate: 0,
					closeText: 'Cerrar',
				    prevText: '<Ant',
				    nextText: 'Sig>',
				    currentText: 'Hoy',
				    monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
				    monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
				    dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
				    dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
				    dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
				});      
		});
	</script>
@stop