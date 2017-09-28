@extends('layouts.app')

@section('guia')
	<li>
		<i class="ace-icon fa fa-list"></i>
		<i>Elementos</i>
	</li>
	<li>
		<i class="ace-icon fa fa-tasks"></i>
		<a href="{{ url('mgpuestos') }}">Puestos de trabajo</a>
	</li>
@stop

@section('content')
    <div class="row">
		<div class="col-xs-12">
			<!-- PAGE CONTENT BEGINS -->
			
			<div class="row">
				<div class="col-xs-12">
					<h3 class="header smaller lighter blue">Puestos de Macias Group</h3>

					<div class="clearfix">
						<div class="pull-right tableTools-container"></div>
					</div>
					<div class="table-header">
						@if(\Request::session()->has('add_puesto'))
							<!--Results for "Latest Registered Domains"-->
							<a data-toggle="modal" data-target="#modal_puesto" class="btn btn-success">
								Puesto Nuevo
							</a>
						@endif
					</div>

					<!-- div.table-responsive -->

					<!-- div.dataTables_borderWrap -->
					<div><br><br>
						<table id="table_puestos" class="stripe row-border">
							<thead>
								<tr>
									<th>ID</th>
									<th>Puestos</th>
									<th></th>
								</tr>
							</thead>

							<tbody>
								@foreach($puestos as $puesto)
									<tr>
										<td>
											{{ $puesto->id }}
										</td>
										<td>
											{{ $puesto->job }}
										</td>
										@if(\Request::session()->has('update_puesto') && \Request::session()->has('edit_puesto') || \Request::session()->has('delete_puesto') )
											<td>
												@if(\Request::session()->has('update_puesto') && \Request::session()->has('edit_puesto'))
													<a data-id="{{ $puesto->id }}" data-toggle="modal" data-target="#modal_update_puesto" class="btn btn-xs btn-info update_id" title="Editar">
														<i class="ace-icon fa fa-pencil bigger-120"></i>
													</a>		
												@endif
												@if(\Request::session()->has('delete_puesto'))
													<a data-toggle="modal" data-target="#modal_delete_proyecto" data-id="{{ $puesto->id }}" class="btn btn-xs btn-danger delete_id" title="Eliminar">
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
		<div class="modal fade" id="modal_puesto" data-name="modal" tabindex="-1" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="myModalLabel">
		  <div class="modal-dialog" role="document">
			<div class="modal-content">
			  <div class="modal-header">
				<!--<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>-->
				<h4 class="modal-title" id="t_header">Puesto Nuevo</h4>
				<div id="error_create_puesto"></div>
			  </div>
			  <form role="form" id="form_create_puesto">
			  <div class="modal-body">
					{{ csrf_field() }}
				<div class="form-group">
					<label for="puesto">Puesto</label>
					<input type="text" class="form-control" id="job" name="job" placeholder="Puesto de trabajo">
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
		<div class="modal fade" id="modal_update_puesto" tabindex="-1" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="myModalLabel">
		  <div class="modal-dialog" role="document">
			<div class="modal-content">
			  <div class="modal-header">
				<!--<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>-->
				<h4 class="modal-title" id="t_header">Modificar Puesto</h4>
				<div id="error_update_puesto"></div>
			  </div>
			  <form role="form" id="form_update_puesto">
			  <div class="modal-body">
					{{ csrf_field() }}
					<input type="hidden" id="id_update" name="id">
					<div class="form-group">
						<label for="puesto">Puesto</label>
						<input type="text" class="form-control" id="job_update" name="job" placeholder="Puesto de trabajo">
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
				<h4 class="modal-title " id="myModalLabel">Eliminar Puesto</h4>
			  </div>
			  <form id="form_delete_puesto" method="GET" action="{{ url('mgpuestos/form_delete') }}">
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

			$('#table_puestos').DataTable({
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
					url: "{{ url('mgpuestos/edit_puesto') }}" + "/" + id,
					type: "GET",
					success: function( data ){
						console.log(data);
						$('#id_update').val(data.id);
						$('#job_update').val(data.job);
					}
				});
			 });
			
			$('.delete_id').on('click', function(){
				 id = $( this ).data('id');
				  $('#form_delete_puesto').attr('action', '{{ url("mgpuestos/form_delete") }}/' + id);
			 });
			
			$('#modal_puesto').on('shown.bs.modal', function () {
			  //$('#myInput').focus()
			})	
			
			$('#form_create_puesto').on('submit', function(event){
				event.preventDefault();
				$.ajax({
					url: "{{ url('mgpuestos/create_puesto') }}",
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
						$('#error_create_puesto').html('<div class="alert alert-danger">' + err + '</div>');
					}
				});
			});
			
			$('#form_update_puesto').on('submit', function(event){
				event.preventDefault();
				$.ajax({
					url: "{{ url('mgpuestos/update_puesto') }}",
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
						$('#error_update_puesto').html('<div class="alert alert-danger">' + err + '</div>');
					}
				});
			});
		});
	</script>
@stop