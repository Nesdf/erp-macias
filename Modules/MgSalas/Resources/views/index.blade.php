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

					<div class="clearfix">
						<div class="pull-right tableTools-container"></div>
					</div>
					<div class="table-header">
						<!--Results for "Latest Registered Domains"-->
						<a data-toggle="modal" data-target="#modal_sala" class="btn btn-success">
							Sala Nueva
						</a>
					</div>

					<!-- div.table-responsive -->

					<!-- div.dataTables_borderWrap -->
					<div><br><br>
						<table id="table_salas" class="stripe row-border">
							<thead>
								<tr>
									<th>ID</th>
									<th>Salas</th>
									<th></th>
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
											@if(\Request::session()->has('update_sala') && \Request::session()->has('edit_sala') || \Request::session()->has('delete_sala'))
												<td>
													@if(\Request::session()->has('update_sala') && \Request::session()->has('edit_sala'))
														<a data-id="{{ $sala->id }}" data-toggle="modal" data-target="#modal_update_sala" class="btn btn-xs btn-info update_id" title="Editar">
															<i class="ace-icon fa fa-pencil bigger-120"></i>
														</a>		
													@endif
													@if(\Request::session()->has('delete_sala'))
														<a data-toggle="modal" data-target="#modal_delete_proyecto" data-id="{{ $sala->id }}" class="btn btn-xs btn-danger delete_id" title="Eliminar">
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
		<div class="modal fade" id="modal_delete_proyecto" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
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
			
			$('.update_id').on('click', function(){
				 id = $( this ).data('id');				
				$.ajax({
					url: "{{ url('mgsalas/edit_sala') }}" + "/" + id,
					type: "GET",
					success: function( data ){
						console.log(data);
						$('#id_update').val(data.id);
						$('#sala_update').val(data.sala);
					}
				});
			 });
			
			$('.delete_id').on('click', function(){
				 id = $( this ).data('id');
				  $('#form_delete_sala').attr('action', '{{ url("mgsalas/form_delete") }}/' + id);
			 });
			
			$('#modal_sala').on('shown.bs.modal', function () {
			  //$('#myInput').focus()
			})	
			
			$('#form_create_sala').on('submit', function(event){
				event.preventDefault();
				$.ajax({
					url: "{{ url('mgsalas/create_sala') }}",
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
						$('#error_create_sala').html('<div class="alert alert-danger">' + err + '</div>');
					}
				});
			});
			
			$('#form_update_sala').on('submit', function(event){
				event.preventDefault();
				$.ajax({
					url: "{{ url('mgsalas/update_sala') }}",
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
						$('#error_update_sala').html('<div class="alert alert-danger">' + err + '</div>');
					}
				});
			});
		});
	</script>
@stop