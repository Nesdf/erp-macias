@extends('layouts.app')

@section('guia')
	<li>
		<i class="ace-icon fa fa-list"></i>
		<i>Elementos</i>
	</li>
	<li>
		<i class="ace-icon fa fa-tasks"></i>
		<a href="{{ url('mgvias') }}">Método envio</a>
	</li>
@stop

@section('content')
    <div class="row">
		<div class="col-xs-12">
			<!-- PAGE CONTENT BEGINS -->
			
			<div class="row">
				<div class="col-xs-12">
					<h3 class="header smaller lighter blue">Método envio</h3>

					<div class="clearfix">
						<div class="pull-right tableTools-container"></div>
					</div>
					<div class="table-header">
						<!--Results for "Latest Registered Domains"-->
						{{--@if(\Request::session()->has('add_via'))--}}
							<a data-toggle="modal" data-target="#modal_metodo" class="btn btn-success">
								Método envío nuevo
							</a>
						{{--@endif--}}
					</div>

					<!-- div.table-responsive -->

					<!-- div.dataTables_borderWrap -->
					<div><br><br>
						<table id="table_vias" class="stripe row-border">
							<thead>
								<tr>
									<th>ID</th>
									<th>Método envío</th>
									<th></th>
								</tr>
							</thead>

							<tbody>
								@foreach($metodoEnvio as $metodo)
									<tr>
										<td>
											{{ $metodo->id }}
										</td>
										<td>
											{{ $metodo->metodo_envio }}
										</td>
										<td>
											{{--@if(\Request::session()->has('update_metodo'))--}}
												<a data-id="{{ $metodo->id }}" data-toggle="modal" data-target="#modal_update_metodo" class="btn btn-xs btn-info update_id" title="Editar">
													<i class="ace-icon fa fa-pencil bigger-120"></i>
												</a>		
											{{--@endif--}}
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
	<!-- Modal Crear-->
	<div class="col-md-12">
		<div class="modal fade" id="modal_metodo" data-name="modal" tabindex="-1" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="myModalLabel">
		  <div class="modal-dialog" role="document">
			<div class="modal-content">
			  <div class="modal-header">
				<!--<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>-->
				<h4 class="modal-title" id="t_header">Método de envío nuevo</h4>
				<div id="error_create_metod"></div>
			  </div>
			  <form role="form" id="form_create_metodo">
			  <div class="modal-body">
					{{ csrf_field() }}
				<div class="form-group">
					<label for="metodo_envio">Nombre del método de envío</label>
					<input type="text" class="form-control" id="metodo_envio" name="metodo_envio" placeholder="Nombre del método de envío">
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
		<div class="modal fade" id="modal_update_metodo" tabindex="-1" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="myModalLabel">
		  <div class="modal-dialog" role="document">
			<div class="modal-content">
			  <div class="modal-header">
				<!--<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>-->
				<h4 class="modal-title" id="t_header">Modificar Método de envío</h4>
				<div id="error_update_metodo"></div>
			  </div>
			  <form role="form" id="form_update_metodo">
			  <div class="modal-body">
					{{ csrf_field() }}
					<input type="hidden" id="id_update" name="id">
					<div class="form-group">
						<label for="metodo">Nombre del método de envío</label>
						<input type="text" class="form-control" id="metodo_envio_update" name="metodo_envio" placeholder="Nombre del método de envío">
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
		<div class="modal fade" id="modal_delete_via" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		  <div class="modal-dialog" role="document">
			<div class="modal-content">
			  <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title " id="myModalLabel">Eliminar M</h4>
			  </div>
			  <form id="form_delete_via" method="GET" action="{{ url('mgvias/form_delete') }}">
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

			$('#table_vias').DataTable({
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

			$('#modal_metodo').on('shown.bs.modal', function(e){
				$('input[name=metodo_envio]').val('');
				$('#form_create_metodo').on('submit', function(event){
					event.preventDefault();
					$.ajax({
						url: "{{ route('crear-metodo-envio') }}",
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
							$('#error_create_metodo').html('<div class="alert alert-danger">' + err + '</div>');
						}
					});
				});
			});

			$('#modal_update_metodo').on('shown.bs.modal', function(e){
				var id = $(e.relatedTarget).data().id;
				$.ajax({
					url: "{{ route('show-metodo-envio') }}",
					type: "POST",
					data:{id: id, _token: "{{ csrf_token() }}"},
					success: function( data ){
						console.log(data);
						//$('#id_update').val(data.id);
						//$('#via_update').val(data.via);
						$('input[name=metodo_envio]').val(data['valor']);
						$('input[name=id]').val(id);

						$('#form_update_metodo').on('submit', function(event){
							event.preventDefault();
							$.ajax({
								url: "{{ route('update-metodo-envio') }}",
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
									$('#error_update_metodo').html('<div class="alert alert-danger">' + err + '</div>');
								}
							});
						});
						
					}, 
					error: function(error){

					}
				});
			});

			$('#modal_delete_via').on('shown.bs.modal', function(e){
				var id = $(e.relatedTarget).data().id;
				$('#form_delete_via').attr('action', '{{ url("mgvias/form_delete") }}/' + id);
			});
		});
	</script>
@stop