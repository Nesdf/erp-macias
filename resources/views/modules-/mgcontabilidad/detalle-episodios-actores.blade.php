@extends('layouts.app')

@section('guia')
	<li>
		<i class="ace-icon fa fa-users"></i>
		<a href="{{ url('mgcontabilidad/reporte-proyectos') }}">Detalle de Episodios</a>
	</li>
	<li>
		<i class="ace-icon fa fa-users"></i>
		<a href="javascript:void(0)">Actores</a>
	</li>
@stop

@section('content')

	<div class="row">
		<div class="col-xs-12">
			@if(Session::has('success'))
				<div class="alert alert-success">{{ Session::get('success') }}</div>
			@endif
			<div class="clearfix">
				<div class="pull-right tableTools-container"></div>
			</div>
			<h2 style="text-align: center;">Proyecto: {{$dataProyecto[0]->titulo_original}} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			Episodio: {{$actoresSinEstudio[0]->capitulo}} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			Sala: {{$actoresSinEstudio[0]->sala}}</h2>
			<!-- div.table-responsive -->

			<!-- div.dataTables_borderWrap -->
			<div><br><br>
				<table id="table_actores" class="stripe row-border">
					<thead>
						<tr>
							<th>Nombre Actor</th>
							<th>Fecha de llamado</th>
							<th>Personaje</th>
							<th>Loops</th>
							<th>Importe</th>
						</tr>
					</thead>

					<tbody>
						@foreach($actores as $actor)
							<tr>
								<td>{{$actor->actor}}</td>
								@php
									$cita_end = explode(" ", $actor->cita_end);
								@endphp
								<td>{{$cita_end[0]}}</td>
								<td>{{$actor->descripcion}}</td>
								<td>{{$actor->loops}}</td>
								<td>${{$actor->pago_total_loops}}</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
@stop

@section('modales')

@stop

@section('script')
	<script>
		$(document).on('ready', function(){
			var midata = $('#table_actores').DataTable({
				language: {
					search:   "Buscar: ",
								lengthMenu: "Mostrar _MENU_ registros por página",
								zeroRecords: "No se encontraron registros",
								info: "Página _PAGE_ de _PAGES_",
								infoEmpty: "Se buscó en",
								infoFiltered: "(_MAX_ registros)",
								responsive:     true,
								paginate: {
										first:      "Primero",
										previous:   "Previo",
										next:       "Siguiente",
										last:       "Anterior"
							},
						},
			});
		});
	</script>
@stop