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
						<select class="form-control selectpicker" id="cliente" name="cliente" data-style="btn-primary" data-show-subtext="true" data-live-search="true" title="Seleccionar...">
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
						<input type="text" class="form-control" id="temporada" name="temporada" placeholder="Temporada">
					</div>
					<div id="input_titulo_espanol" class="form-group"></div>
					<div id="input_titulo_ingles" class="form-group"></div>
					<div id="input_titulo_portugues" class="form-group"></div>
					<div class="form-group">
						<label for="titulo_serie">{{trans('mgproyectos::ui.attribute.titulo_serie')}}</label>
						<input type="text" class="form-control" id="titulo_serie" name="titulo_serie" placeholder="Título Original de la Serie">
					</div>	
					<div class="form-group">
						<label for="titulo_proyecto">{{trans('mgproyectos::ui.attribute.titulo_proyecto')}}</label>
						<input type="text" class="form-control" id="titulo_proyecto" name="titulo_proyecto" placeholder="Título Aprobado del Proyecto">
					</div>	
					<div class="form-group">
					<label for="exampleInputEmail1">Vía</label>
					<select class="form-control selectpicker" id="via" name="via" data-style="btn-primary" data-show-subtext="true" data-live-search="true" title="Seleccionar...">
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
							<div class="form-group">				
								<input type="checkbox" id="adr_ingles" name="adr_ingles">
								<label for="adr_ingles">{{trans('mgproyectos::ui.label.ingles')}}</label>
							</div>
						</td>
						<td>
							<div class="form-group">
								<input type="checkbox" id="adr_portugues" name="adr_portugues">
									<label for="adr_portugues">{{trans('mgproyectos::ui.label.portugues')}}</label>
								</div>
							</div>
						</td>
						<td>
							<div class="form-group">				
								<input type="checkbox" id="adr_espanol" name="adr_espanol">
								<label for="adr_espanol">{{trans('mgproyectos::ui.label.espanol')}}</label>
							</div>
						</td>
					</tr>
				</table>
				<label> {{trans('mgproyectos::ui.label.mix')}}</label>
				<table class="table">
					<tr>
						<td>
							<div class="form-group">				
								<input type="checkbox" id="mix20" name="mix20">
								<label for="mix20">2.0</label>
							</div>
						</td>
						<td>
							<div class="form-group">
								<input type="checkbox" id="mix51" name="mix51">
									<label for="mix51">5.1</label>
								</div>
							</div>
						</td>
						<td>
							<div class="form-group">				
								<input type="checkbox" id="mix71" name="mix71">
								<label for="mix71">7.1</label>
							</div>
						</td>
					</tr>
				</table>
				<label> {{trans('mgproyectos::ui.label.m_e')}}</label>
				<table class="table">
					<tr>
						<td>
							<div class="form-group">				
								<input type="checkbox" id="relleno_mande" name="relleno_mande">
								<label for="relleno_mande">{{trans('mgproyectos::ui.label.relleno')}}</label>
							</div>
						</td>
						<td>
							<div class="form-group">				
								<input type="checkbox" id="m_e_20" name="m_e_20">
								<label for="m_e_20">2.0</label>
							</div>
						</td>
						<td>
							<div class="form-group">				
								<input type="checkbox" id="m_e_51" name="m_e_51">
								<label for="m_e_51">5.1</label>
							</div>
						</td>
						<td>
							<div class="form-group">				
								<input type="checkbox" id="m_e_71" name="m_e_71">
								<label for="m_e_71">7.1</label>
							</div>
						</td>
					</tr>
				</table>
				<label for="subtitulaje">{{trans('mgproyectos::ui.label.subtitulaje')}}</label>
				<table class="table">
					<tr>
						<td>
							<div class="form-group">				
								<input type="checkbox" id="subtitulaje_espanol" name="subtitulaje_espanol">
								<label for="subtitulaje_espanol">{{trans('mgproyectos::ui.label.espanol')}}</label>
							</div>
						</td>
						<td>
							<div class="form-group">				
								<input type="checkbox" id="subtitulaje_ingles" name="subtitulaje_ingles">
								<label for="subtitulaje_ingles">{{trans('mgproyectos::ui.label.ingles')}}</label>
							</div>
						</td>
						<td>
							<div class="form-group">				
								<input type="checkbox" id="sutitulaje_portugues" name="sutitulaje_portugues">
								<label for="sutitulaje_portugues">{{trans('mgproyectos::ui.label.portugues')}}</label>
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
					<input type="hidden" id="id_update" name="id">
					<div class="form-group">
						<label>Selecciona un Cliente</label>
						<select class="form-control selectpicker" id="cliente_update" name="cliente" data-style="btn-primary" data-show-subtext="true" data-live-search="true" title="Seleccionar...">
							@foreach($clientes as $cliente)
								<option value="{{ $cliente->id }}"> {{ $cliente->razon_social }} </option>
							@endforeach
						</select>
					</div>	
					<div id="input_titulo_espanol_update" class="form-group"></div>
					<div id="input_titulo_ingles_update" class="form-group"></div>
					<div id="input_titulo_portugues_update" class="form-group"></div>
					<div class="form-group">
						<label for="temporada">Temporada</label>
						<input type="text" class="form-control" id="temporada_update" name="temporada" placeholder="Temporada">

					<!-- -->
					</div>	
					<div class="form-group">
						<label>{{trans('mgproyectos::ui.attribute.titulo_serie')}}</label>
						<input type="text" class="form-control" id="titulo_original_update" name="titulo_serie" placeholder="Título Original de la Serie">
					</div>	
					<div class="form-group">
						<label for="titulo_aprobado_update">{{trans('mgproyectos::ui.attribute.titulo_proyecto')}}</label>
						<input type="text" class="form-control" id="titulo_aprobado_update" name="titulo_proyecto" placeholder="Título Aprobado del Proyecto">
					</div>					
					<div class="form-group">
						<select class="form-control selectpicker" id="via_update" name="via" data-style="btn-primary" data-show-subtext="true" data-live-search="true" title="Seleccionar...">
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
							<div class="form-group">				
								<input type="checkbox" id="adr_ingles_update" name="adr_ingles">
								<label for="adr_ingles">{{trans('mgproyectos::ui.label.ingles')}}</label>
							</div>
						</td>
						<td>
							<div class="form-group">
								<input type="checkbox" id="adr_portugues_update" name="adr_portugues">
									<label for="adr_portugues">{{trans('mgproyectos::ui.label.portugues')}}</label>
								</div>
							</div>
						</td>
						<td>
							<div class="form-group">				
								<input type="checkbox" id="adr_espanol_update" name="adr_espanol">
								<label for="adr_espanol">{{trans('mgproyectos::ui.label.espanol')}}</label>
							</div>
						</td>
					</tr>
				</table>
				<label> {{trans('mgproyectos::ui.label.mix')}}</label>
				<table class="table">
					<tr>
						<td>
							<div class="form-group">				
								<input type="checkbox" id="mix20_update" name="mix20">
								<label for="mix20">2.0</label>
							</div>
						</td>
						<td>
							<div class="form-group">
								<input type="checkbox" id="mix51_update" name="mix51">
									<label for="mix51">5.1</label>
								</div>
							</div>
						</td>
						<td>
							<div class="form-group">				
								<input type="checkbox" id="mix71_update" name="mix71">
								<label for="mix71">7.1</label>
							</div>
						</td>
					</tr>
				</table>
				<label> {{trans('mgproyectos::ui.label.m_e')}}</label>
				<table class="table">
					<tr>
						<td>
							<div class="form-group">				
								<input type="checkbox" id="relleno_mande_update" name="relleno_mande">
								<label for="relleno_mande_update">{{trans('mgproyectos::ui.label.relleno')}}</label>
							</div>
						</td>
						<td>
							<div class="form-group">				
								<input type="checkbox" id="m_e_20_update" name="m_e_20">
								<label for="m_e_20_update">2.0</label>
							</div>
						</td>
						<td>
							<div class="form-group">				
								<input type="checkbox" id="m_e_51_update" name="m_e_51">
								<label for="m_e_51_update">5.1</label>
							</div>
						</td>
						<td>
							<div class="form-group">				
								<input type="checkbox" id="m_e_71_update" name="m_e_71">
								<label for="m_e_71_update">7.1</label>
							</div>
						</td>
					</tr>
				</table>

				<label for="subtitulaje">{{trans('mgproyectos::ui.label.subtitulaje')}}</label>
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
						$('select[name=cliente]').val(data.clienteId);						
						$("#idioma_update option[value="+ data.idiomaId +"]").attr("selected",true);
						$('select[name=via]').val(data.viaId);
						$('.selectpicker').selectpicker('refresh');

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
						//Checkbox ADR
						if(data.adr_espanol == 1){
							$( "#adr_espanol_update" ).prop( "checked", true );
						}
						if(data.adr_ingles == 1){
							$( "#adr_ingles_update" ).prop( "checked", true );
						}
						if(data.adr_portugues == 1){
							$( "#adr_portugues_update" ).prop( "checked", true );
						}
						//Checkbox MIX
						if(data.mix20 == 1){
							$( "#mix20_update" ).prop( "checked", true );
						}
						if(data.mix51 == 1){
							$( "#mix51_update" ).prop( "checked", true );
						}
						if(data.mix71 == 1){
							$( "#mix71_update" ).prop( "checked", true );
						}
						//Relleno M&E
						if(data.relleno_mande == 1){
							$( "#relleno_mande_update" ).prop( "checked", true );
						}
						if(data.m_e_20 == 1){
							$( "#m_e_20_update" ).prop( "checked", true );
						}
						if(data.m_e_51 == 1){
							$( "#m_e_51_update" ).prop( "checked", true );
						}
						if(data.m_e_71 == 1){
							$( "#m_e_71_update" ).prop( "checked", true );
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
			 $('#adr_espanol').on('click', function(){
						if($('#adr_espanol').is(':checked')){
								$('#input_titulo_espanol').html('<label for="titulo_espanol">Título en Español</label> <input type="text" class="form-control" id="titulo_espanol" name="titulo_espanol" placeholder="Título en Español">');
						} else{
							$('#input_titulo_espanol').html('');
						}
					});

					$('#adr_ingles').on('click', function(){
						if($('#adr_ingles').is(':checked')){
								$('#input_titulo_ingles').html('<label for="titulo_ingles">Título en Inglés</label> <input type="text" class="form-control" id="titulo_ingles" name="titulo_ingles" placeholder="Título en Inglés">');
						} else{
							$('#input_titulo_ingles').html('');
						}
					});

					$('#adr_portugues').on('click', function(){
						if($('#adr_portugues').is(':checked')){
								$('#input_titulo_portugues').html('<label for="titulo_portugues">Título en Portugués</label> <input type="text" class="form-control" id="titulo_portugues" name="titulo_ portugues" placeholder="Título en Portugués">');
						} else{
							$('#input_titulo_portugues').html('');
						}
					});

					//Sección para update
					$('#adr_espanol_update').on('click', function(){
						if($('#adr_espanol_update').is(':checked')){
								$('#input_titulo_espanol_update').html('<label for="titulo_espanol">Título en Español</label> <input type="text" class="form-control" id="titulo_espanol" name="titulo_espanol" placeholder="Título en Español" required>');
						} else{
							$('#input_titulo_espanol_update').html('');
						}
					});

					$('#adr_ingles_update').on('click', function(){
						if($('#adr_ingles_update').is(':checked')){
								$('#input_titulo_ingles_update').html('<label for="titulo_espanol">Título en Inglés</label> <input type="text" class="form-control"  name="titulo_ingles" placeholder="Título en Inglés" required>');
						} else{
							$('#input_titulo_ingles_update').html('');
						}
					});

					$('#adr_portugues_update').on('click', function(){
							if($('#adr_portugues_update').is(':checked')){
									$('#input_titulo_portugues_update').html('<label for="titulo_portugues">Título del Episodio en Portugués</label> <input type="text" class="form-control"  name="titulo_portugues" placeholder="Título en Portugués" required>');
							} else{
								$('#input_titulo_portugues_update').html('');
							}
						});
				});
	
	</script>
@stop