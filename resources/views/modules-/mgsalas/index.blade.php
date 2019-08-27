@extends('layouts.app')

@section('guia')
	<li>
		<i class="ace-icon fa fa-list"></i>
		<i>Elementos</i>
	</li>
	<li>
		<i class="ace-icon fa fa-tasks"></i>
		<a href="{{ url('mgsalas') }}">Salas</a>
	</li>
@stop

@section('content')
    <div class="row">
		<div class="col-xs-12">
			<!-- PAGE CONTENT BEGINS -->
			
			<div class="row">
				<div class="col-xs-12">
					<h3 class="header smaller lighter blue">Salas de Macias Group</h3>
					@if(Session::has('success'))
						<p class="alert alert-success">{{ Session::get('success') }}</p>
					@endif
					@if(Session::has('error'))
						<p class="alert alert-danger">{{ Session::get('error') }}</p>
					@endif

					<div class="clearfix">
						<div class="pull-right tableTools-container"></div>
					</div>
					<div class="table-header">
						<!--Results for "Latest Registered Domains"-->
						@if(\Request::session()->has('add_sala'))
							<a data-toggle="modal" data-target="#modal_sala" class="btn btn-success">
								Sala Nueva
							</a>
							<a data-toggle="modal" data-target="#modal_estudio" class="btn btn-success">
								Estudio Nuevo
							</a>
						@endif
					</div>
					<div id="estudio">
						<br>
						<div class="alert alert-warning">Lista de estudios</div>
						@foreach($estudios as $estudio)
							<span>{{ $estudio->estudio }} <a href="javascript:void(0)" data-toggle="modal" data-target="#modal_editar_estudio" data-id="{{ $estudio->id }}" data-estudio="{{ $estudio->estudio }}" class="fa fa-pencil" style="color:blue;" title="Modificar estudio"></a> 
								<!--<a href="javascrip:void(0)" data-toggle="modal" data-target="#modal_delete_estudio" data-id="" class="fa fa-trash-o" style="color:red;" ></a>--> </span> &nbsp; &nbsp; &nbsp; &nbsp; | &nbsp; &nbsp; &nbsp; &nbsp;
						@endforeach
					</div>

					<!-- div.table-responsive -->

					<!-- div.dataTables_borderWrap -->
					<div><br><br>
						<table id="table_salas" class="stripe row-border">
							<thead>
								<tr>
									<th>ID</th>
									<th>Salas</th>
									<th>Estudio</th>
									@if(\Request::session()->has('update_sala') && \Request::session()->has('edit_sala') || \Request::session()->has('delete_sala'))
										<th></th>
									@endif
								</tr>
							</thead>

							<tbody>
								@foreach($salas as $sala)
									<tr>
										<td>
											{{ $sala->id }}
										</td>
										<td>
											{{ $sala->sala }}
										</td>
										<td>
											{{ $sala->estudio_id }}
										</td>
											@if(\Request::session()->has('update_sala') && \Request::session()->has('edit_sala') || \Request::session()->has('delete_sala'))
												<td>
													@if(\Request::session()->has('update_sala') && \Request::session()->has('edit_sala'))
														<a data-id="{{ $sala->id }}" data-toggle="modal" data-target="#modal_update_sala" class="btn btn-xs btn-info" title="Editar">
															<i class="ace-icon fa fa-pencil bigger-120"></i>
														</a>		
													@endif
													@if(\Request::session()->has('delete_sala'))
														<a data-toggle="modal" data-target="#modal_delete_sala" data-id="{{ $sala->id }}" class="btn btn-xs btn-danger" title="Eliminar">
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
	<!-- Modal Crear Sala-->
	<div class="col-md-12">
		<div class="modal fade" id="modal_sala" data-name="modal" tabindex="-1" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="myModalLabel">
		  <div class="modal-dialog" role="document">
			<div class="modal-content">
			  <div class="modal-header">
				<!--<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>-->
				<h4 class="modal-title" id="t_header">Sala nueva</h4>
				<div id="error_create_sala"></div>
			  </div>
			  <form role="form" id="form_create_sala">
			  <div class="modal-body">
					{{ csrf_field() }}
				<div class="form-group">
					<label for="sala">Nombre de la sala</label>
					<input type="text" class="form-control" id="sala" name="sala" placeholder="Nombre de la sala">
				</div>
				<div class="form-group">
					<label>Estudio</label>
					<select name="estudio" class="form-control" required>
						<option value="">Selecccionar</option>
						@foreach($estudios as $estudio)
							<option value="{{ $estudio->id }}">{{ $estudio->estudio }}</option>
						@endforeach
					</select>
				</div>
			  </div>
			  <div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal" >Cerrar</button>
				<button type="submit" class="submit btn btn-primary">Guardar</button>
			  </div>
			  </form>
			</div>
		  </div>
		</div>
	</div>

	<!-- Modal Crear Estudo-->
	<div class="col-md-12">
		<div class="modal fade" id="modal_estudio" data-name="modal" tabindex="-1" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="myModalLabel">
		  <div class="modal-dialog" role="document">
			<div class="modal-content">
			  <div class="modal-header">
				<!--<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>-->
				<h4 class="modal-title" id="t_header">Estudio nuevo</h4>
				<div id="error_create_estudio"></div>
			  </div>
			  <form role="form" id="form_create_estudio">
			  <div class="modal-body">
					{{ csrf_field() }}
				<div class="form-group">
					<label for="sala">Nombre del estudio</label>
					<input type="text" class="form-control" id="estudio" name="estudio" placeholder="Nombre del estudio">
				</div>
			  </div>
			  <div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal" >Cerrar</button>
				<button type="submit" class="submit btn btn-primary">Guardar</button>
			  </div>
			  </form>
			</div>
		  </div>
		</div>
	</div>

	<!-- Modal Editar Estudio-->
	<div class="col-md-12">
		<div class="modal fade" id="modal_editar_estudio" data-name="modal" tabindex="-1" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="myModalLabel">
		  <div class="modal-dialog" role="document">
			<div class="modal-content">
			  <div class="modal-header">
				<!--<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>-->
				<h4 class="modal-title" id="t_header">Editar Estudio</h4>
				<div id="error_edit_estudio"></div>
			  </div>
			  <form role="form" id="form_edit_estudio">
			  <div class="modal-body">
					{{ csrf_field() }}
					<input type="hidden" name="id">
				<div class="form-group">
					<label for="sala">Nombre del estudio</label>
					<input type="text" class="form-control" id="estudio" name="estudio" placeholder="Nombre del estudio">
				</div>
			  </div>
			  <div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal" >Cerrar</button>
				<button type="submit" class="submit btn btn-primary">Guardar</button>
			  </div>
			  </form>
			</div>
		  </div>
		</div>
	</div>
	
	<!-- Modal Update-->
	<div class="col-md-12">
		<div class="modal fade" id="modal_update_sala" tabindex="-1" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="myModalLabel">
		  <div class="modal-dialog" role="document">
			<div class="modal-content">
			  <div class="modal-header">
				<!--<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>-->
				<h4 class="modal-title" id="t_header">Modificar Sala</h4>
				<div id="error_update_sala"></div>
			  </div>
			  <form role="form" id="form_update_sala">
			  <div class="modal-body">
					{{ csrf_field() }}
					<input type="hidden" id="id_update" name="id">
					<div class="form-group">
						<label for="sala">Sala</label>
						<input type="text" class="form-control" id="sala_update" name="sala" placeholder="Nombre de la sala">
					</div>
					<div class="form-group">
						<label>Estudio</label>
						<select name="estudio" class="form-control" required>
							<option>Selecccionar</option>
							@foreach($estudios as $estudio)
								<option value="{{ $estudio->id }}">{{ $estudio->estudio }}</option>
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
	
	<!-- Modal Delete Sala-->
	<div class="col-md-12">
		<div class="modal fade" id="modal_delete_sala" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		  <div class="modal-dialog" role="document">
			<div class="modal-content">
			  <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title " id="myModalLabel">Eliminar Sala</h4>
			  </div>
			  <form id="form_delete_sala" method="GET" action="{{ url('mgsalas/form_delete') }}">
				  <img src="{{ asset('assets/dashboard/images/error/peligro.png') }}">
				  {{ csrf_field() }}
				  <div id="inputs"></div>
				  <label>¿Realmente deseas eliminarla?</label>
				  <div class="modal-footer">
					<button type="submit" class="btn btn-danger">Eliminar</button>
				  </div>
			  </form>
			</div>
		  </div>
		</div>
	</div>

	<!-- Modal Delete Estudio-->
	<div class="col-md-12">
		<div class="modal fade" id="modal_delete_estudio" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		  <div class="modal-dialog" role="document">
			<div class="modal-content">
			  <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title " id="myModalLabel">Eliminar Estudio</h4>
			  </div>
			  <form id="form_delete_estudio">
				  <img src="{{ asset('assets/dashboard/images/error/peligro.png') }}">
				  <div id="inputs"></div>
				  <label>¿Realmente deseas eliminarla?</label>
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

			$('#table_salas').DataTable({
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

			$('#modal_sala').on('shown.bs.modal', function (e) {
			  
			  	$('#form_create_sala').on('submit', function(event){
					event.preventDefault();
					$.ajax({
						url: "{{ url('/mgsalas/create_sala') }}",
						type: "POST",
						data: $( this ).serialize(),
						success: function( data ){
							if(data.msg == 'success'){
								window.location.reload(true);
							}
						},
						beforeSend: function(){
							$('.submit').attr('disabled', 'disabled');
						},
						error: function(error){
							var err = "";
							for(var i in error.responseJSON.msg){
								err += error.responseJSON.msg[i] + "<br>";														
							}
							$('#error_create_sala').html('<div class="alert alert-danger">' + err + '</div>');
							$('.submit').removeAttr('disabled');
						}
					});
				});
			});

			$('#modal_estudio').on('shown.bs.modal', function (e) {
			  
			  	$('#form_create_estudio').on('submit', function(event){
					event.preventDefault();
					$.ajax({
						url: "{{ url('/mgsalas/create_estudio') }}",
						type: "POST",
						data: $( this ).serialize(),
						success: function( data ){
							if(data.msg == 'success'){
								window.location.reload(true);
							}
						},
						beforeSend: function(){
							$('.submit').attr('disabled', 'disabled');
						},
						error: function(error){
							console.log(error);
							var err = "";
							for(var i in error.responseJSON.msg){
								err += error.responseJSON.msg[i] + "<br>";														
							}
							$('#error_create_estudio').html('<div class="alert alert-danger">' + err + '</div>');
							$('.submit').removeAttr('disabled');
						}
					});
				});
			});

			$('#modal_editar_estudio').on('shown.bs.modal', function (e) {
			  	var id = $(e.relatedTarget).data().id;
			  	var estudio = $(e.relatedTarget).data().estudio;
			  	$('input[name=estudio]').val(estudio);
			  	$('input[name=id]').val(id);

			  	$('#form_edit_estudio').on('submit', function(event){
					event.preventDefault();
					$.ajax({
						url: "{{ url('/mgsalas/edit_estudio') }}",
						type: "POST",
						data: $( this ).serialize(),
						success: function( data ){
							if(data.msg == 'success'){
								window.location.reload(true);
							}
						},
						beforeSend: function(){
							$('.submit').attr('disabled', 'disabled');
						},
						error: function(error){
							console.log(error);
							var err = "";
							for(var i in error.responseJSON.msg){
								err += error.responseJSON.msg[i] + "<br>";														
							}
							$('#error_edit_estudio').html('<div class="alert alert-danger">' + err + '</div>');
							$('.submit').removeAttr('disabled');
						}
					});
				});
			});

			$('#modal_update_sala').on('shown.bs.modal', function (e) {

				var id = $(e.relatedTarget).data().id;
				$.ajax({
					url: "{{ url('/mgsalas/edit_sala') }}" + "/" + id,
					type: "GET",
					success: function( data ){
						$('#id_update').val(data.id);
						$('input[name=sala]').val(data.sala);
						$('select[name=estudio]').val(data.estudio_id);

						$('#form_update_sala').on('submit', function(event){
							event.preventDefault();
							$.ajax({
								url: "{{ url('/mgsalas/update_sala') }}",
								type: "POST",
								data: $( this ).serialize(),
								success: function( data ){
									if(data.msg == 'success'){
										window.location.reload(true);
									}
								},
								beforeSend: function(){
									$('.submit').attr('disabled', 'disabled');
								},
								error: function(error){
									var err = "";
									for(var i in error.responseJSON.msg){
										err += error.responseJSON.msg[i] + "<br>";														
									}
									$('#error_update_sala').html('<div class="alert alert-danger">' + err + '</div>');
									$('.submit').removeAttr('disabled');
								}
							});
						});
					}
				});
			});

			$('#modal_delete_sala').on('shown.bs.modal', function (e) {

				var id = $(e.relatedTarget).data().id;
				$('#form_delete_sala').attr('action', '{{ url("mgsalas/form_delete") }}/' + id);
			});	

			$('#modal_delete_estudio').on('shown.bs.modal', function (e) {

				var id = $(e.relatedTarget).data().id;
				$('#form_delete_estudio').attr('action', '{{ url("mgsalas/form_delete") }}/' + id);
			});			
			
		});
	</script>
@stop