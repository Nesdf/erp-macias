@extends('layouts.app')

@section('guia')
	<li>
		<i class="ace-icon fa fa-child"></i>
		<a href="#">Personal</a>
	</li>
@stop

@section('content')
    <div class="row">
		<div class="col-xs-12">
			<!-- PAGE CONTENT BEGINS -->
			
			<div class="row">
				<div class="col-xs-12">
					<h3 class="header smaller lighter blue">Personal de Macias Group</h3>

					<div class="clearfix">
						<div class="pull-right tableTools-container"></div>
						@if (Session::has('message'))
							
							<div class="alert alert-success">
								<button type="button" class="close" data-dismiss="alert">
									<i class="ace-icon fa fa-times"></i>
								</button>
								{{  Session::get('message') }}
								<br />
							</div>
							
						@endif
					</div>
					<div class="table-header">
						@if(\Request::session()->has('add_personal'))
							<!--Results for "Latest Registered Domains"-->						
							<a data-toggle="modal" data-target="#modal_save_personal" class="btn btn-success">
								Usuario Nuevo
							</a>
						@endif
					</div>
					<!-- div.table-responsive -->

					<!-- div.dataTables_borderWrap -->
					<div><br><br>
						<table id="table_personal" class="table table-striped table-bordered table-hover">
							<thead>
								<tr>
									<th>ID</th>
									<th>Nombre(s)</th>
									<th>Apellido(s)</th>
									<th>Correo</th>
									<th>Puesto</th>
									<th>Estudos</th>
									@if(\Request::session()->has('add_permisos') || \Request::session()->has('edit_personal') && \Request::session()->has('update_personal') || \Request::session()->has('delete_personal'))
										<th></th>
									@endif
								</tr>
							</thead>

							<tbody>								
								@foreach($personas as $persona)
									<tr>
										<td>
											{{ $persona->id }}
										</td>
										<td>
											{{ $persona->name }}
										</td>
										<td>
											{{ $persona->ap_paterno }} {{ $persona->ap_materno }}
										</td>
										<td>
											{{ $persona->email }}
										</td>
										<td>
											{{ $persona->job }}
										</td>
										<td>
											{{ $persona->lista_estudios }}
										</td>
										@if(\Request::session()->has('add_permisos') || \Request::session()->has('edit_personal') && \Request::session()->has('update_personal') || \Request::session()->has('delete_personal'))
											<td>
												@if(\Request::session()->has('add_permisos'))
													<a href="{{url('/mgpersonal/permisos'. '/' .$persona->id)}}" class="btn btn-xs btn-primary" title="Agregar permisos">
														<i class="ace-icon fa fa-book bigger-120"></i>
													</a>
												@endif
												@if(\Request::session()->has('edit_personal') && \Request::session()->has('update_personal'))
													<a data-id="{{ $persona->id }}" data-toggle="modal" data-target="#modal_update_personal" class="btn btn-xs btn-info" title="Editar">
														<i class="ace-icon fa fa-pencil bigger-120"></i>
													</a>
												@endif		
												@if(\Request::session()->has('delete_personal'))
													<a data-toggle="modal" data-target="#modal_delete_personal" data-id="{{ $persona->id }}" class="btn btn-xs btn-danger" title="Eliminar">
														<i class="ace-icon fa fa-trash-o bigger-120"></i>
													</a>
												@endif
											</td>
										@endif
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
	<!-- Modal Crear-->
	<div class="col-md-12">
		<div class="modal fade" id="modal_save_personal" data-name="modal" tabindex="-1" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="myModalLabel">
		  <div class="modal-dialog" role="document">
			<div class="modal-content">
			  <div class="modal-header">
				<!--<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>-->
				<h4 class="modal-title" id="t_header">Usuario Personal</h4>
				<div id="error_create_personal"></div>
			  </div>
			  <form role="form" id="form_create_usuario">
			  <div class="modal-body">
					{{ csrf_field() }}
					<div class="form-group">
						<label for="nombre">Nombre(s)</label>
						<input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre(s)">
					</div>
					<div class="form-group">
						<label for="ap_paterno">Apellido Paterno</label>
						<input type="text" class="form-control" id="ap_paterno" name="ap_paterno" placeholder="Apellido Paterno">
					</div>
					<div class="form-group">
						<label for="ap_materno">Apellido Materno</label>
						<input type="text" class="form-control" id="ap_materno" name="ap_materno" placeholder="Apellido Materno">
					</div>
					<div class="form-group">
						<label for="lista_estudios">Estudios</label><br>
						<select name="lista_estudios" class="form-control" multiple="multiple" required>
							@foreach( $estudios as $data )
								<option value="{{ $data->estudio }}">{{ $data->estudio }}</option>
							@endforeach
						</select>
						<input type="hidden" name="estudios" id="estudios" value="">
					</div>
					<div class="form-group">
						<label for="correo">Correo Elecrónico</label>
						<input type="text" class="form-control" id="correo" name="correo" placeholder="Correo Electrónico">
					</div>
					<div class="form-group">
						<label for="password">Contraseña</label>
						<input type="password" class="form-control" id="password" name="password" placeholder="Contraseña">
					</div>
					<div class="form-group">
						<label for="puesto">Selecciona el puesto</label>
						<select class="form-control selectpicker" id="puesto" name="puesto" data-style="btn-primary" data-show-subtext="true" data-live-search="true" title="Seleccionar...">
							@foreach($puestos as $puesto)
								<option value="{{ $puesto->id }}"> {{ $puesto->job }} </option>
							@endforeach
						</select>
					</div>
					<label>
						<input type="checkbox" name="tipo_empleado"> &nbsp; Seleccionar si el empleado es del área técnica
					</label>	
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
	
	<!-- Modal Update-->
	<div class="col-md-12">
		<div class="modal fade" id="modal_update_personal" tabindex="-1" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="myModalLabel">
		  <div class="modal-dialog" role="document">
			<div class="modal-content">
			  <div class="modal-header">
				<!--<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>-->
				<h4 class="modal-title" id="t_header">Modificar Personal</h4>
				<div id="error_update_personal"></div>
			  </div>
			  <form role="form" id="form_update_usuario">
			  <div class="modal-body">
					{{ csrf_field() }}
					<input type="hidden" id="id_update" name="id">
					<div class="form-group">
						<label for="exampleInputEmail1">Nombre(s)</label>
						<input type="text" class="form-control" id="nombre_update" name="nombre" placeholder="Nombre(s)">
					</div>
					<div class="form-group">
						<label for="exampleInputEmail1">Apellido Paterno</label>
						<input type="text" class="form-control" id="ap_paterno_update" name="ap_paterno" placeholder="Apellido Paterno">
					</div>
					<div class="form-group">
						<label for="exampleInputEmail1">Apellido Materno</label>
						<input type="text" class="form-control" id="ap_materno_update" name="ap_materno" placeholder="Apellido Materno">
					</div>
					<div class="form-group">
						<label for="lista_estudios">Estudios &nbsp;&nbsp;&nbsp; <span class="label label-info">Por seguridad no se pueden eliminar estudios</span></label><br>
						<select name="lista_estudios" class="form-control" multiple="multiple" required>
							@foreach( $estudios as $data )
								<option value="{{ $data->estudio }}">{{ $data->estudio }}</option>
							@endforeach
						</select>
						<input type="hidden" name="estudios" value="">
					</div>
					<div class="form-group">
						<label for="exampleInputEmail1">Correo Elecrónico</label>
						<input type="text" class="form-control" id="correo_update" name="correo" placeholder="Correo Electrónico">
					</div>
					<div class="form-group">
						<label for="exampleInputEmail1">Contraseña</label>
						<input type="password" class="form-control" id="password_update" name="password" placeholder="Contraseña">
					</div>
					<div class="form-group">
						<label for="puesto">Selecciona el puesto</label>
						<select class="form-control" id="puesto_update" name="puesto">
							<option select value="">Seleccionar</option>
							@foreach($puestos as $puesto)
								<option value="{{ $puesto->id }}"> {{ $puesto->job }} </option>
							@endforeach
						</select>
					</div>	
					<label>
						<input type="checkbox" name="tipo_empleado"> &nbsp; Seleccionar si el empleado es del área técnica
					</label>			
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
	
	<!-- Modal Delete-->
	<div class="col-md-12">
		<div class="modal fade" id="modal_delete_personal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		  <div class="modal-dialog" role="document">
			<div class="modal-content">
			  <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title " id="myModalLabel">Eliminar Personal</h4>
			  </div>
			  <form id="form_delete_usuario" method="GET" action="{{ url('mgpersonal/form_delete') }}">
			  <img src="{{ asset('assets/dashboard/images/error/peligro.png') }}">
			  {{ csrf_field() }}
			  <div id="inputs"></div>
			  <label>¿Realmente deseas eliminarlo?</label>
			  <div class="modal-footer">
				<button type="submit" class="btn btn-danger">Eliminar</button>
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

			$( 'select[name=lista_estudios]' ).multiselect();
			$('select[name=lista_estudios]').on('change', function(){
            	var lista_estudios = $(this).val();
            	estudios = lista_estudios.join(",");
            	$('input[name=estudios]').val(estudios);
            });
			

			$( '#table_personal' ).DataTable({
		        "pageLength": 50,
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

			$('#modal_save_personal').on('shown.bs.modal', function (e) {
			  
			 	$('#form_create_usuario').on('submit', function(event){
					event.preventDefault();
					$.ajax({
						url: "{{ url('mgpersonal/save-persona') }}",
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
							$('#error_create_personal').html('<div class="alert alert-danger">' + err + '</div>');
							//$('#error_create_personal').html('<div class="alert alert-danger">'+error.responseJSON.msg.nombre+'</div>');
						}
					});
				});
			})	


			$('#modal_update_personal').on('shown.bs.modal', function (e) {
				$(".loader").fadeIn();
			  	
			  	var id = $(e.relatedTarget).data().id;
			 	$.ajax({
					url: "{{ url('mgpersonal/edit_personal') }}" + "/" + id,
					type: "GET",
					success: function( data ){

						var datos = data.lista_estudios;
						var valArr = [];
						console.log(datos)
						$('select[name=lista_estudios]').multiselect('refresh');
						if( datos !== null ){
							valArr = datos.split(",");
					        for(var i=0; i<valArr.length; i++){
					        	valArr[i] = valArr[i].replace('&amp;', '&')
					        }
						}
				        console.log(valArr);
						$('select[name=lista_estudios]').multiselect('select', valArr);
						$('select[name=lista_estudios]').multiselect('refresh');

						$('#id_update').val(data.id);
						$('#nombre_update').val(data.name);
						$('#ap_paterno_update').val(data.ap_paterno);
						$('#ap_materno_update').val(data.ap_materno);
						$('#correo_update').val(data.email);
						$('#nombre_update').val(data.name);
						$('#password_update').val('');
						$("#puesto_update option[value="+ data.job +"]").attr("selected",true);	
						(data.tipo_empleado == true) ? $('input[name=tipo_empleado]').prop("checked", true) : $('input[name=tipo_empleado]').prop("checked", false);


						$('#form_update_usuario').on('submit', function(event){
							event.preventDefault();
							$.ajax({
								url: "{{ url('mgpersonal/update_persona') }}",
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
									$('#error_update_personal').html('<div class="alert alert-danger">' + err + '</div>');
									//$('#error_create_personal').html('<div class="alert alert-danger">'+error.responseJSON.msg.nombre+'</div>');
								}
							});
						});
						
					}, 
					beforeSend: function(){
						$(".loader").fadeOut("slow");	
					}
				});
			})	


			$('#modal_delete_personal').on('shown.bs.modal', function (e) {
			  
			  	var id = $(e.relatedTarget).data().id;
			 	$('#form_delete_usuario ').attr('action', '{{ url("mgpersonal/form_delete") }}/' + id);
			});	
		});
	</script>
@stop
