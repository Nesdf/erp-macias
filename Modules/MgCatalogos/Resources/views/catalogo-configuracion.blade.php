@extends('layouts.app')

@section('guia')
	<li>
		<i class="ace-icon fa fa-gears"></i>
		<a href="{{ url('catalogo-configuracion') }}">Catálogo de configuraciones</a>
	</li>
@stop

@section('content')
    <div class="row">
		<div class="col-xs-12">
			<!-- PAGE CONTENT BEGINS -->
			
			<div class="row">
				<div class="col-xs-12">
					<h3 class="header smaller lighter blue">Configuracioness</h3>

					@if(Session::has('success'))
						<div class="alert alert-success">{{ Session::get('success') }}</div>
					@endif
					<div class="clearfix">
						<div class="pull-right tableTools-container"></div>
					</div>
					<div class="table-header">
						<a data-toggle="modal" data-target="#modal_create_error" class="btn btn-success"> Nuevo </a> 
					</div>

					<!-- div.table-responsive -->

					<!-- div.dataTables_borderWrap -->
					<div><br><br>
						<table id="table_configuraciones" class="stripe row-border">
							<thead>
								<tr>
									<th>Configuración</th>
									<th>
										Acciones
									</th>
								</tr>
							</thead>
							<tbody>
								@foreach($configuraciones as $config)
									<tr>
										<td>{{strtoupper($config->nombre)}}</td>
										<td>
											<a data-id="{{ $config->id }}" data-nombre="{{ strtoupper($config->nombre) }}"  data-toggle="modal" data-target="#modal_update_error" class="btn btn-xs btn-info" title="Editar">
												<i class="ace-icon fa fa-pencil bigger-120"></i>
											</a>									
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
	<!-- Modal UpdCreateate-->
	<div class="col-md-12">
			<div class="modal fade" id="modal_create_error" tabindex="-1" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="myModalLabel">
				<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
					<!--<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>-->
					<h4 class="modal-title" id="t_header"> Configuración</h4>
					<div class="alert alert-warning" role="alert">
						No se permiten espacios, si se agregan el sistema lo sustituirá.
					</div>
					<div id="error_create_error"></div>
					</div>
					<form role="form" id="form_create_error">
						<div class="modal-body">
							{{ csrf_field() }}
							<div class="form-group">
								<label for="nombre">Nombre</label>
								<input type="text" class="form-control" name="nombre" placeholder="Nombre del la configuración" required>
							</div>
						</div>
						<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal" >Cerrar</button>
						<button type="submit"  class="btn btn-primary btn-enviar">Guardar</button>
						</div>
					</form>
				</div>
				</div>
			</div>
		</div>
	<!-- Modal Update-->
	<div class="col-md-12">
		<div class="modal fade" id="modal_update_error" tabindex="-1" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="myModalLabel">
			<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
				<!--<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>-->
				<h4 class="modal-title" id="t_header">Modificar configuración</h4>
				<div class="alert alert-warning" role="alert">
					No se permiten espacios, si se agregan el sistema lo sustituirá.
				</div>
				<div id="error_update_error"></div>
				</div>
				<form role="form" id="form_update_error">
				<div class="modal-body">
					{{ csrf_field() }}
					<input type="hidden" name="id" >
					<div class="form-group">
						<label for="nombre">Nombre</label>
						<input type="text" class="form-control" name="nombre" placeholder="Nombre de la configuración" required>
					</div>
				</div>
				<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal" >Cerrar</button>
				<button type="submit"  class="btn btn-primary btn-enviar">Guardar</button>
				</div>
				</form>
			</div>
			</div>
		</div>
	</div>
@stop

@section('script')
	<script>
		$(document).on('ready', function(){

            $('#table_configuraciones').DataTable({
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

			//Carga la información al formulario
			$('#modal_create_error').on('shown.bs.modal', function (e) {
				$('input[name=nombre]').val("");
				$('input[name=nombre]').focus();
			})

			//Carga la información al formulario
			$('#modal_update_error').on('shown.bs.modal', function (e) {
				var id = $(e.relatedTarget).data().id;
				var nombre = $(e.relatedTarget).data().nombre;
				$('input[name=id]').val(id);
				$('input[name=nombre]').val(nombre);
				$('input[name=nombre]').focus();
				
			})
			//Envía la información del formulario
			$('#form_update_error').on('submit', function(event){
				event.preventDefault();
				$('.btn-enviar').attr('disabled', 'disabled');
				$.ajax({
					url: "{{ route('update-configuracion') }}",
					type: "POST",
					data: $( this ).serialize(),
					success: function( data ){
						if(data.msg == 'success'){
							window.location.reload(true);
						}
					},
					error: function(error){
						console.log("DATAA: ", error);
						$('.btn-enviar').prop('disabled', false);
						var err = "";
						$.each( error.responseJSON.errors, function( key, value) {
							err += value[0] + "<br>";
						});
						$('#error_update_error').html('<div class="alert alert-danger">' + err + '</div>');
					}
				});
			});
			//Envía la información del formulario
			$('#form_create_error').on('submit', function(event){
				event.preventDefault();
				$('.btn-enviar').attr('disabled', 'disabled');
				$.ajax({
					url: "{{ route('create-configuracion') }}",
					type: "POST",
					data: $( this ).serialize(),
					success: function( data ){
						if(data.msg == 'success'){
							window.location.reload(true);
						}
					},
					error: function(error){
						$('.btn-enviar').prop('disabled', false);
						var err = "";
						$.each( error.responseJSON.errors, function( key, value) {
							err += value[0] + "<br>";
						});
						$('#error_create_error').html('<div class="alert alert-danger">' + err + '</div>');
					}
				});
			});
		});

		
	</script>
@stop
