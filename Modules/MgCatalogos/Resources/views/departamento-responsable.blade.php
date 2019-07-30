@extends('layouts.app')

@section('guia')
	<li>
		<i class="ace-icon fa fa-building-o"></i>
		<a href="{{ url('mgclientes') }}">Departamento responsable</a>
	</li>
@stop

@section('content')
    <div class="row">
		<div class="col-xs-12">
			<!-- PAGE CONTENT BEGINS -->
			
			<div class="row">
				<div class="col-xs-12">
					<h3 class="header smaller lighter blue">Departamento responsable</h3>

					@if(Session::has('success'))
						<div class="alert alert-success">{{ Session::get('success') }}</div>
					@endif
					<div class="clearfix">
						<div class="pull-right tableTools-container"></div>
					</div>
					<div class="table-header">
						<a data-toggle="modal" data-target="#modal_create_departamentos" class="btn btn-success"> Nuevo </a> 
					</div>

					<!-- div.table-responsive -->

					<!-- div.dataTables_borderWrap -->
					<div><br><br>
						<table id="table_rechazos" class="stripe row-border">
							<thead>
								<tr>
									<th>Nombre</th>
                                    <th>Descripción</th>
									<th> Acciones </th>
								</tr>
							</thead>
							<tbody>
								@foreach($departamentoResponsable as $departamentos)
									<tr>
										<td>{{$departamentos->nombre}}</td>
										<td>{{$departamentos->descripcion}}</td>
										<td>
											<a data-id="{{ $departamentos->id }}" data-nombre="{{ $departamentos->nombre }}" data-descripcion="{{ $departamentos->descripcion }}" data-toggle="modal" data-target="#modal_update_departamentos" class="btn btn-xs btn-info" title="Editar">
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
			<div class="modal fade" id="modal_create_departamentos" tabindex="-1" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="myModalLabel">
				<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
					<!--<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>-->
					<h4 class="modal-title" id="t_header"> Departamento responsable</h4>
					<div id="error_create_responsables"></div>
					</div>
					<form role="form" id="form_create_responsable">
						<div class="modal-body">
							{{ csrf_field() }}
							<div class="form-group">
								<label for="nombre_completo">Nombre</label>
								<input type="text" class="form-control" name="nombre" placeholder="Nombre del departamento responsable" required>
							</div>
							<div class="form-group">
								<label for="nombre_artistico">Descripción</label>
								<input type="text" class="form-control" name="descripcion" placeholder="Descripción">
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
		<div class="modal fade" id="modal_update_departamentos" tabindex="-1" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="myModalLabel">
			<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
				<!--<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>-->
				<h4 class="modal-title" id="t_header">Modificar departamento responsable</h4>
				<div id="error_update_responsables"></div>
				</div>
				<form role="form" id="form_update_responsable">
				<div class="modal-body">
					{{ csrf_field() }}
					<input type="hidden" name="id" >
					<div class="form-group">
						<label for="nombre_completo">Nombre</label>
						<input type="text" class="form-control" name="nombre" placeholder="Nombre del departamento responsable" required>
					</div>
					<div class="form-group">
						<label for="nombre_artistico">Descripción</label>
						<input type="text" class="form-control" name="descripcion" placeholder="Descripción">
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

            $('#table_rechazos').DataTable({
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
			$('#modal_create_departamentos').on('shown.bs.modal', function (e) {
				$('input[name=nombre]').val("");
				$('input[name=descripcion]').val("");
				$('input[name=nombre]').focus();
			})

			//Carga la información al formulario
			$('#modal_update_departamentos').on('shown.bs.modal', function (e) {
				var id = $(e.relatedTarget).data().id;
				var nombre = $(e.relatedTarget).data().nombre;
				var descripcion = $(e.relatedTarget).data().descripcion;
				$('input[name=id]').val(id);
				$('input[name=nombre]').val(nombre);
				$('input[name=descripcion]').val(descripcion);
				$('input[name=nombre]').focus();
				
			})
			//Envía la información del formulario
			$('#form_update_responsable').on('submit', function(event){
				event.preventDefault();
				$('.btn-enviar').attr('disabled', 'disabled');
				$.ajax({
					url: "{{ route('update-departamento-responsable') }}",
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
						$('#error_update_responsables').html('<div class="alert alert-danger">' + err + '</div>');
					}
				});
			});
			//Envía la información del formulario
			$('#form_create_responsable').on('submit', function(event){
				event.preventDefault();
				$('.btn-enviar').attr('disabled', 'disabled');
				$.ajax({
					url: "{{ route('create-departamento-responsable') }}",
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
						$('#error_create_responsables').html('<div class="alert alert-danger">' + err + '</div>');
					}
				});
			});
		});

		
	</script>
@stop