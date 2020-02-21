@extends('layouts.app')

@section('guia')
	<li>
		<i class="ace-icon fa fa-video-camera"></i>
		<a href="{{ route('mgtrafico') }}">Tráfico</a>
	</li>
@stop

@section('content')
    <div class="row">
		<div class="col-xs-12">
			<!-- PAGE CONTENT BEGINS -->
			
			<div class="row">
				<div class="col-xs-12">
					<h3 class="header smaller lighter blue center">Tráfico </h3>

					<div class="clearfix">
						<div class="pull-right tableTools-container"></div>
					</div>
					<div class="table-header">
						<br>
					</div>

					<!-- div.table-responsive -->

					<!-- div.dataTables_borderWrap -->
					<div> <br><br>
						<table id="table_episodios" class="stripe row-border">
							<thead>
								<tr>
									<th>Nombre del proyecto</th>
									<th>Cliente</th>
									<th>Temporada</th>
									<th>Fecha entrega</th>
									<th>Duración</th>
									<th>Acciones</th>
								</tr>
							</thead>

							<tbody>
                                @foreach($proyectos as $proyecto)
									<tr>
										<td> {{ $proyecto->nombre_clientes }} </td>
                                        <td> {{ $proyecto->proyecto_titulo }} </td>
                                        <td> {{ $proyecto->num_episodio }}</td>
                                        <td> {{ \Carbon\Carbon::parse($proyecto->fecha_entrega)->format('m/d/Y')}}</td>
                                        <td>{{ $proyecto->duracion }}</td>
                                        <td>
										@if(\Request::session()->has('fecha_embarque_update'))
											@if($proyecto->date_boarding !== '' || $proyecto->date_boarding !== null )
												<a href="#" title="Fecha de embarque" data-toggle="modal" data-target="#modal_fecha_embarque" data-id="{{ $proyecto->episodio_id }}">
													<i class="glyphicon glyphicon-calendar "></i>
												</a>
											@else
											<i class="glyphicon glyphicon-calendar" style="color:red;"></i>
											@endif
										@endif
										</td>
									</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				</div>
			</div>		

			<!-- PAGE CONTENT ENDS -->
		</div><!-- /.col -->
	</div><!-- /.row -->
@stop

@section('modales')
	<!-- Fecha de embarque -->
	<div class="modal fade" id="modal_fecha_embarque" tabindex="-1" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
			<!--<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>-->
			<h4 class="modal-title" id="t_header">Asignar Fecha</h4>
			<div id="error_agregar_productor"></div>
			</div>
			<form role="form" id="form_fecha_embarque">
			<div class="modal-body">
				{{ csrf_field() }}
			<input type="hidden" name="id" id="id">
			<div>
				<div class="form-group">
					<label>Fecha de embarque</label>
					<input type="text" name="date_embarque" class="form-control" readonly=true required>
				</div>
			</div>
			<div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal" >Cerrar</button>
			<button type="submit" class="btn btn-primary">Guardar</button>
			</div>
			</form>
		</div>
		</div>
	</div>
@stop

@section('script')
	<script>
		$(document).on('ready', function(){

			$('#table_episodios').DataTable({
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
	        		},
		        }
			});

			$('input[name=date_embarque]').datepicker({
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


			$('#form_fecha_embarque').on('submit', function(event){
					event.preventDefault();
					$.ajax({
						url: "{{ route('fecha_embarque_update') }}",
						type: "POST",
						data: $( this ).serialize(),
						success: function( data ){
							if(data.msg == 'success'){
								window.location.reload(true);
							}
						},
						error: function(error){
							var err = "";
							for(var i in error.responseJSON.msg){
								err += error.responseJSON.msg[i] + "<br>";
							}
							$('#error_update_episodios').html('<div class="alert alert-danger">' + err + '</div>');
						}
					});
				});
			
		});
	</script>
@stop