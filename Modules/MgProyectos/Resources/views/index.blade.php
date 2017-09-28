@extends('layouts.app')

@section('guia')
	<li>
		<i class="ace-icon fa fa-tasks"></i>
		<a href="{{ url('mgproyectos') }}">Proyectos</a>
	</li>
@stop

@section('content')
    <div class="row">
		<div class="col-xs-12">
			<!-- PAGE CONTENT BEGINS -->
			
			<div class="row">
				<div class="col-xs-12">
					<h3 class="header smaller lighter blue">Proyectos de Macias Group</h3>

					<div class="clearfix">
						<div class="pull-right tableTools-container"></div>
					</div>
					<div class="table-header">
						@if(\Request::session()->has('add_proyecto'))
							<!--Results for "Latest Registered Domains"-->
							<a data-toggle="modal" data-target="#modal_proyecto" class="btn btn-success">
								Proyecto Nuevo
							</a>
						@endif
					</div>

					<!-- div.table-responsive -->

					<!-- div.dataTables_borderWrap -->
					<div><br><br>
						<table id="table_proyectos" class="stripe row-border">
							<thead>
								<tr>
									<th>ID</th>
									<th>Título original de la serie</th>
									<th class="hidden-480">Título aprobado de la serie</th>
									<th>Cliente</th>
									@if(\Request::session()->has('mgepisodios'))
										<th>Episosdios</th>
									@endif
									@if(\Request::session()->has('edit_proyecto') || \Request::session()->has('delete_proyecto'))
										<th></th>
									@endif
								</tr>
							</thead>

							<tbody>
								@foreach($proyectos as $proyecto)
									<tr>
										<td>
											{{ $proyecto->id }}
										</td>
										<td>
											{{ $proyecto->titulo_original }}
										</td>
										<td>
											{{ $proyecto->titulo_aprobado }}
										</td>
										<td>
											{{ $proyecto->cliente }}
										</td>
										<td>
											@if(\Request::session()->has('mgepisodios'))
												<a href=" {{ url('mgepisodios/' . $proyecto->id ) }} " title="Generar Episodio">
													<span class="label label-success arrowed-in arrowed-in-right"> Lista de Episodios </span>
												</a>
											@endif
										</td>
										<td>
											@if(\Request::session()->has('edit_proyecto'))
												<a data-id="{{ $proyecto->id }}" data-toggle="modal" data-target="#modal_update_proyecto" class="btn btn-xs btn-info update_id" title="Editar">
													<i class="ace-icon fa fa-pencil bigger-120"></i>
												</a>
											@endif		
											@if(\Request::session()->has('delete_proyecto'))
												<a data-toggle="modal" data-target="#modal_delete_proyecto" data-id="{{ $proyecto->id }}" class="btn btn-xs btn-danger delete_id" title="Eliminar">
													<i class="ace-icon fa fa-trash-o bigger-120"></i>
												</a>
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
	<!-- Modal Crear-->
	<div class="col-md-12">
		<div class="modal fade" id="modal_proyecto" data-name="modal" tabindex="-1" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="myModalLabel">
		  <div class="modal-dialog" role="document">
			<div class="modal-content">
			  <div class="modal-header">
				<!--<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>-->
				<h4 class="modal-title" id="t_header">Proyecto Nuevo</h4>
				<div id="error_create_proyecto"></div>
			  </div>
			  <form role="form" id="form_create_proyecto">
			  <div class="modal-body">
					{{ csrf_field() }}
					<div class="form-group">
						<label for="exampleInputEmail1">Cliente</label>
						<select class="form-control" id="cliente" name="cliente">
							<option select value="">Seleccionar</option>
							@foreach($clientes as $cliente)
								<option value="{{ $cliente->id }}"> {{ $cliente->razon_social }} </option>
							@endforeach
						</select>
					</div>	
					<div class="form-group">
						<label for="exampleInputEmail1">Título Original de la Serie</label>
						<input type="text" class="form-control" id="titulo_serie" name="titulo_serie" placeholder="Título Original de la Serie">
					</div>	
					<div class="form-group">
						<label for="exampleInputEmail1">Título Aprobado del Proyecto</label>
						<input type="text" class="form-control" id="titulo_proyecto" name="titulo_proyecto" placeholder="Título Aprobado del Proyecto">
					</div>		
					<div class="form-group">
						<input type="checkbox"  id="mande" name="mande" placeholder="Título Original de la Serie">
						<label for="exampleInputEmail1">Activar M&E</label>
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
		<div class="modal fade" id="modal_update_proyecto" tabindex="-1" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="myModalLabel">
		  <div class="modal-dialog" role="document">
			<div class="modal-content">
			  <div class="modal-header">
				<!--<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>-->
				<h4 class="modal-title" id="t_header">Modificar Proyecto</h4>
				<div id="error_update_personal"></div>
			  </div>
			  <form role="form" id="form_update_proyecto">
			  <div class="modal-body">
					{{ csrf_field() }}
					<input type="hidden" id="id_update" name="id">
					<div class="form-group">
						<label for="exampleInputEmail1">Selecciona un Cliente</label>
						<select class="form-control" id="cliente_update" name="cliente">
							<option select value="">Seleccionar</option>
							@foreach($clientes as $cliente)
								<option value="{{ $cliente->id }}"> {{ $cliente->razon_social }} </option>
							@endforeach
						</select>
					</div>	
					<div class="form-group">
						<label for="exampleInputEmail1">Título Original de la Serie</label>
						<input type="text" class="form-control" id="titulo_original_update" name="titulo_serie" placeholder="Título Original de la Serie">
					</div>	
					<div class="form-group">
						<label for="exampleInputEmail1">Título Aprobado del Proyecto</label>
						<input type="text" class="form-control" id="titulo_aprobado_update" name="titulo_proyecto" placeholder="Título Aprobado del Proyecto">
					</div>	
					<div class="form-group">
						<input type="checkbox"  id="mande_update" name="mande" placeholder="Título Original de la Serie">
						<label for="exampleInputEmail1">Activar M&E</label>
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
				<h4 class="modal-title " id="myModalLabel">Eliminar Proyecto</h4>
			  </div>
			  <form id="form_delete_proyecto" method="GET" action="{{ url('mgproyectos/form_delete') }}">
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

			$('#table_proyectos').DataTable({
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
					url: "{{ url('mgproyectos/edit_proyecto') }}" + "/" + id,
					type: "GET",
					success: function( data ){
						console.log(data);
						$('#id_update').val(data.id);
						$('#titulo_original_update').val(data.titulo_original);
						$('#titulo_aprobado_update').val(data.titulo_aprobado);
						$("#cliente_update option[value="+ data.clienteId +"]").attr("selected",true);
						$("#idioma_update option[value="+ data.idiomaId +"]").attr("selected",true);
						if(data.m_and_e == 1){
							$( "#mande_update" ).prop( "checked", true );
						}
					}
				});
			 });
			
			$('.delete_id').on('click', function(){
				 id = $( this ).data('id');
				  $('#form_delete_proyecto').attr('action', '{{ url("mgproyectos/form_delete") }}/' + id);
			 });
			
			$('#modal_proyecto').on('shown.bs.modal', function () {
			  //$('#myInput').focus()
			})	
			
			$('#form_create_proyecto').on('submit', function(event){
				event.preventDefault();
				$.ajax({
					url: "{{ url('mgproyectos/save_proyecto') }}",
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
						$('#error_create_proyecto').html('<div class="alert alert-danger">' + err + '</div>');
					}
				});
			});
			
			$('#form_update_proyecto').on('submit', function(event){
				event.preventDefault();
				$.ajax({
					url: "{{ url('mgproyectos/update_proyecto') }}",
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
						$('#error_update_proyecto').html('<div class="alert alert-danger">' + err + '</div>');
					}
				});
			});
		});
	</script>
@stop