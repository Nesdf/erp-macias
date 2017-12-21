@extends('layouts.app')

@section('guia')
	<li>
		<i class="ace-icon fa fa-list"></i>
		<i>Elementos</i>
	</li>
	<li>
		<i class="ace-icon fa fa-tasks"></i>
		<a href="{{ url('mgtcrs') }}">TCR</a>
	</li>
@stop

@section('content')
    <div class="row">
		<div class="col-xs-12">
			<!-- PAGE CONTENT BEGINS -->
			
			<div class="row">
				<div class="col-xs-12">
					<h3 class="header smaller lighter blue">TCR de Macias Group</h3>

					<div class="clearfix">
						<div class="pull-right tableTools-container"></div>
					</div>
					<div class="table-header">
						<!--Results for "Latest Registered Domains"-->
						@if(\Request::session()->has('add_tcr'))
							<a data-toggle="modal" data-target="#modal_tcr" class="btn btn-success">
								TCR Nuevo
							</a>
						@endif
					</div>

					<!-- div.table-responsive -->

					<!-- div.dataTables_borderWrap -->
					<div><br><br>
						<table id="table_tcrs" class="stripe row-border">
							<thead>
								<tr>
									<th>ID</th>
									<th>TCR</th>
									<th></th>
								</tr>
							</thead>

							<tbody>
								@foreach($tcrs as $tcr)
									<tr>
										<td>
											{{ $tcr->id }}
										</td>
										<td>
											{{ $tcr->tcr }}
										</td>
										<td>
											@if(\Request::session()->has('edit_tcr'))
												<a data-id="{{ $tcr->id }}" data-toggle="modal" data-target="#modal_update_tcr" class="btn btn-xs btn-info" title="Editar">
													<i class="ace-icon fa fa-pencil bigger-120"></i>
												</a>		
											@endif
											@if(\Request::session()->has('delete_tcr'))
												<a data-toggle="modal" data-target="#modal_delete_proyecto" data-id="{{ $tcr->id }}" class="btn btn-xs btn-danger" title="Eliminar">
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
		<div class="modal fade" id="modal_tcr" data-name="modal" tabindex="-1" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="myModalLabel">
		  <div class="modal-dialog" role="document">
			<div class="modal-content">
			  <div class="modal-header">
				<!--<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>-->
				<h4 class="modal-title" id="t_header">TCR nuevo</h4>
				<div id="error_create_tcr"></div>
			  </div>
			  <form role="form" id="form_create_tcr">
			  <div class="modal-body">
					{{ csrf_field() }}
				<div class="form-group">
					<label for="tcr">Nombre del TCR</label>
					<input type="text" class="form-control" id="tcr" name="tcr" placeholder="Nombre del tcr">
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
		<div class="modal fade" id="modal_update_tcr" tabindex="-1" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="myModalLabel">
		  <div class="modal-dialog" role="document">
			<div class="modal-content">
			  <div class="modal-header">
				<!--<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>-->
				<h4 class="modal-title" id="t_header">Modificar TCR</h4>
				<div id="error_update_tcr"></div>
			  </div>
			  <form role="form" id="form_update_tcr">
			  <div class="modal-body">
					{{ csrf_field() }}
					<input type="hidden" id="id_update" name="id">
					<div class="form-group">
						<label for="tcr">TCR</label>
						<input type="text" class="form-control" id="tcr_update" name="tcr" placeholder="Nombre de la tcr">
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
				<h4 class="modal-title " id="myModalLabel">Eliminar TCR</h4>
			  </div>
			  <form id="form_delete_tcr" method="GET" action="{{ url('mgtcr/delete') }}">
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

			$('#table_tcrs').DataTable({
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
			
			

			$('#modal_delete_proyecto').on('shown.bs.modal', function(e){

				var id = $(e.relatedTarget).data().id;
				$('#form_delete_tcr').attr('action', '{{ url("mgtcr/delete") }}/' + id);
			});
			
			$('#modal_tcr').on('shown.bs.modal', function(){

				$('#form_create_tcr').on('submit', function(event){
					event.preventDefault();
					$.ajax({
						url: "{{ url('mgtcr/create') }}",
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
							$('#error_create_tcr').html('<div class="alert alert-danger">' + err + '</div>');
						}
					});
				});
			});

			$('#modal_update_tcr').on('shown.bs.modal', function(e){
				var id = $(e.relatedTarget).data().id;
				$.ajax({
					url: "{{ url('mgtcr/edit') }}" + "/" + id,
					type: "GET",
					success: function( data ){
						$('#id_update').val(data.id);
						$('input[name=tcr]').val(data.tcr);
					}
				});

				$('#form_update_tcr').on('submit', function(event){
					event.preventDefault();
					$.ajax({
						url: "{{ url('mgtcr/update') }}",
						type: "PUT",
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
							$('#error_update_tcr').html('<div class="alert alert-danger">' + err + '</div>');
						}
					});
				});
			});
		});
	</script>
@stop