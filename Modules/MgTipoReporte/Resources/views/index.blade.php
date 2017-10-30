@extends('layouts.app')

@section('guia')
	<li>
		<i class="ace-icon fa fa-child"></i>
		<a href="#">Tipo de Reporte</a>
	</li>
@stop

@section('content')
    <div class="row">
		<div class="col-xs-12">
			<!-- PAGE CONTENT BEGINS -->
			
			<div class="row">
				<div class="col-xs-12">
					<h3 class="header smaller lighter blue">Tipo de Reporte Macias Group</h3>

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
							<a data-toggle="modal" data-target="#modal_save_reporte" class="btn btn-success">
								Tipo de Reporte Nuevo
							</a>
						@endif
					</div>
					<!-- div.table-responsive -->

					<!-- div.dataTables_borderWrap -->
					<div><br><br>
						<table id="table_reportes" class="table table-striped table-bordered table-hover">
							<thead>
								<tr>
									<th>ID</th>
									<th>Tipo de Reporte</th>
									<th>Acciones</th>
								</tr>
							</thead>
								@foreach($reportes as $reporte)
									<tr>
										<td>{{ $reporte->id }}</td>
										<td>{{ $reporte->tipo }}</td>
										<td>
											<a data-id="{{ $reporte->id }}" data-toggle="modal" data-target="#modal_update_reporte" class="btn btn-xs btn-info update_id" title="Editar">
												<i class="ace-icon fa fa-pencil bigger-120"></i>
											</a>
											<a data-toggle="modal" data-target="#modal_delete_reporte" data-id="{{ $reporte->id }}" class="btn btn-xs btn-danger delete_id" title="Eliminar">
											 <i class="ace-icon fa fa-trash-o bigger-120"></i>
											</a>
										</td>
									</tr>
								@endforeach
							<tbody>								
								
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
		<div class="modal fade" id="modal_save_reporte" data-name="modal" tabindex="-1" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="myModalLabel">
		  <div class="modal-dialog" role="document">
			<div class="modal-content">
			  <div class="modal-header">
				<!--<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>-->
				<h4 class="modal-title" id="t_header">Tipo de Reporte Nuevo</h4>
				<div id="error_create_reporte"></div>
			  </div>
			  <form role="form" id="form_create_reporte">
			  <div class="modal-body">
					{{ csrf_field() }}
				<div class="form-group">
					<label for="reporte">Tipo de Reporte</label>
					<input type="text" class="form-control" id="reporte" name="reporte" placeholder="Tipo de Reporte">
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
		<div class="modal fade" id="modal_update_reporte" tabindex="-1" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="myModalLabel">
		  <div class="modal-dialog" role="document">
			<div class="modal-content">
			  <div class="modal-header">
				<!--<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>-->
				<h4 class="modal-title" id="t_header">Modificar Tipo de Reporte</h4>
				<div id="error_update_reporte"></div>
			  </div>
			  <form role="form" id="form_update_reporte">
			  <div class="modal-body">
					{{ csrf_field() }}
					<input type="hidden" id="id_update" name="id">
					<div class="form-group">
						<label for="reporte_update">Tipo de Reporte</label>
						<input type="text" class="form-control" id="reporte_update" name="reporte" placeholder="Tipo de Reporte">
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
		<div class="modal fade" id="modal_delete_reporte" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		  <div class="modal-dialog" role="document">
			<div class="modal-content">
			  <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title " id="myModalLabel">Eliminar Tipo de Reporte</h4>
			  </div>
			  <form id="form_delete_reporte" method="GET" action="{{ url('mgtiporeporte/form_delete') }}">
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
			$('#table_reportes').DataTable({
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
					url: "{{ url('mgtiporeporte/edit_reporte') }}" + "/" + id,
					type: "GET",
					success: function( data ){
						console.log(data);
						$('#id_update').val(data.id);
						$('#reporte_update').val(data.tipo);
					}
				});
			 });
			
			$('.delete_id').on('click', function(){
				 id = $( this ).data('id');
				  $('#form_delete_reporte').attr('action', '{{ url("mgtiporeporte/form_delete") }}/' + id);
			 });
			
			
			$('#form_create_reporte').on('submit', function(event){
				event.preventDefault();
				$.ajax({
					url: "{{ url('mgtiporeporte/create_reporte') }}",
					type: "POST",
					data: $( this ).serialize(),
					success: function( data ){
						if(data.msg == 'success'){
							window.location.reload(true);
						}
					},
					error: function(error){
						console.log(error);
						var err = "";
						for(var i in error.responseJSON.msg){
							err += error.responseJSON.msg[i] + "<br>";														
						}
						$('#error_create_reporte').html('<div class="alert alert-danger">' + err + '</div>');
					}
				});
			});
			
			$('#form_update_reporte').on('submit', function(event){
				event.preventDefault();
				$.ajax({
					url: "{{ url('mgtiporeporte/update_reporte') }}",
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
						$('#error_update_reporte').html('<div class="alert alert-danger">' + err + '</div>');
					}
				});
			});
		});
	</script>
@stop
