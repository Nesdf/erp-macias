@extends('layouts.app')

@section('guia')
	<li>
		<i class="ace-icon fa fa-users"></i>
		<a href="{{ url('mgclientes') }}">Clientes</a>
	</li>
@stop

@section('content')
    <div class="row">
		<div class="col-xs-12">
			<!-- PAGE CONTENT BEGINS -->
			
			<div class="row">
				<div class="col-xs-12">
					<h3 class="header smaller lighter blue">Clientes de Macias Group</h3>

					<div class="clearfix">
						<div class="pull-right tableTools-container"></div>
					</div>
					<div class="table-header">
						@if(\Request::session()->has('add_cliente'))
							<!--Results for "Latest Registered Domains"-->
							<a data-toggle="modal" data-target="#modal_save_clientes" class="btn btn-success">
								Cliente Nuevo
							</a>
						@endif
					</div>

					<!-- div.table-responsive -->

					<!-- div.dataTables_borderWrap -->
					<div><br><br>
						<table id="table_clientes" class="stripe row-border">
							<thead>
								<tr>
									<th>ID</th>
									<th>Razón Social</th>
									<th>País</th>
									<th>Estado</th>
									@if(\Request::session()->has('update_cliente') || \Request::session()->has('delete_cliente'))
										<th></th>
									@endif
								</tr>
							</thead>

							<tbody>
								@foreach($clientes as $cliente)
									<tr>
										<td>
											{{ $cliente->id }}
										</td>
										<td>
											{{ $cliente->razon_social }}
										</td>
										<td>
											{{ $cliente->pais }}
										</td>
										<td>
											{{ $cliente->estado }}
										</td>
										@if(\Request::session()->has('update_cliente') || \Request::session()->has('delete_cliente'))
											<td>
												@if(\Request::session()->has('update_cliente'))
													<a data-id="{{ $cliente->id }}" data-toggle="modal" data-target="#modal_update_clientes" class="btn btn-xs btn-info update_id" title="Editar">
														<i class="ace-icon fa fa-pencil bigger-120"></i>
													</a>		
												@endif
												@if(\Request::session()->has('delete_cliente'))
													<a data-toggle="modal" data-target="#modal_delete_cliente" data-id="{{ $cliente->id }}" class="btn btn-xs btn-danger delete_id" title="Eliminar">
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
		<div class="modal fade" id="modal_save_clientes" data-name="modal" tabindex="-1" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="myModalLabel">
		  <div class="modal-dialog" role="document">
			<div class="modal-content">
			  <div class="modal-header">
				<!--<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>-->
				<h4 class="modal-title" id="t_header">Cliente Nuevo</h4>
				<div id="error_create_personal"></div>
			  </div>
			  <form role="form" id="form_create_cliente">
			  <div class="modal-body">
					{{ csrf_field() }}
					<div class="form-group">
						<label for="exampleInputEmail1">Razón Social</label>
						<input type="text" class="form-control" id="razon_social" name="razon_social" placeholder="Razón Social">
					</div>
					<div class="form-group">
						<label for="exampleInputEmail1">R.F.C.</label>
						<input type="text" class="form-control" id="rfc" name="rfc" placeholder="R.F.C.">
					</div>
					<div class="form-group">
						<label for="exampleInputEmail1">Selecciona el País</label>
						<select class="form-control" id="pais" name="pais">
							<option select value="">Seleccionar</option>
							@foreach($paises as $pais)
								<option value="{{ $pais->id }}"> {{ $pais->pais }} </option>
							@endforeach
						</select>
					</div>	
					<div class="form-group">
						<label for="exampleInputEmail1">Selecciona una Localidad</label>
						<select class="form-control" id="localidad" name="localidad">
							<option select value="">Seleccionar</option>
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
		<div class="modal fade" id="modal_update_clientes" tabindex="-1" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="myModalLabel">
		  <div class="modal-dialog" role="document">
			<div class="modal-content">
			  <div class="modal-header">
				<!--<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>-->
				<h4 class="modal-title" id="t_header">Modificar Personal</h4>
				<div id="error_update_personal"></div>
			  </div>
			  <form role="form" id="form_update_clientes">
			  <div class="modal-body">
					{{ csrf_field() }}
					<input type="hidden" id="id_update" name="id">
					<div class="form-group">
						<label for="exampleInputEmail1">Razón Social</label>
						<input type="text" class="form-control" id="razon_social_update" name="razon_social" placeholder="Razón Social">
					</div>
					<div class="form-group">
						<label for="exampleInputEmail1">R.F.C.</label>
						<input type="text" class="form-control" id="rfc_update" name="rfc" placeholder="R.F.C.">
					</div>		
					<div class="form-group">
						<label for="exampleInputEmail1">Selecciona el País</label>
						<select class="form-control" id="pais_update" name="pais">
							<option select value="">Seleccionar</option>
							@foreach($paises as $pais)
								<option value="{{ $pais->id }}"> {{ $pais->pais }} </option>
							@endforeach
						</select>
					</div>	
					<div class="form-group">
						<label for="exampleInputEmail1">Selecciona una Localidad</label>
						<select class="form-control" id="localidad_update" name="localidad">
							<option select value="">Seleccionar</option>
							@foreach($estados as $estado)
								<option value="{{ $estado->id }}"> {{ $estado->estado }} </option>
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
		<div class="modal fade" id="modal_delete_cliente" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		  <div class="modal-dialog" role="document">
			<div class="modal-content">
			  <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title " id="myModalLabel">Eliminar Cliente</h4>
			  </div>
			  <form id="form_delete_cliente" method="GET" action="{{ url('mgclientes/form_delete') }}">
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

			$('#table_clientes').DataTable({
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
					url: "{{ url('mgclientes/edit_clientes') }}" + "/" + id,
					type: "GET",
					success: function( data ){
						console.log(data);
						$('#id_update').val(data.id);
						$('#razon_social_update').val(data.razon_social);
						$('#rfc_update').val(data.rfc);
						$("#pais_update option[value="+ data.paisId +"]").attr("selected",true);
						$("#localidad_update option[value="+ data.estadoId +"]").attr("selected",true);
					}
				});
			 });
			
			$('.delete_id').on('click', function(){
				 id = $( this ).data('id');
				  $('#form_delete_cliente').attr('action', '{{ url("mgclientes/form_delete") }}/' + id);
			 });
			
			$('#modal_clientes').on('shown.bs.modal', function () {
			  //$('#myInput').focus()
			})	
			
			$('#form_create_cliente').on('submit', function(event){
				event.preventDefault();
				$.ajax({
					url: "{{ url('mgclientes/save_cliente') }}",
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
					}
				});
			});
			
			$('#form_update_clientes').on('submit', function(event){
				event.preventDefault();
				$.ajax({
					url: "{{ url('mgclientes/update_clientes') }}",
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
					}
				});
			});
			
			$( '#pais' ).on('change', function(){
				var id = $(this).val();
				$.ajax({
					url: "{{ url('mgclientes/list_countries') }}" + '/' +id,
					type: "GET",
					success: function( data ){
						$("#localidad").empty();
						$("#localidad").append('<option> Seleccionar</option>');
						for(var i=0;  i < data.msg.length; i++ ){
							$("#localidad").append('<option value='+ data.msg[i].id + '>' + data.msg[i].estado +'</option>');
						} 
					},
					error: function(error){
					}
				});
			});
			
			$( '#pais_update' ).on('change', function(){
				var id = $(this).val();
				$.ajax({
					url: "{{ url('mgclientes/list_countries') }}" + '/' +id,
					type: "GET",
					success: function( data ){
						$("#localidad_update").empty();
						$("#localidad_update").append('<option> Seleccionar</option>');
						for(var i=0;  i < data.msg.length; i++ ){
							$("#localidad_update").append('<option value='+ data.msg[i].id + '>' + data.msg[i].estado +'</option>');
						} 
					},
					error: function(error){
					}
				});
			});
		});
	</script>
@stop