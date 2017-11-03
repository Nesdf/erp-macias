@extends('layouts.app')

@section('guia')
	<li>
		<i class="ace-icon fa fa-users"></i>
		<a href="{{ url('mgactores') }}">Actores</a>
	</li>
@stop

@section('content')
    <div class="row">
		<div class="col-xs-12">
			<!-- PAGE CONTENT BEGINS -->
			
			<div class="row">
				<div class="col-xs-12">
					<h3 class="header smaller lighter blue">Actores de Macias Group</h3>

					<div class="clearfix">
						<div class="pull-right tableTools-container"></div>
					</div>
					<div class="table-header">
						<!--Results for "Latest Registered Domains"-->
						<a data-toggle="modal" data-target="#modal_save_artista" class="btn btn-success">
							Actor Nuevo
						</a>
					</div>

					<!-- div.table-responsive -->

					<!-- div.dataTables_borderWrap -->
					<div><br><br>
						<table id="table_actores" class="stripe row-border">
							<thead>
								<tr>
									<th>ID</th>
									<th>Nombre Completo</th>
									<th>Nombre Artístico</th>
									<th>Acciones</th>
								</tr>
							</thead>

							<tbody>
								@foreach($actores as $actor)
									<tr>
										<td>{{$actor->id}}</td>
										<td>{{$actor->nombre_completo}}</td>
										<td>{{$actor->nombre_artistico}}</td>
										<td>
											<a data-id="{{ $actor->id }}" data-toggle="modal" data-target="#modal_update_actor" class="btn btn-xs btn-info edit_id" title="Editar">
												<i class="ace-icon fa fa-pencil bigger-120"></i>
											</a>	

											<a data-toggle="modal" data-target="#modal_delete_actor" data-id="{{ $actor->id }}" class="btn btn-xs btn-danger delete_id" title="Eliminar">
												<i class="ace-icon fa fa-trash-o bigger-120"></i>
											</a>
												
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

<div class="col-md-12">
		<div class="modal fade" id="modal_save_artista" data-name="modal" tabindex="-1" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="myModalLabel">
		  <div class="modal-dialog" role="document">
			<div class="modal-content">
			  <div class="modal-header">
				<!--<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>-->
				<h4 class="modal-title" id="t_header">Actor Nuevo</h4>
				<div id="error_create_actor"></div>
			  </div>
			  <form role="form" id="form_create_actor">
			  <div class="modal-body">
					{{ csrf_field() }}
					<div class="form-group">
						<label for="nombre_completo">Nombre Completo</label>
						<input type="text" class="form-control" id="nombre_completo" name="nombre_completo" placeholder="Nombre Completo">
					</div>
					<div class="form-group">
						<label for="nombre_artistico">Nombre Artístico</label>
						<input type="text" class="form-control" id="nombre_artistico" name="nombre_artistico" placeholder="Nombre Artístico">
					</div>	
					<div>
						Agregar Folio <a href="javascript:void(0)" id="add_folio" class="btn btn-xs btn-info" >+</a>
						<hr>
						<div class="input_folios"></div>
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
		<div class="modal fade" id="modal_update_actor" tabindex="-1" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="myModalLabel">
		  <div class="modal-dialog" role="document">
			<div class="modal-content">
			  <div class="modal-header">
				<!--<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>-->
				<h4 class="modal-title" id="t_header">Modificar Actor</h4>
				<div id="error_update_actor"></div>
			  </div>
			  <form role="form" id="form_update_actor">
			  <div class="modal-body">
					{{ csrf_field() }}
					<input type="hidden" id="id_update" name="id">
					<div class="form-group">
						<label for="nombre_completo">Nombre Completo</label>
						<input type="text" class="form-control" id="nombre_completo_update" name="nombre_completo" placeholder="Nombre Completo">
					</div>
					<div class="form-group">
						<label for="nombre_artistico">Nombre Artítico</label>
						<input type="text" class="form-control" id="nombre_artistico_update" name="nombre_artistico" placeholder="Nombre Artístico">
					</div>	
					<div>
						Agregar Folio <a href="javascript:void(0)" id="add_folio_update" class="btn btn-xs btn-info" >+</a>
						<hr>
						<div class="input_folios"></div>
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
		<div class="modal fade" id="modal_delete_actor" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		  <div class="modal-dialog" role="document">
			<div class="modal-content">
			  <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title " id="myModalLabel">Eliminar Actor</h4>
			  </div>
			  <form id="form_delete_actor" method="GET" action="{{ url('mgactores/delete_actor') }}">
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

			$('#table_actores').DataTable({
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
		

		var conteo = 0;

		$('#add_folio').on('click', function(){
			conteo++;
			var h = $('.input_folios').append('<div id="div'+conteo+'"  ><label>Folio '+conteo+'</label><a href="javascript:void(0)" id="'+conteo+'" style="color:red;"  class="eliminar"> eliminar</a> <input type="text" name="folio'+conteo+'" class="form-control" required></div>');

			$('.eliminar').on('click', function(){

				var id = $(this).attr('id');
				console.log(id);
				$('div#div'+id).remove();
			});
		});
		
		$('#form_create_actor').on('submit', function(event){
			event.preventDefault();
			$.ajax({
				url: "{{ url('mgactores/save_actor') }}",
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
					$('#error_create_actor').html('<div class="alert alert-danger">' + err + '</div>');
				}
			});
		});

		$('.edit_id').on('click', function(){
			id = $( this ).data('id');				
			$.ajax({
				url: "{{ url('mgactores/edit_actor') }}" + "/" + id,
				type: "GET",
				success: function( data ){
					
					$('#id_update').val(data.actor.id);
					$('#nombre_completo_update').val(data.actor.nombre_completo);
					$('#nombre_artistico_update').val(data.actor.nombre_artistico);
						var conteo = 0;

						var add='';
							for(var i=0; i<data.credenciales.length; i++){
								conteo++;
								add += '<div id="div'+conteo+'"  ><label>Folio '+conteo+'</label><a href="javascript:void(0)" id="'+conteo+'" style="color:red;"  class="eliminar" data-id="'+data.credenciales[i].id+'"> eliminar</a> <input type="text"  class="form-control" value="'+data.credenciales[i].folio+'" disabled required></div>';
							}
						var h = $('.input_folios').append(add);
						$('#add_folio_update').on('click', function(){

								conteo++;
							    h = $('.input_folios').append('<div id="div'+conteo+'"  ><label>Folio '+conteo+'</label><a href="javascript:void(0)" id="'+conteo+'" style="color:red;"  class="eliminar"> eliminar</a> <input type="text" name="folio'+conteo+'" class="form-control" required></div>');
						});

						$('.eliminar').on('click', function(){
							var id = $(this).data('id');
							$.ajax({
								url: "{{ url('mgactores/delete-folio-actor') }}"+'/'+id,
								type: "GET",
								success: function( data ){
									console.log(data);
								}
							});

							var id = $(this).attr('id');
							$('div#div'+id).remove();
						});

					var add='';
					for(var i=0; i<data.credenciales.length; i++){
						add += '<div>'
					}
				}
			});
		 });

		$('#form_update_actor').on('submit', function(event){
			event.preventDefault();
			$.ajax({
				url: "{{ url('mgactores/update_actor') }}",
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
					$('#error_update_actor').html('<div class="alert alert-danger">' + err + '</div>');
				}
			});
		});

		$('.delete_id').on('click', function(){
			 id = $( this ).data('id');
			  $('#form_delete_actor').attr('action', '{{ url("mgactores/delete_actor") }}/' + id);
		 });



	});
		
	</script>
@stop