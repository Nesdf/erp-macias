@extends('layouts.app')

@section('guia')
	<li>
		<i class="ace-icon fa fa-list"></i>
		<i>TimeCode</i>
	</li>
	<li>
		<i class="ace-icon fa fa-tasks"></i>
		<a href="{{ url('mgtimecode') }}">Timecode</a>
	</li>
@stop

@section('content')
    <div class="row">
		<div class="col-xs-12">
			<!-- PAGE CONTENT BEGINS -->
			
			<div class="row">
				<div class="col-xs-12">
					<h3 class="header smaller lighter blue">Timecode de Macias Group</h3>

					<div class="clearfix">
						<div class="pull-right tableTools-container"></div>
					</div>
					<div class="table-header">
						<!--Results for "Latest Registered Domains"-->
						@if(\Request::session()->has('add_tc'))
							<a data-toggle="modal" data-target="#modal_timecode" class="btn btn-success">
								Timecode Nuevo
							</a>
						@endif
					</div>

					<!-- div.table-responsive -->

					<!-- div.dataTables_borderWrap -->
					<div><br><br>
						<table id="table_timecodes" class="stripe row-border">
							<thead>
								<tr>
									<th>ID</th>
									<th>Timecode</th>
									<th></th>
								</tr>
							</thead>

							<tbody>
								@foreach($timecodes as $timecode)
									<tr>
										<td>
											{{ $timecode->id }}
										</td>
										<td>
											{{ $timecode->timecode }}
										</td>
										<td>
											@if(\Request::session()->has('edit_tc'))
												<a data-id="{{ $timecode->id }}" data-toggle="modal" data-target="#modal_update_timecode" class="btn btn-xs btn-info update_id" title="Editar">
													<i class="ace-icon fa fa-pencil bigger-120"></i>
												</a>		
											@endif
											@if(\Request::session()->has('delete_tc'))
												<a data-toggle="modal" data-target="#modal_delete_timecode" data-id="{{ $timecode->id }}" class="btn btn-xs btn-danger delete_id" title="Eliminar">
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
		<div class="modal fade" id="modal_timecode" data-name="modal" tabindex="-1" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="myModalLabel">
		  <div class="modal-dialog" role="document">
			<div class="modal-content">
			  <div class="modal-header">
				<!--<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>-->
				<h4 class="modal-title" id="t_header">Timecode Nuevo</h4>
				<div id="error_create_timecode"></div>
			  </div>
			  <form role="form" id="form_create_timecode">
			  <div class="modal-body">
					{{ csrf_field() }}
				<div class="form-group">
					<label for="timecode">Nombre del Timecode</label>
					<input type="text" class="form-control" id="timecode" name="timecode" placeholder="Nombre del Timecode">
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
		<div class="modal fade" id="modal_update_timecode" tabindex="-1" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="myModalLabel">
		  <div class="modal-dialog" role="document">
			<div class="modal-content">
			  <div class="modal-header">
				<!--<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>-->
				<h4 class="modal-title" id="t_header">Modificar Timecode</h4>
				<div id="error_update_timecode"></div>
			  </div>
			  <form role="form" id="form_update_timecode">
			  <div class="modal-body">
					{{ csrf_field() }}
					<input type="hidden" id="id_update" name="id">
					<div class="form-group">
						<label for="timecode">Nombre del Timecode</label>
						<input type="text" class="form-control" id="timecode_update" name="timecode" placeholder="Nombre del timecode">
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
		<div class="modal fade" id="modal_delete_timecode" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		  <div class="modal-dialog" role="document">
			<div class="modal-content">
			  <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title " id="myModalLabel">Eliminar Timecode</h4>
			  </div>
			  <form id="form_delete_timecode" method="GET" action="{{ url('mgtimecode/form_delete') }}">
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

			$('#table_timecodes').DataTable({
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
					url: "{{ url('mgtimecode/edit_tc') }}" + "/" + id,
					type: "GET",
					success: function( data ){
						console.log(data);
						$('#id_update').val(data.id);
						$('#timecode_update').val(data.timecode);
					}
				});
			 });
			
			$('.delete_id').on('click', function(){
				 id = $( this ).data('id');
				  $('#form_delete_timecode').attr('action', '{{ url("mgtimecode/form_delete") }}/' + id);
			 });
			
			$('#modal_timecode').on('shown.bs.modal', function () {
			  //$('#myInput').focus()
			})	
			
			$('#form_create_timecode').on('submit', function(event){
				event.preventDefault();
				$.ajax({
					url: "{{ url('mgtimecode/create_tc') }}",
					type: "POST",
					data: $( this ).serialize(),
					success: function( data ){
						if(data.msg == 'success'){
							window.location.reload(true);
						}
					},
					error: function(error){
						console.log(error.responseJSON.error);
						if(error.responseJSON.msgError){
							$('#error_create_timecode').html('<div class="alert alert-danger">' + error.responseJSON.msgError + '</div>');
							console.log(error.error)
						} else{
							var err = "";
							for(var i in error.responseJSON.msg){
								err += error.responseJSON.msg[i] + "<br>";														
							}
							$('#error_create_timecode').html('<div class="alert alert-danger">' + err + '</div>');
						}						
					}
				});
			});
			
			$('#form_update_timecode').on('submit', function(event){
				event.preventDefault();
				$.ajax({
					url: "{{ url('mgtimecode/update_tc') }}",
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
						$('#error_update_timecode').html('<div class="alert alert-danger">' + err + '</div>');
					}
				});
			});
		});
	</script>
@stop