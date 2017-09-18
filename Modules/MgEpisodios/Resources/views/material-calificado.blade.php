@extends('layouts.app')

@section('guia')
	<li>
		<i class="ace-icon fa fa-users"></i>
		<a href="">Proyectos</a>
	</li>
	<li>
		<i class="ace-icon fa fa-film"></i>
		<a href="">Episodios</a>
	</li>
	<li>
		<i class="ace-icon fa fa-film"></i>
		<a href="">Material Calificado</a>
	</li>
@stop

@section('content')
	@php
		 \Carbon\carbon::setLocale('es');
		 $hoy = \Carbon\carbon::today('America/Mexico_City');
		 $fechaentrega = \Carbon\carbon::parse($allProyect[0]->fecha_entrega, 'America/Mexico_City');
		 $diferencia_dias = $fechaentrega->diffInDays($hoy, false);
		 $status_entrega = '';
		 $label = '';
    @endphp

    @if($diferencia_dias < -2)
        @php
        	$status_entrega = "success";
        	$label = "success";
        @endphp
	@endif
    @if($diferencia_dias >= -2 && $diferencia_dias <= -1)
    	@php
        	$status_entrega = "warning";
        	$label = "warning";
        @endphp
    @endif
    @if($diferencia_dias >= 0)
        @php
        	$status_entrega = "danger";
        	$label = "error";
        @endphp
    @endif
	<div class="row">
		<div class="col-xs-12">
			<!-- PAGE CONTENT BEGINS -->
			
			<div class="row">
				<div class="col-xs-12">
					<h3 class="header smaller lighter blue center">Material Calificado</h3>
					<div class="alert alert-{{$status_entrega}}" role="alert">
					  <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
					  <span class="sr-only"></span>
					  Fecha de entrega: <ins>{{ \Jenssegers\Date\Date::parse($allProyect[0]->fecha_entrega)->format('l j \\d\\e F Y') }}</ins>
					</div>
					<h3 class="header smaller lighter blue"><b>Proyecto: <ins>{{$allProyect[0]->titulo_proyecto}}</ins></b></h3>
					<h3 class="header smaller lighter blue"><b>Episodio: <ins>{{$allProyect[0]->titulo_episodio}}</ins></b></h3>
					<div class="clearfix">
						<div class="pull-right tableTools-container"></div>
					</div>
					<div class="table-header">
						<!--Results for "Latest Registered Domains"-->
						<a href="#" data-toggle="modal" data-target="#modal_timecode" class="btn btn-success">
							<i class="glyphicon glyphicon-indent-right"></i> &nbsp; Time Code Nuevo
						</a>
						<a href="#" data-toggle="modal" data-target="#modal_update_calificacion" class="btn btn-info"><i class="glyphicon glyphicon-edit"> </i>&nbsp; Modificar calificación</a>
						<a href="{{url('mgepisodios/material-calificado-pdf/'.$id_episodio.'/'.$id_proyecto)}}" target="_blank" class="btn btn-danger"><i class="glyphicon glyphicon-circle-arrow-down"></i> PDF</a>
					</div>
					<div class="table-body">
						<div class="row">
							<div class="col-md-12">
								<table class="table">
									<tr>
										<td><h4>Minutos:</h4></td>
										<td>
											<div class="form-group has-{{$label}} has-feedback">
												<input type="text" value="{{$allProyect[0]->duracion}}" class="form-control" readonly="true">
											</div>
										</td>
										<td><h4>TCR:</h4></td>
										<td>
											<div class="form-group has-{{$label}} has-feedback">
												<input type="text" value="{{$allProyect[0]->tcr}}" class="form-control" readonly="true">
											</div>
										</td>
										<td><h4>Comentarios <br>transfer:</h4> </td>
										<td>
										<div  class="form-group has-{{$label}} has-feedback">
											<textarea class="form-control" readonly="true">{{$allProyect[0]->descripcion}}</textarea>
										</div>
										</td>
									</tr>
									<tr>
										<td><h4>Tipo de reporte:</h4></td>
										<td>
											<div class="form-group has-{{$label}} has-feedback">
												<input type="text" value="{{$allProyect[0]->tipo_reporte}}" class="form-control" readonly="true">
											</div>
										</td>
										<td><h4>Mezcla:</h4></td>
										<td>
											<div class="form-group has-{{$label}} has-feedback">
												<input type="text" value="{{$allProyect[0]->mezcla}}" class="form-control" readonly="true">
											</div>
										</td>
										<td></td>
										<td></td>
									</tr>
								</table>
							</div>
						</div>
						 <table id="table-cm" class="stripe row-border"	>
						 	<thead>
					 			<tr>
					 				<th>Fecha</th>
					 				<th>Timecode</th>
					 				<th>Observaciones</th>
					 			</tr>
						 	</thead>
						 	<tbody>
						 		@foreach($timecodes as $timecode)
						 			<tr>
						 				<td>{{$timecode->fecha}}</td>
						 				<td>{{$timecode->timecode}}</td>
						 				<td>{{$timecode->observaciones}}</td>
						 			</tr>
						 		@endforeach
						 	</tbody>
						 </table>
					</div>

					<!-- div.table-responsive -->

					<!-- div.dataTables_borderWrap -->
					
					</div>
				</div>
			</div>		

			<!-- PAGE CONTENT ENDS -->
		</div><!-- /.col -->
	</div><!-- /.row -->
@stop

@section('modales')
	<!-- Generar nuevo time code -->
	<div class="col-md-12">
		<div class="modal fade" id="modal_timecode" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		  <div class="modal-dialog" role="document">
			<div class="modal-content">
			  <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title " id="myModalLabel">Time Code Nuevo</h4>
			  </div>
			  <div class="modal-body">
			  	<div id="alerta_fecha"> </div>
			  	<div class="row">
			  		<form role="form" action="{{url('mgepisodios/save-timecode')}}" method="POST">
					    <div class="modal-body">
							{{ csrf_field() }}	
							<div class="form-group">
								<input type="hidden" name="id_cm" value="{{$allProyect[0]->id}}">
								<input type="hidden" name="id_episodio" value="{{$id_episodio}}">
								<input type="hidden" name="id_proyecto" value="{{$id_proyecto}}">
								<label>Time Code</label>
								<input type="text" id="timecode" name="timecode" class="form-control" required="true">
							</div>
							<div class="form-group">
								<label>Observaciones</label>
								<textarea name="observaciones" class="form-control" required="true"></textarea>
							</div>
						
						 <div class="modal-footer">
						   <button type="button" class="btn btn-default" data-dismiss="modal" >Cerrar</button>
						   <button type="submit" class="btn btn-primary">Guardar</button>
						 </div>
				    </form>
			  	</div>
			  </div>
			</div>
		  </div>
		</div>
	</div>

	<!-- Actualizar calificación-->
	<div class="col-md-12">
		<div class="modal fade" id="modal_update_calificacion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		  <div class="modal-dialog" role="document">
			<div class="modal-content">
			  <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title " id="myModalLabel">Modificar Calificación</h4>
			  </div>
			  <div class="modal-body">
			  	<div id="alerta_fecha"> </div>
			  	<div class="row">
		  			<form role="form" id="form_create_calificar_material" action="{{url('mgepisodios/update-material-calificado/'.$id_episodio.'/'.$id_proyecto)}}" method="POST">
					    <div class="modal-body">
							{{ csrf_field() }}	
							<input type="hidden" name="id_episodio" value="{{$id_episodio}}">
							<input type="hidden" name="id_proyecto" value="{{$id_proyecto}}">
							<div class="form-group">
								<label>Minutos</label>
								<input type="text" name="duracion" value="{{$allProyect[0]->duracion}}" class="form-control">
							</div>
							<div class="form-group">
								<label>Tipo de reporte</label>
								<input type="text" name="tipo_reporte" value="{{$allProyect[0]->tipo_reporte}}" class="form-control">
							</div>
							<div class="form-group">
								<label>Mezcla</label>
								<input type="text" name="mezcla" value="{{$allProyect[0]->mezcla}}"  class="form-control">
							</div>
							<div class="form-group">
								<label>TCR</label>
								<select name="tcr" class="form-control">
								<option>Seleccionar ...</option>
								@foreach($tcrs as $tcr)
									<option  value="{{$tcr->id}}" @if($tcr->id == $allProyect[0]->tcr) selected @endif>{{$tcr->tcr}}</option>
								@endforeach
								</select>
							</div>
							<div class="form-group">
								<label>Comentarios Transfer</label>
								<textarea name="observaciones" class="form-control">{{$allProyect[0]->descripcion}}</textarea>
							</div>
						 <div class="modal-footer">
						   <button type="button" class="btn btn-default" data-dismiss="modal" >Cerrar</button>
						   <button type="submit" class="btn btn-primary">Guardar</button>
						 </div>
				    </form>
			  	</div>
			  </div>
			</div>
		  </div>
		</div>
	</div>

@stop

@section('script')
	<script >
		$(document).ready(function(){

			$('#timecode, #duracion, #duracion_update').mask('00:00:00:00');

			$('#table-cm').DataTable({
				language: {
					search:   "Buscar: ",
		            lengthMenu: "Mostrar _MENU_ registros por página",
		            zeroRecords: "No se encontraron registros",
		            info: "Página _PAGE_ de _PAGES_",
		            infoEmpty: "Se buscó en",
		            infoFiltered: "(_MAX_ registros)",
		            paginate: {
		                first:      "Primero",
		                previous:   "Previo",
		                next:       "Siguiente",
		                last:       "Anterior"
	        		}
	        	}
	        });
		});
	</script>
@stop