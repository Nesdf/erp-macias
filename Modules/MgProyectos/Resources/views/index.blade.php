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
									<th>{{trans('mgproyectos::ui.attribute.titulo_serie')}}</th>
									<th class="hidden-480">{{trans('mgproyectos::ui.attribute.titulo_proyecto')}}</th>
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
												<a data-id="{{ $proyecto->id }}" data-toggle="modal" data-target="#modal_show_proyecto" class="btn btn-xs btn-warning" title="Consultar">
													<i class="ace-icon fa fa-book  bigger-120"></i>
												</a>
											@endif
											@if(\Request::session()->has('edit_proyecto'))
												<a data-id="{{ $proyecto->id }}" data-toggle="modal" data-target="#modal_update_proyecto" class="btn btn-xs btn-info" title="Editar">
													<i class="ace-icon fa fa-pencil bigger-120"></i>
												</a>
											@endif		
											@if(\Request::session()->has('delete_proyecto'))
												<a data-toggle="modal" data-target="#modal_delete_proyecto" data-id="{{ $proyecto->id }}" class="btn btn-xs btn-danger" title="Eliminar">
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
						<label >Cliente</label>
						<select class="form-control selectpicker" name="cliente" data-style="btn-primary" data-show-subtext="true" data-live-search="true" title="Seleccionar..." required>
							@foreach($clientes as $cliente)
								<option value="{{ $cliente->id }}"> {{ $cliente->razon_social }} </option>
							@endforeach
						</select>
					</div>	
					<div id="input_titulo_espanol" class="form-group"></div>
					<div id="input_titulo_ingles" class="form-group"></div>
					<div id="input_titulo_portugues" class="form-group"></div>
					<div class="form-group">
						<label for="temporada">Temporada</label>
						<input type="text" class="form-control" name="temporada" placeholder="Temporada">
					</div>
					<div id="input_titulo_espanol" class="form-group"></div>
					<div id="input_titulo_ingles" class="form-group"></div>
					<div id="input_titulo_portugues" class="form-group"></div>
					<div class="form-group">
						<label for="titulo_serie">{{trans('mgproyectos::ui.attribute.titulo_serie')}}</label>
						<input type="text" class="form-control" name="titulo_serie" placeholder="Título Original de la Serie">
					</div>	
					<div class="form-group">
						<label>{{trans('mgproyectos::ui.attribute.titulo_proyecto')}}</label>
						<input type="text" class="form-control" name="titulo_proyecto" placeholder="Título Aprobado del Proyecto">
					</div>	
					<div class="form-group">
					<label>Vía</label>
					<select class="form-control selectpicker" name="via" data-style="btn-primary" data-show-subtext="true" data-live-search="true" title="Seleccionar..." required>
						@foreach($vias as $via)
							<option value="{{ $via->id }}"> {{ $via->via }} </option>
						@endforeach
					</select>
				</div>
					<div class="form-group">
					<label for="exampleInputEmail1">{{trans('mgproyectos::ui.label.observaciones')}}</label>
					<textarea class="form-control" id="observaciones" name="observaciones"></textarea>
				</div>

				<label for="doblaje">{{trans('mgproyectos::ui.label.tipo_trabajo')}}</label>
				<hr>
				<label> {{trans('mgproyectos::ui.label.adr')}}</label>
				<table class="table">
					<tr>
						<td>
							<label>			
								<input type="checkbox" id="adr_ingles" name="adr_ingles"> {{trans('mgproyectos::ui.label.ingles')}}
							</label>
						</td>
						<td>
							<label>
								<input type="checkbox" id="adr_portugues"  name="adr_portugues"> {{trans('mgproyectos::ui.label.portugues')}}
							</label>
						</td>
						<td>
							<label>				
								<input type="checkbox" id="adr_espanol" name="adr_espanol"> {{trans('mgproyectos::ui.label.espanol')}}
							</label>
						</td>
					</tr>
				</table>
				<label> {{trans('mgproyectos::ui.label.mix')}}</label>
				<table class="table">
					<tr>
						<td>
							<label>				
								<input type="checkbox" id="mix20" name="mix20"> 2.0
							</label>
						</td>
						<td>
							<label>
								<input type="checkbox" id="mix51" name="mix51"> 5.1
							</label>
						</td>
						<td>
							<label>				
								<input type="checkbox" id="mix71" name="mix71"> 7.1
							</label>
						</td>
					</tr>
				</table>
				<label> {{trans('mgproyectos::ui.label.m_e')}}</label>
				<table class="table">
					<tr>
						<td>
							<label>				
								<input type="checkbox" name="relleno_mande"> {{trans('mgproyectos::ui.label.relleno')}}
							</label>
						</td>
						<td>
							<label>				
								<input type="checkbox" name="m_e_20"> 2.0
							</label>
						</td>
						<td>
							<label>				
								<input type="checkbox" name="m_e_51"> 5.1
							</label>
						</td>
						<td>
							<label>				
								<input type="checkbox" name="m_e_71"> 7.1
							</label>
						</td>
					</tr>
				</table>
				<label for="subtitulaje">{{trans('mgproyectos::ui.label.subtitulaje')}}</label>
				<table class="table">
					<tr>
						<td>
							<label>				
								<input type="checkbox" id="subtitulaje_espanol" name="subtitulaje_espanol"> {{trans('mgproyectos::ui.label.espanol')}}
							</label>
						</td>
						<td>
							<label>			
								<input type="checkbox" name="subtitulaje_ingles"> {{trans('mgproyectos::ui.label.ingles')}}
							</label>
						</td>
						<td>
							<label>				
								<input type="checkbox" name="subtitulaje_portugues"> {{trans('mgproyectos::ui.label.portugues')}}
							</label>
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
					  			<th><h4>{{trans('mgproyectos::ui.attribute.titulo_serie')}}:</h4> <span id="titulo_original_show"></span></th>
					  		</tr>
					  		<tr id="temporada_show"></tr>
					  		<tr>
					  			<th><h4>{{trans('mgproyectos::ui.attribute.titulo_proyecto')}}:</h4> <span id="titulo_aprobado_show"></span></th>
					  		</tr>
							<tr id="adr_show"></tr>
							<tr id="mix_show"></tr>
							<tr id="relleno_mande_show"></tr>
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
					<input type="hidden" name="id">
					<div class="form-group">
						<label>Selecciona un Cliente</label>
						<select class="form-control selectpicker" name="cliente" data-style="btn-primary" data-show-subtext="true" data-live-search="true" title="Seleccionar..." required>
							@foreach($clientes as $cliente)
								<option value="{{ $cliente->id }}"> {{ $cliente->razon_social }} </option>
							@endforeach
						</select>
					</div>	
					<div id="input_titulo_espanol_update"></div>
					<div id="input_titulo_ingles_update"></div>
					<div id="input_titulo_portugues_update"></div>
					<div class="form-group">
						<label for="temporada">Temporada</label>
						<input type="text" class="form-control" name="temporada" placeholder="Temporada">
					</div>	
					<div class="form-group">
						<label>{{trans('mgproyectos::ui.attribute.titulo_serie')}}</label>
						<input type="text" class="form-control" name="titulo_serie" placeholder="Título Original de la Serie">
					</div>	
					<div class="form-group">
						<label>{{trans('mgproyectos::ui.attribute.titulo_proyecto')}}</label>
						<input type="text" class="form-control" name="titulo_proyecto" placeholder="Título Aprobado del Proyecto">
					</div>					
					<div class="form-group">
						<select class="form-control selectpicker" name="via" data-style="btn-primary" data-show-subtext="true" data-live-search="true" title="Seleccionar..." required>
							<option select value="">{{trans('mgproyectos::ui.label.seleccionar')}}</option>
							@foreach($vias as $via)
								<option value="{{ $via->id }}"> {{ $via->via }} </option>
							@endforeach
						</select>
					</div>
					<label> {{trans('mgproyectos::ui.label.adr')}}</label>
				<table class="table">
					<tr>
						<td>
							<label>				
								<input type="checkbox" name="adr_ingles" id="adr_ingles_update"> {{trans('mgproyectos::ui.label.ingles')}}
							</label>
						</td>
						<td>
							<label>
								<input type="checkbox" name="adr_portugues" id="adr_portugues_update"> {{trans('mgproyectos::ui.label.portugues')}}
							</label>
							</div>
						</td>
						<td>
							<label>				
								<input type="checkbox"  name="adr_espanol" id="adr_espanol_update"> {{trans('mgproyectos::ui.label.espanol')}}
							</label>
						</td>
					</tr>
				</table>
				<label> {{trans('mgproyectos::ui.label.mix')}}</label>
				<table class="table">
					<tr>
						<td>
							<label>				
								<input type="checkbox" name="mix20"> 2.0
							</label>
						</td>
						<td>
							<label>
								<input type="checkbox" name="mix51"> 5.1
							</label>
						</td>
						<td>
							<label>				
								<input type="checkbox" name="mix71"> 7.1
							</label>
						</td>
					</tr>
				</table>
				<label> {{trans('mgproyectos::ui.label.m_e')}}</label>
				<table class="table">
					<tr>
						<td>
							<label>				
								<input type="checkbox" name="relleno_mande"> {{trans('mgproyectos::ui.label.relleno')}}
							</label>
						</td>
						<td>
							<label>			
								<input type="checkbox" name="m_e_20"> 2.0
							</label>
						</td>
						<td>
							<label>				
								<input type="checkbox" name="m_e_51"> 5.1
							</label>
						</td>
						<td>
							<label>				
								<input type="checkbox" name="m_e_71"> 7.1
							</label>
						</td>
					</tr>
				</table>

				<label for="subtitulaje">{{trans('mgproyectos::ui.label.subtitulaje')}}</label>
				<table class="table">
					<tr>
						<td>
							<label>				
								<input type="checkbox" name="subtitulaje_espanol"> Español
							</label>
						</td>
						<td>
							<label>				
								<input type="checkbox" name="subtitulaje_ingles"> Inglés
							</label>
						</td>
						<td>
							<label>				
								<input type="checkbox" name="subtitulaje_portugues"> Portugués
							</label>
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
				  <label>{{trans('mgproyectos::ui.label.deseas_eliminarlo')}}</label>
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

			/*
			* Modal para crear proyectos
			*/
			$('#modal_proyecto').on('shown.bs.modal', function(){

				//Limpiar inputs
				$("input[type=text], textarea, select").val("");
				$("input[type=checkbox], textarea").prop("checked", false);
				$('#input_titulo_espanol').html('');
				$('#input_titulo_ingles').html('');
				$('#input_titulo_portugues').html('');
				$('.selectpicker').selectpicker('refresh');	
				//Sección de inputs para crear
				$('input[name=adr_espanol]').on('click', function(){
					if($(this).is(':checked')){
						$('#input_titulo_espanol').html('<label>Título en Español</label> <input type="text" class="form-control" name="titulo_espanol" placeholder="Título en Español">');
					} else{
						$('#input_titulo_espanol').html('');
					}
				});

				$('input[name=adr_ingles]').on('click', function(){
					if($(this).is(':checked')){
						$('#input_titulo_ingles').html('<label>Título en Inglés</label> <input type="text" class="form-control" name="titulo_ingles" placeholder="Título en Inglés">');
					} else{
						$('#input_titulo_ingles').html('');
					}
				});

				$('#adr_portugues').on('click', function(){
					if($(this).is(':checked')){
						$('#input_titulo_portugues').html('<label>Título en Portugués</label> <input type="text" class="form-control" name="titulo_portugues" placeholder="Título en Portugués">');
					} else{
						$('#input_titulo_portugues').html('');
					}
				});


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
							if(error.responseJSON.msg.length > 0){
								var err = "";
							for(var i in error.responseJSON.msg){
								err += error.responseJSON.msg[i] + "<br>";														
							}
							$('#error_create_proyecto').html('<div class="alert alert-danger">' + err + '</div>');
							}
						}
					});
				});
			});

			/*
			* Modal para modificar proyectos
			*/
			$('#modal_update_proyecto').on('shown.bs.modal', function(e){
				var id = $(e.relatedTarget).data().id;

				$.ajax({
					url: "{{ url('mgproyectos/edit_proyecto') }}" + "/" + id,
					type: "GET",
					success: function(data){
						console.log(data);
						$('input[name=id]').val(data.id);
						$('input[name=titulo_serie]').val(data.titulo_original);
						$('input[name=titulo_proyecto]').val(data.titulo_aprobado);
						$('input[name=temporada]').val(data.temporada);
						$('select[name=cliente]').val(data.clienteId);	
						$('select[name=via]').val(data.viaId);
						$('#input_titulo_espanol_update').html('');
						$('#input_titulo_ingles_update').html('');
						$('#input_titulo_portugues_update').html('');

						//Checkbox ADR
						if(data.adr_espanol == true){
							$('#adr_espanol_update').prop("checked", true);
							$('#input_titulo_espanol_update').html('\
								<label>Título en Español</label>\
								<input type="text" class="form-control" name="titulo_espanol" value="'+(data.titulo_espanol == null ? '' : data.titulo_espanol)+'" placeholder="Título en Español" required> \
								');
						} else{
							$('#adr_espanol_update').prop("checked", false);
							$('#input_titulo_espanol').html('');
						}

						if(data.adr_ingles == true){
							$('#adr_ingles_update').prop("checked", true);
							$('#input_titulo_ingles_update').append('\
								<label>Título en Inglés</label>\
								<input type="text" class="form-control" name="titulo_ingles" value="'+(data.titulo_ingles == null ? '' : data.titulo_ingles)+'" laceholder="Título en Inglés" required> \
								');
						} else{
							$('#adr_ingles_update').prop("checked", false);
						}

						if(data.adr_portugues == true){
							$('#adr_portugues_update').prop("checked", true);
							$('#input_titulo_portugues_update').append('\
								<label>Título en Portugés</label>\
								<input type="text" class="form-control" name="titulo_portugues" value="'+(data.titulo_portugues == null ? '' : data.titulo_portugues)+'" placeholder="Título en Portugués" required> \
								');
						} else{
							$('#adr_portugues_update').prop("checked", false);
						}

						//Desaparecer inputs
						$('#adr_espanol_update').on('click', function(){
							if($(this).is(':checked')){
								$('#input_titulo_espanol_update').html('\
									<label>Título en Español</label> \
									<input type="text" class="form-control" name="titulo_espanol" value="'+(data.titulo_espanol == null ? '' : data.titulo_espanol) +'" placeholder="Título en Español" required>\
									');
							} else{
								$('#input_titulo_espanol_update').html('');
							}
						});

						$('#adr_ingles_update').on('click', function(){
							if($(this).is(':checked')){
								$('#input_titulo_ingles_update').html('\
									<label>Título en Inglés</label> \
									<input type="text" class="form-control" name="titulo_ingles" value="'+(data.titulo_ingles == null ? '' : data.titulo_ingles)+'" placeholder="Título en Inglés" required>\
									');
							} else{
								$('#input_titulo_ingles_update').html('');
							}
						});

						$('#adr_portugues_update').on('click', function(){
							if($(this).is(':checked')){
								$('#input_titulo_portugues_update').html('\
									<label>Título en Portugés</label> \
									<input type="text" class="form-control" name="titulo_portugues" value="'+(data.titulo_portugues == null ? '' : data.titulo_portugues)+'" placeholder="Título en Portugués" required>\
									');
							} else{
								$('#input_titulo_portugues_update').html('');
							}
						});

						//Checkbox MIX
						if(data.mix20 == true){
							$('input[name=mix20]').prop("checked", true);
						} else{
							$('input[name=mix20]').prop("checked", false);
						}

						if(data.mix51 == true){
							$('input[name=mix51]').prop("checked", true);
						} else{
							$('input[name=mix51]').prop("checked", false);
						}

						if(data.mix71 == true){
							$('input[name=mix71]').prop("checked", true);
						} else{
							$('input[name=mix71]').prop("checked", false);
						}

						//Relleno M&E
						if(data.relleno_mande == true){
							$("input[name=relleno_mande]").prop( "checked", true );
						} else{
							$('input[name=relleno_mande]').prop("checked", false);
						}

						if(data.m_e_20 == true){
							$('input[name=m_e_20').prop( "checked", true );
						} else{
							$('input[name=m_e_20]').prop("checked", false);
						}

						if(data.m_e_51 == true){
							$('input[name=m_e_51]').prop( "checked", true );
						} else{
							$('input[name=m_e_51]').prop("checked", false);
						}

						if(data.m_e_71 == true){
							$('input[name=m_e_71]').prop( "checked", true );
						} else{
							$('input[name=m_e_71]').prop("checked", false);
						}

						//Checkbox Subtitulos 
						if(data.subt_espanol == true){
							$('input[name=subtitulaje_espanol]').prop( "checked", true );
						} else{
							$('input[name=subtitulaje_espanol]').prop("checked", false);
						}

						if(data.subt_ingles == true){
							$('input[name=subtitulaje_ingles]').prop( "checked", true );
						} else{
							$('input[name=subtitulaje_ingles]').prop("checked", false);
						}

						if(data.subt_portugues == true){
							$('input[name=subtitulaje_portugues]').prop( "checked", true );
						} else{
							$('input[name=subtitulaje_portugues]').prop("checked", false);
						}

						$('.selectpicker').selectpicker('refresh');

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
						
					}
				});

			});

			/*
			* Modal para mostrar proyectos
			*/
			$('#modal_show_proyecto').on('shown.bs.modal', function(e){
				var id = $(e.relatedTarget).data().id;
				event.preventDefault();

				$.ajax({
					url: "{{ url('mgproyectos/show_proyecto') }}" + "/" + id,
					type: "GET",
					success: function( data ){
						
						if(data.proyecto[0].titulo_original != null){
							$('#titulo_original_show').html(data.proyecto[0].titulo_original);
						}
						if(data.proyecto[0].titulo_aprobado != null){
							$('#titulo_aprobado_show').html(data.proyecto[0].titulo_aprobado);
						}
						
						$('#cliente_show').html(data.proyecto[0].cliente);
						$('#temporada_show').html('<td><h4>Temporada:</h4> <span>'+data.proyecto[0].temporada+'</span></td>');
						$('#via_show').html('<td><h4>Vía:</h4> <span>'+data.proyecto[0].viaId+'</span></td>');
						var adr = '';
						if(data.proyecto[0].adr_espanol == true){
							adr += '<li>Español: &nbsp;'+data.proyecto[0].titulo_espanol+'</li>';
						}
						if(data.proyecto[0].adr_ingles == true){
							adr += '<li>Inglés: &nbsp;'+data.proyecto[0].titulo_ingles+'</li>';
						}
						if(data.proyecto[0].adr_portugues == true){
							adr += '<li>Portugués: &nbsp;'+data.proyecto[0].titulo_portugues+'</li>';
						}
						if(data.proyecto[0].adr_espanol == true || data.proyecto[0].adr_ingles == true || data.proyecto[0].adr_portugues == true ){
							$('#adr_show').html('<td><h4>ADR(s):</h4><ul>'+adr+'</ul></td>');
						}

						var mix = '';
						if(data.proyecto[0].mix20 == true){
							mix += '<li>2.0</li>';
						}
						if(data.proyecto[0].mix51 == true){
							mix += '<li>5.1</li>';
						}
						if(data.proyecto[0].mix71 == true){
							mix += '<li>7.1</li>';
						}
						if(data.proyecto[0].mix20 == true || data.proyecto[0].mix51 == true || data.proyecto[0].mix71 == true ){
							$('#mix_show').html('<td><h4>MIX(s):</h4><ul>'+mix+'</ul></td>');
						}

						var m_e = '';
						if(data.proyecto[0].relleno_mande == true){
							m_e += '<li>M&E</li>';
						}						
						if(data.proyecto[0].m_e_20 == true){
							$m_e += '<li>2.0</li>';
						}
						if(data.proyecto[0].m_e_51 == true){
							m_e += '<li>5.1</li>';
						}
						if(data.proyecto[0].m_e_71 == true){
							m_e += '<li>7.1</li>';
						}
						if(data.proyecto[0].relleno_mande == true || data.proyecto[0].m_e_20 == true || data.proyecto[0].m_e_51 == true || data.proyecto[0].m_e_71 == true ){
							$('#relleno_mande_show').html('<td><h4>Relleno:</h4><ul>'+m_e+'</ul></td>');
						}

						var subtitulo = '';
						if(data.proyecto[0].subt_espanol == true){
							subtitulo += '<li>Espanol</li>';
						}
						if(data.proyecto[0].subt_ingles == true){
							subtitulo += '<li>Inglés</li>';
						}
						if(data.proyecto[0].subt_portugues == true){
							subtitulo += '<li>Portugués</li>';
						}
						if(data.proyecto[0].subt_espanol == true || data.proyecto[0].subt_ingles == true || data.proyecto[0].subt_portugues == true ){
							$('#subtitulo_show').html('<td><h4>Subtitulo(s):</h4><ul>'+subtitulo+'</ul></td>');
						}
					}
				});

			});

			/*
			* Modal para eliminar proyectos
			*/
			$('#modal_delete_proyecto').on('shown.bs.modal', function(e) {
			  	var id = $(e.relatedTarget).data().id;
				$('#form_delete_proyecto').attr('action', '{{ url("mgproyectos/form_delete") }}/' + id);
			})	
					
	});
	
	</script>
@stop