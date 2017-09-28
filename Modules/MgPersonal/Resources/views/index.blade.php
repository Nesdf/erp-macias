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
					<div>
						<table id="dynamic-table" class="table table-striped table-bordered table-hover">
							<thead>
								<tr>
									<th>ID</th>
									<th>Nombre(s)</th>
									<th>Apellido(s)</th>
									<th>Correo</th>
									<th>Puesto</th>
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
										@if(\Request::session()->has('add_permisos') || \Request::session()->has('edit_personal') && \Request::session()->has('update_personal') || \Request::session()->has('delete_personal'))
											<td>
												@if(\Request::session()->has('add_permisos'))
													<a href="{{url('/mgpersonal/permisos'. '/' .$persona->id)}}" class="btn btn-xs btn-primary" title="Agregar permisos">
														<i class="ace-icon fa fa-book bigger-120"></i>
													</a>
												@endif
												@if(\Request::session()->has('edit_personal') && \Request::session()->has('update_personal'))
													<a data-id="{{ $persona->id }}" data-toggle="modal" data-target="#modal_update_personal" class="btn btn-xs btn-info update_id" title="Editar">
														<i class="ace-icon fa fa-pencil bigger-120"></i>
													</a>
												@endif		
												@if(\Request::session()->has('delete_personal'))
													<a data-toggle="modal" data-target="#modal_delete_personal" data-id="{{ $persona->id }}" class="btn btn-xs btn-danger delete_id" title="Eliminar">
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
						<label for="exampleInputEmail1">Nombre(s)</label>
						<input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre(s)">
					</div>
					<div class="form-group">
						<label for="exampleInputEmail1">Apellido Paterno</label>
						<input type="text" class="form-control" id="ap_paterno" name="ap_paterno" placeholder="Apellido Paterno">
					</div>
					<div class="form-group">
						<label for="exampleInputEmail1">Apellido Materno</label>
						<input type="text" class="form-control" id="ap_materno" name="ap_materno" placeholder="Apellido Materno">
					</div>
					<div class="form-group">
						<label for="exampleInputEmail1">Correo Elecrónico</label>
						<input type="text" class="form-control" id="correo" name="correo" placeholder="Correo Electrónico">
					</div>
					<div class="form-group">
						<label for="exampleInputEmail1">Contraseña</label>
						<input type="password" class="form-control" id="password" name="password" placeholder="Contraseña">
					</div>
					<div class="form-group">
						<label for="exampleInputEmail1">Selecciona el puesto</label>
						<select class="form-control" id="puesto" name="puesto">
							<option select value="">Seleccionar</option>
							@foreach($puestos as $puesto)
								<option value="{{ $puesto->id }}"> {{ $puesto->job }} </option>
							@endforeach
						</select>
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
			$('#modal_delete_personal').on('shown.bs.modal', function () {
			  //$('#myInput').focus()
			  //$( this ).data( 'id' );
			  
			  console.log( $( this ) );
			 
			})	
			
			$('.update_id').on('click', function(){
				 id = $( this ).data('id');				
				$.ajax({
					url: "{{ url('mgpersonal/edit_personal') }}" + "/" + id,
					type: "GET",
					success: function( data ){
						console.log(data.job);
						$('#id_update').val(data.id);
						$('#nombre_update').val(data.name);
						$('#ap_paterno_update').val(data.ap_paterno);
						$('#ap_materno_update').val(data.ap_materno);
						$('#correo_update').val(data.email);
						$('#nombre_update').val(data.name);
						$("#puesto_update option[value="+ data.job +"]").attr("selected",true);		
						
					}
				});
				
				  //$('#modal_delete_personal').child
				 // $('#form_delete_usuario ').attr('action', '{{ url("mgpersonal/form_update") }}/' + id);
			 });
			
			$('.delete_id').on('click', function(){
				 id = $( this ).data('id');
				  //$('#modal_delete_personal').child
				  $('#form_delete_usuario ').attr('action', '{{ url("mgpersonal/form_delete") }}/' + id);
			 });
			
			$('#modal_personal').on('shown.bs.modal', function () {
			  //$('#myInput').focus()
			})	
			
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
		});
	</script>
@stop
