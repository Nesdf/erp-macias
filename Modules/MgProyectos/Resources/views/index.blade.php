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
												<a data-id="{{ $proyecto->id }}" data-toggle="modal" data-target="#modal_show_proyecto" class="btn btn-xs btn-warning show_id" title="Consultar">
													<i class="ace-icon fa fa-book  bigger-120"></i>
												</a>
											@endif
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
						<label for="temporada">Temporada</label>
						<input type="text" class="form-control" id="temporada" name="temporada" placeholder="Temporada">
					</div>
					<div id="input_titulo_espanol" class="form-group"></div>
					<div id="input_titulo_ingles" class="form-group"></div>
					<div id="input_titulo_portugues" class="form-group"></div>
					<div class="form-group">
						<label for="titulo_serie">Título Original de la Serie</label>
						<input type="text" class="form-control" id="titulo_serie" name="titulo_serie" placeholder="Título Original de la Serie">
					</div>	
					<div class="form-group">
						<label for="titulo_proyecto">Título Aprobado del Proyecto</label>
						<input type="text" class="form-control" id="titulo_proyecto" name="titulo_proyecto" placeholder="Título Aprobado del Proyecto">
					</div>	
					<div class="form-group">
					<label for="exampleInputEmail1">Seleccionar Vía</label>
					<select class="form-control" id="via" name="via">
						<option value="">Seleccionar</option>
						@foreach($vias as $via)
							<option value="{{ $via->id }}"> {{ $via->via }} </option>
						@endforeach
					</select>
				</div>
					<div class="form-group">
					<label for="exampleInputEmail1">Observaciones</label>
					<textarea class="form-control" id="observaciones" name="observaciones"></textarea>
				</div>
					<label for="doblaje">Doblaje</label>
				<table class="table">
					<tr>
						<td>
							<div class="form-group">				
								<input type="checkbox" id="doblaje_espanol20" name="doblaje_espanol20">
								<label for="doblaje_espanol20">Doblaje Español 2.0</label>
							</div>
						</td>
						<td>
							<div class="form-group">
								<input type="checkbox" id="doblaje_ingles20" name="doblaje_ingles20">
									<label for="doblaje_ingles20">Doblaje Inglés 2.0</label>
								</div>
							</div>
						</td>
						<td>
							<div class="form-group">				
								<input type="checkbox" id="doblaje_portugues20" name="doblaje_portugues20">
								<label for="doblaje_portugues20">Doblaje Portugués 2.0</label>
							</div>
						</td>
					</tr>
					<tr>
						<td>
							<div class="form-group">				
								<input type="checkbox" id="doblaje_espanol51" name="doblaje_espanol51">
								<label for="doblaje_espanol51">Doblaje Español 5.1</label>
							</div>
						</td>
						<td>
							<div class="form-group">
								<input type="checkbox" id="doblaje_ingles51" name="doblaje_ingles51">
									<label for="doblaje_ingles51">Doblaje Inglés 5.1</label>
								</div>
							</div>
						</td>
						<td>
							<div class="form-group">				
								<input type="checkbox" id="doblaje_portugues51" name="doblaje_portugues51">
								<label for="doblaje_portugues51">Doblaje Portugués 5.1</label>
							</div>
						</td>
					</tr>
					<tr>
						<td>
							<div class="form-group">				
								<input type="checkbox" id="doblaje_espanol71" name="doblaje_espanol71">
								<label for="doblaje_espanol71">Doblaje Español 7.1</label>
							</div>
						</td>
						<td>
							<div class="form-group">
								<input type="checkbox" id="doblaje_ingles71" name="doblaje_ingles71">
									<label for="doblaje_ingles71">Doblaje Inglés 7.1</label>
								</div>
							</div>
						</td>
						<td>
							<div class="form-group">				
								<input type="checkbox" id="doblaje_portugues71" name="doblaje_portugues71">
								<label for="doblaje_portugues71">Doblaje Portugués 7.1</label>
							</div>
						</td>
					</tr>
				</table>
				<label for="subtitulaje">Subtitulaje</label>
				<table class="table">
					<tr>
						<td>
							<div class="form-group">				
								<input type="checkbox" id="subtitulaje_espanol" name="subtitulaje_espanol">
								<label for="subtitulaje_espanol">Español</label>
							</div>
						</td>
						<td>
							<div class="form-group">				
								<input type="checkbox" id="subtitulaje_ingles" name="subtitulaje_ingles">
								<label for="subtitulaje_ingles">Inglés</label>
							</div>
						</td>
						<td>
							<div class="form-group">				
								<input type="checkbox" id="sutitulaje_portugues" name="sutitulaje_portugues">
								<label for="sutitulaje_portugues">Portugués</label>
							</div>
						</td>
					</tr>
				</table>
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

	<!-- Modal Consulta-->
	<div class="col-md-12">
		<div class="modal fade" id="modal_show_proyecto" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		  <div class="modal-dialog" role="document">
			<div class="modal-content">
			  <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title " id="myModalLabel">Consulta Proyecto</h4>
			  </div>
			  <div class="modal-body">
			  	<div class="row">
			  		<div class="col-md-6">
			  			<table class="table">
							<tr>
					  			<th><h4>Cliente:</h4> <span id="cliente_show"></span></th>
					  		</tr>
							<tr>
					  			<th><h4>Proyecto:</h4> <span id="titulo_original_show"></span></th>
					  		</tr>
					  		<tr id="temporada_show"></tr>
					  		<tr>
					  			<th><h4>Título Aprobado:</h4> <span id="titulo_aprobado_show"></span></th>
					  		</tr>
							<tr id="titulo_espanol_show"></tr>
							<tr id="titulo_ingles_show"></tr>
							<tr id="titulo_portugues_show"></tr>

					  		<tr id="via_show"></tr>
							<tr id="subtitulo_show"></tr>
					  	</table>
			  		</div>
			  	</div>
			  </div>
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
						<label for="temporada">Temporada</label>
						<input type="text" class="form-control" id="temporada_update" name="temporada" placeholder="Temporada">

						<!--  -->
						<div id="titulo_espanol_update" class="form-group">
							<label for="exampleInputEmail1">Título en Español</label>
							<input type="text" class="form-control" name="titulo_espanol" id="input_titulo_espanol_update" placeholder="Título en Español">
						</div>
						<div id="titulo_ingles_update" class="form-group">
							<label for="input_titulo_ingles_update">Título en Inglés</label>
							<input type="text" class="form-control" name="titulo_ingles" id="input_titulo_ingles_update" placeholder="Título en Inglés">
						</div>
						<div id="titulo_portugues_update" class="form-group">
							<label >Título en Portugués</label>
							<input type="text" class="form-control" name="titulo_portugues"  id="input_titulo_portugues_update" placeholder="Título en Portugués">
						</div>

					<!-- -->
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
						<label for="via">Seleccionar Vía</label>
						<select class="form-control" id="via_update" name="via">
							<option select value="">Seleccionar</option>
							@foreach($vias as $via)
								<option value="{{ $via->id }}"> {{ $via->via }} </option>
							@endforeach
						</select>
					</div>
					<label for="doblaje">Doblaje</label>
				<table class="table">
					<tr>
						<td>
							<div class="form-group">				
								<input type="checkbox" id="doblaje_espanol20_update" name="doblaje_espanol20">
								<label for="doblaje_espanol20">Doblaje Español 2.0</label>
							</div>
						</td>
						<td>
							<div class="form-group">
								<input type="checkbox" id="doblaje_ingles20_update" name="doblaje_ingles20">
									<label for="doblaje_ingles20">Doblaje Inglés 2.0</label>
								</div>
							</div>
						</td>
						<td>
							<div class="form-group">				
								<input type="checkbox" id="doblaje_portugues20_update" name="doblaje_portugues20">
								<label for="doblaje_portugues20">Doblaje Portugues 2.0</label>
							</div>
						</td>
					</tr>
					<tr>
						<td>
							<div class="form-group">				
								<input type="checkbox" id="doblaje_espanol51_update" name="doblaje_espanol51">
								<label for="doblaje_espanol51">Doblaje Español 5.1</label>
							</div>
						</td>
						<td>
							<div class="form-group">
								<input type="checkbox" id="doblaje_ingles51_update" name="doblaje_ingles51">
									<label for="doblaje_ingles51">Doblaje Inglés 5.1</label>
								</div>
							</div>
						</td>
						<td>
							<div class="form-group">				
								<input type="checkbox" id="doblaje_portugues51_update" name="doblaje_portugues51">
								<label for="doblaje_portugues51">Doblaje Portugues 5.1</label>
							</div>
						</td>
					</tr>
					<tr>
						<td>
							<div class="form-group">				
								<input type="checkbox" id="doblaje_espanol71_update" name="doblaje_espanol71">
								<label for="doblaje_espanol71">Doblaje Español 7.1</label>
							</div>
						</td>
						<td>
							<div class="form-group">
								<input type="checkbox" id="doblaje_ingles71_update" name="doblaje_ingles71">
									<label for="doblaje_ingles71">Doblaje Inglés 7.1</label>
								</div>
							</div>
						</td>
						<td>
							<div class="form-group">				
								<input type="checkbox" id="doblaje_portugues71_update" name="doblaje_porugues71">
								<label for="doblaje_porugues71">Doblaje Portugues 7.1</label>
							</div>
						</td>
					</tr>
				</table>
				<label for="subtitulaje">Subtitulaje</label>
				<table class="table">
					<tr>
						<td>
							<div class="form-group">				
								<input type="checkbox" id="subtitulaje_espanol_update" name="subtitulaje_espanol">
								<label for="subtitulaje_espanol">Español</label>
							</div>
						</td>
						<td>
							<div class="form-group">				
								<input type="checkbox" id="subtitulaje_ingles_update" name="subtitulaje_ingles">
								<label for="subtitulaje_ingles">Inglés</label>
							</div>
						</td>
						<td>
							<div class="form-group">				
								<input type="checkbox" id="subtitulaje_portugues_update" name="subtitulaje_portugues">
								<label for="sutitulaje_portugues">Portugues</label>
							</div>
						</td>
					</tr>
				</table>
					
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
						$('#temporada_update').val(data.temporada);
						$("#cliente_update option[value="+ data.clienteId +"]").attr("selected",true);
						$("#idioma_update option[value="+ data.idiomaId +"]").attr("selected",true);
						$("#via_update option[value="+ data.viaId +"]").attr("selected",true);

						//titulo en otros idiomas
						$('#input_titulo_espanol_update').val(data.titulo_espanol);
						$('#input_titulo_ingles_update').val(data.titulo_ingles);
						$('#input_titulo_portugues_update').val(data.titulo_portugues);
						if(data.titulo_espanol === null ){
							$('#titulo_espanol_update').html("");
						}
						if( data.titulo_ingles === null ){
							$('#titulo_ingles_update').html("");
						}
						if( data.titulo_portugues === null ){
							$('#titulo_portugues_update').html("");
						}		
						//Checkbox titulos español
						if(data.dobl_espanol20 == 1){
							$( "#doblaje_espanol20_update" ).prop( "checked", true );
						}
						if(data.dobl_espanol51 == 1){
							$( "#doblaje_espanol51_update" ).prop( "checked", true );
						}
						if(data.dobl_espanol71 == 1){
							$( "#doblaje_espanol71_update" ).prop( "checked", true );
						}
						//Checkbox titulos inglés
						if(data.dobl_ingles20 == 1){
							$( "#doblaje_ingles20_update" ).prop( "checked", true );
						}
						if(data.dobl_ingles51 == 1){
							$( "#doblaje_ingles51_update" ).prop( "checked", true );
						}
						if(data.dobl_ingles71 == 1){
							$( "#doblaje_ingles71_update" ).prop( "checked", true );
						}
						//Checkbox titulos portugues
						if(data.dobl_portugues20 == 1){
							$( "#doblaje_portugues20_update" ).prop( "checked", true );
						}
						if(data.dobl_portugues51 == 1){
							$( "#doblaje_portugues51_update" ).prop( "checked", true );
						}
						if(data.dobl_portugues71 == 1){
							$( "#doblaje_portugues71_update" ).prop( "checked", true );
						}
						//Checkbox Subtitulos 
						if(data.subt_espanol == 1){
							$( "#subtitulaje_espanol_update" ).prop( "checked", true );
						}
						if(data.subt_ingles == 1){
							$( "#subtitulaje_ingles_update" ).prop( "checked", true );
						}
						if(data.subt_portugues == 1){
							$( "#subtitulaje_portugues_update" ).prop( "checked", true );
						}				
						
					}
				});
			 });

			 $('.show_id').on('click', function(){
				 id = $( this ).data('id');				
				$.ajax({
					url: "{{ url('mgproyectos/show_proyecto') }}" + "/" + id,
					type: "GET",
					success: function( data ){
						console.log(data.proyecto[0]);
						
						
						if(data.proyecto[0].titulo_original != null){
							$('#titulo_original_show').html(data.proyecto[0].titulo_original);
						}
						if(data.proyecto[0].titulo_aprobado != null){
							$('#titulo_aprobado_show').html(data.proyecto[0].titulo_aprobado);
						}
						
						$('#cliente_show').html(data.proyecto[0].cliente);
						$('#temporada_show').html('<td><h4>Temporada:</h4> <span>'+data.proyecto[0].temporada+'</span></td>');
						$('#via_show').html('<td><h4>Vía:</h4> <span>'+data.proyecto[0].viaId+'</span></td>');
						
						if(data.proyecto[0].titulo_espanol != null){
							$('#titulo_espanol_show').html('<th><h4>Título en Español:</h4> <span>'+data.proyecto[0].titulo_espanol +'</span></th>');
						}else{
							$('#titulo_espanol_show').html();
						}
						if(data.proyecto[0].titulo_ingles != null){
							$('#titulo_ingles_show').html('<th><h4>Título en Inglés:</h4> <span>'+data.proyecto[0].titulo_ingles +'</span></th>');
						}else{
							$('#titulo_ingles_show').html();
						}
						if(data.proyecto[0].titulo_portugues != null){
							$('#titulo_portugues_show').html('<th><h4>Título en Portugués:</h4> <span>'+data.proyecto[0].titulo_portugues +'</span></th>');
						}else{
							$('#titulo_portugues_show').html();
						}
						var subtitulo = '';
						if(data.proyecto[0].subt_espanol == true){
							subtitulo = '<li>Espanol</li>';
						}
						if(data.proyecto[0].subt_ingles == true){
							subtitulo += '<li>Espanol</li>';
						}
						if(data.proyecto[0].subt_portugues == true){
							subtitulo += '<li>Espanol</li>';
						}
						if(data.proyecto[0].subt_espanol == true || data.proyecto[0].subt_ingles == true || data.proyecto[0].subt_portugues == true ){
							$('#subtitulo_show').html('<td><h4>Subtitulo(s):</h4><ul>'+subtitulo+'</ul></td>');
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

			 //Sección de inputs para crear
			 $('#doblaje_espanol20, #doblaje_espanol51, #doblaje_espanol71').on('click', function(){
						if($('#doblaje_espanol20, #doblaje_espanol51, #doblaje_espanol71').is(':checked')){
								$('#input_titulo_espanol').html('<label for="titulo_espanol">Título en Español</label> <input type="text" class="form-control" id="titulo_espanol" name="titulo_espanol" placeholder="Título en Español">');
						} else{
							$('#input_titulo_espanol').html('');
						}
					});

					$('#doblaje_ingles20, #doblaje_ingles51, #doblaje_ingles71').on('click', function(){
						if($('#doblaje_ingles20, #doblaje_ingles51, #doblaje_ingles71').is(':checked')){
								$('#input_titulo_ingles').html('<label for="titulo_ingles">Título en Inglés</label> <input type="text" class="form-control" id="titulo_ingles" name="titulo_ingles" placeholder="Título en Inglés">');
						} else{
							$('#input_titulo_ingles').html('');
						}
					});

					$('#doblaje_portugues20, #doblaje_portugues51, #doblaje_portugues71').on('click', function(){
						if($('#doblaje_portugues20, #doblaje_portugues51, #doblaje_portugues71').is(':checked')){
								$('#input_titulo_portugues').html('<label for="titulo_portugues">Título en Portugués</label> <input type="text" class="form-control" id="titulo_portugues" name="titulo_ portugues" placeholder="Título en Portugués">');
						} else{
							$('#input_titulo_portugues').html('');
						}
					});

					//Sección para update
					$('#doblaje_espanol20_update, #doblaje_espanol51_update, #doblaje_espanol71_update').on('click', function(){
						if($('#doblaje_espanol20_update, #doblaje_espanol51_update, #doblaje_espanol71_update').is(':checked')){
								$('#titulo_espanol_update').html('<label for="titulo_espanol">Título en Español</label> <input type="text" class="form-control" id="titulo_espanol" name="titulo_espanol" placeholder="Título en Español" required>');
						} else{
							$('#titulo_espanol_update').html('');
						}
					});

					$('#doblaje_ingles20_update, #doblaje_ingles51_update, #doblaje_ingles71_update').on('click', function(){
						if($('#doblaje_ingles20_update, #doblaje_ingles51_update, #doblaje_ingles71_update').is(':checked')){
								$('#titulo_ingles_update').html('<label for="titulo_espanol">Título en Inglés</label> <input type="text" class="form-control"  name="titulo_ingles" placeholder="Título en Inglés" required>');
						} else{
							$('#titulo_ingles_update').html('');
						}
					});

					$('#doblaje_portugues20_update, #doblaje_portugues51_update, #doblaje_portugues71_update').on('click', function(){
							if($('#doblaje_portugues20_update, #doblaje_portugues51_update, #doblaje_portugues71_update').is(':checked')){
									$('#titulo_portugues_update').html('<label for="titulo_portugues">Título del Episodio en Portugués</label> <input type="text" class="form-control"  name="titulo_portugues" placeholder="Título en Portugués" required>');
							} else{
								$('#titulo_portugues_update').html('');
							}
						});
				});
	
	</script>
@stop