@extends('layouts.app')
@section('url_css')
	
@stop

@section('guia')
	<li>
		<i class="ace-icon fa fa-child"></i>
		<a href="#">Personal</a>
	</li>
@stop

@section('content')

			<div class="row">
				<div class="col-xs-12">
					<h3 class="header smaller lighter blue">Permisos de acceso - Macias Group</h3>
					<div class="alert alert-info">
						<i class="glyphicon glyphicon-info-sign"></i>
						Seleccionar a que sección puede ingresará el usuario.
					</div>

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
						Agregar Permisos
					</div>
					<div class="col-md-12">
						<div id="resp_message"></div>
					</div>
					<div class="col-md-12">
						<br>
						<div class="alert alert-warning">
							<table>
								<tr>
									<th><span style="text-decoration: underline;">Nombre:</span> {{$empleado[0]->name}} {{$empleado[0]->ap_paterno}} {{$empleado[0]->ap_materno}}</th>
								</tr>
								<tr>
									<th><span style="text-decoration: underline;">Puesto:</span> {{$empleado[0]->job}}</th>
								</tr>
							</table>
						</div>
						<div class="col-md-12">
							<h4><strong>Configuración del sistema</strong></h4>
							<label class="alert alert-info col-md-12">
								INDICACIONES:
								<ul>
									<li>
										Al activar la casilla permites que el usuario pueda realizar la actividad con su usuario.
									</li>
									<li>
										Los campos de color <span style="background-color: blue; color: white;">azul</span> son clave dentro del sistema.
									</li>
								</ul>
							</label><br><br>
						</div>
						{{ csrf_field() }}

						<!-- -->
						<div class="row">
						  <div class="col-sm-6 col-md-3">
						    <div class="thumbnail">
						      <div class="caption">
						        <h3>Administrar Paises y Ciudades</h3>
										<p>
											<label>
												Dashboard Paises y Ciudades<br>
												<input type="checkbox" name="mgsucursales" class="toggle"  @if( isset($urlArray['mgsucursales']) ) checked @endif >
											</label>
										</p>
										<p>
											<label>Agregar Ciudad<br>
											<input type="checkbox" name="add_sucursal-add_ciudad-edit_sucursal-edit_ciudad" class="toggle" @if( isset($urlArray['add_sucursal']) ) checked @endif >
											</label>
										</p>
										<p>
											<label>Eliminar Ciudad<br>
											<input type="checkbox" name="delete_ciudad-delete_pais" class="toggle"  @if( isset($urlArray['delete_ciudad']) ) checked @endif >
											</label>
										</p>
						      </div>
						    </div>
							</div>
							<div class="col-sm-6 col-md-3">
							    <div class="thumbnail">
							      <div class="caption">
							        <h3>Administrar Puestos de Trabajo</h3>
											<p>
												<label>Dashboard Puesto de Trabajo<br>
												<input type="checkbox" name="mgpuestos" class="toggle"  @if( isset($urlArray['mgpuestos']) ) checked @endif >
												</label>
											</p>
											<p>
												<label>Agregar Puesto de Trabajo<br>
												<input type="checkbox" name="add_puesto" class="toggle" @if( isset($urlArray['add_puesto']) ) checked @endif >
												</label>
											</p>
											<p>
												<label>Editar Puesto de Trabajo<br>
												<input type="checkbox" name="edit_puesto-update_puesto" class="toggle"  @if( isset($urlArray['edit_puesto']) ) checked @endif >
												</label>
											</p>
											<p>
												<label>Eliminar Puesto de Trabajo<br>
												<input type="checkbox" name="delete_puesto" class="toggle"  @if( isset($urlArray['delete_puesto']) ) checked @endif >
												</label>
											</p>
							      </div>
							    </div>
						  </div>
							<div class="col-sm-6 col-md-3">
							    <div class="thumbnail">
							      <div class="caption">
							        <h3>Administrar TCRS</h3>
											<p>
												<label>Dashboard TCR<br>
												<input type="checkbox" name="mgtcr" class="toggle" @if( isset($urlArray['mgtcr']) ) checked @endif >
												</label>
											</p>
											<p>
												<label>Agregar TCR<br>
												<input type="checkbox" name="add_tcr" class="toggle" @if( isset($urlArray['add_tcr']) ) checked @endif >
												</label>
											</p>
											<p>
												<label>Editar TCR<br>
												<input type="checkbox" name="edit_tcr-update_tcr" class="toggle" @if( isset($urlArray['edit_tcr']) ) checked @endif >
												</label>
											</p>
											<p>
												<label>Eliminar TCR<br>
												<input type="checkbox" name="delete_tcr" class="toggle" @if( isset($urlArray['delete_tcr']) ) checked @endif >
												</label>
											</p>
							      </div>
							    </div>
						  </div>
							<div class="col-sm-6 col-md-3">
							    <div class="thumbnail">
							      <div class="caption">
							        <h3>Administrar Vias</h3>
											<p>
												<label>Dashboard Vias<br>
												<input type="checkbox" name="mgvias" class="toggle" @if( isset($urlArray['mgvias']) ) checked @endif >
												</label>
											</p>
											<p>
												<label>Agregar Via<br>
												<input type="checkbox" name="add_via" class="toggle" @if( isset($urlArray['add_via']) ) checked @endif >
												</label>
											</p>
											<p>
												<label>Editar Via<br>
												<input type="checkbox" name="edit_via-update_via" class="toggle" @if( isset($urlArray['edit_via']) ) checked @endif >
												</label>
											</p>
											<p>
												<label>Eliminar Via<br>
												<input type="checkbox" name="delete_via" class="toggle" @if( isset($urlArray['delete_via']) ) checked @endif >
												</label>
											</p>
							      </div>
							    </div>
						  </div>
						</div>
						<div class="row">
						  <div class="col-sm-6 col-md-3">
						    <div class="thumbnail">
						      <div class="caption">
						        <h3>Administrar Salas</h3>
						        <p>
											<label>Dashboard Salas<br>
											<input type="checkbox" name="mgsalas" class="toggle" @if( isset($urlArray['mgsalas']) ) checked @endif >
											</label>
										</p>
										<p>
											<label>Agregar Sala<br>
											<input type="checkbox" name="add_sala" class="toggle" @if( isset($urlArray['add_sala']) ) checked @endif >
											</label>
										</p>
										<p>
											<label>Editar Sala<br>
											<input type="checkbox" name="edit_sala-update_sala-edit_estudio-add_estudio" class="toggle" @if( isset($urlArray['edit_sala']) ) checked @endif >
											</label>
										</p>
										<p>
											<label>Eliminar Sala<br>
											<input type="checkbox" name="delete_sala" class="toggle" @if( isset($urlArray['delete_sala']) ) checked @endif >
											</label>
										</p>
						      </div>
						    </div>
						  </div>
							<div class="col-sm-6 col-md-3">
						    <div class="thumbnail">
						      <div class="caption">
						        <h3>Administrar Personal</h3>
						        <p>
											<label>Dashboard Personal<br>
											<input type="checkbox" name="mgpersonal" class="toggle" @if( isset($urlArray['mgpersonal']) ) checked @endif >
											</label>
										</p>
										<p>
											<label>Agregar Personal<br>
											<input type="checkbox" name="add_personal" class="toggle" @if( isset($urlArray['add_personal']) ) checked @endif >
											</label>
										</p>
										<p>
											<label>Editar Personal<br>
											<input type="checkbox" name="edit_personal-update_personal" class="toggle" @if( isset($urlArray['edit_personal']) ) checked @endif >
											</label>
										</p>
										<p>
											<label>Eliminar Personal<br>
											<input type="checkbox" name="delete_personal" class="toggle" @if( isset($urlArray['delete_personal']) ) checked @endif >
											</label>
										</p>
										<p>
											<label>Permisos de acceso<br>
											<input type="checkbox" name="permisos_acceso-add_permisos" class="toggle" @if( isset($urlArray['permisos_acceso']) ) checked @endif >
											</label>
										</p>
						      </div>
						    </div>
						  </div>
							<div class="col-sm-6 col-md-3">
						    <div class="thumbnail">
						      <div class="caption">
						        <h3>Administrar Clientes</h3>
						        <p>
											<label>Dashboard Cliente<br>
											<input type="checkbox" name="mgclientes-list_countries" class="toggle" @if( isset($urlArray['mgclientes']) ) checked @endif >
											</label>
										</p>
										<p>
											<label>Agregar Cliente<br>
											<input type="checkbox" name="add_cliente" class="toggle" @if( isset($urlArray['add_cliente']) ) checked @endif >
											</label>
										</p>
										<p>
											<label>Editar Cliente<br>
											<input type="checkbox" name="edit_cliente-update_cliente" class="toggle" @if( isset($urlArray['edit_cliente']) ) checked @endif >
											</label>
										</p>
										<p>
											<label>Eliminar Cliente<br>
											<input type="checkbox" name="delete_cliente" class="toggle" @if( isset($urlArray['delete_cliente']) ) checked @endif >
											</label>
										</p>
						      </div>
						    </div>
						  </div>
							<div class="col-sm-6 col-md-3">
						    <div class="thumbnail">
						      <div class="caption">
						        <h3>Administrar Proyectos</h3>
						        <p>
											<label>Dashboard Proyectos<br>
											<input type="checkbox" name="mgproyectos-show_proyecto" class="toggle"  @if( isset($urlArray['mgproyectos']) ) checked @endif >
											</label>
										</p>
										<p>
											<label>Agregar Proyecto<br>
											<input type="checkbox" name="add_proyecto" class="toggle"  @if( isset($urlArray['add_proyecto']) ) checked @endif >
											</label>
										</p>
										<p>
											<label>Editar Proyecto<br>
											<input type="checkbox" name="edit_proyecto-update_proyecto" class="toggle"  @if( isset($urlArray['edit_proyecto']) ) checked @endif >
											</label>
										</p>
										<p>
											<label>Eliminar Proyecto<br>
											<input type="checkbox" name="delete_proyecto" class="toggle"  @if( isset($urlArray['delete_proyecto']) ) checked @endif >
											</label>
										</p>
						      </div>
						    </div>
						  </div>
						</div>
						<div class="row">
						  <div class="col-sm-6 col-md-3">
						    <div class="thumbnail">
						      <div class="caption">
						        <h3>Administrar Episodios</h3>
										<div class="alert alert-info" role="alert">
											<i class="glyphicon glyphicon-info-sign"></i> Para que el Productor y traductor puedan modificar sus actividades se debe activar todas las opciones de este módulo.
										</div>
						        <p>
											<label>Dashboard Episodios<br>
											<input type="checkbox" name="mgepisodios-show_episodio" class="toggle"  @if( isset($urlArray['mgepisodios']) ) checked @endif >
											</label>
										</p>
										<p>
											<label>Agregar Episodio<br>
											<input type="checkbox" name="add_episodio" class="toggle"  @if( isset($urlArray['add_episodio']) ) checked @endif >
											</label>
										</p>
										<p>
											<label>Editar Episodio<br>
											<input type="checkbox" name="edit_episodio-update_episodio-update_configuracion_episodio" class="toggle" @if( isset($urlArray['edit_episodio']) ) checked @endif >
											</label>
										</p>
										<p>
											<label style="color: blue;">Mostrar Fecha de Entrega<br>
											<input type="checkbox" name="show_fecha_entrega" class="toggle"  @if( isset($urlArray['show_fecha_entrega']) ) checked @endif >
											</label>
										</p>
						      </div>
						    </div>
						  </div>
							<div class="col-sm-6 col-md-3">
						    <div class="thumbnail">
						      <div class="caption">
						        <h3>Administrar Calificación del Material</h3>
						        <p>
											<label>Calificar Material<br>
											<input type="checkbox" name="add_calificar_material-show_calificar_material" class="toggle" @if( isset($urlArray['add_calificar_material']) ) checked @endif >
											</label>
										</p>
										<p>
											<label>Editar Calificación de Material<br>
												<input type="checkbox" name="edit_calificar_material-update_calificar_material-add_timecode" class="toggle" @if( isset($urlArray['edit_calificar_material']) ) checked @endif >
											</label>
										</p>
						      </div>
						    </div>
						  </div>
							<div class="col-sm-6 col-md-3">
						    <div class="thumbnail">
						      <div class="caption">
						        <h3>Administrar Timecode</h3>
						        <p>
											<label>Dashboard Timecode<br>
											<input type="checkbox" name="mgtimecode" class="toggle" @if( isset($urlArray['mgtimecode']) ) checked @endif >
											</label>
										</p>
										<p>
											<label>Agregar Timecode<br>
											<input type="checkbox" name="add_tc" class="toggle" @if( isset($urlArray['add_tc']) ) checked @endif >
											</label>
										</p>
										<p>
											<label>Editar Timecode<br>
											<input type="checkbox" name="edit_tc-update_tc" class="toggle" @if( isset($urlArray['edit_tc']) ) checked @endif >
											</label>
										</p>
										<p>
											<label>Eliminar Timecode<br>
											<input type="checkbox" name="delete_tc" class="toggle" @if( isset($urlArray['delete_tc']) ) checked @endif >
											</label>
										</p>
										<p>
											<label>PDF Time Code<br>
											<input type="checkbox" name="create_timecode_pdf" class="toggle" @if( isset($urlArray['create_timecode_pdf']) ) checked @endif >
											</label>
										</p>
						      </div>
						    </div>
						  </div>
							<div class="col-sm-6 col-md-3">
						    <div class="thumbnail">
						      <div class="caption">
						        <h3>Administrar Productor</h3>
						        <p>
											<label>Lista de Episodios asignados<br>
											<input type="checkbox" name="add_productor" class="toggle" @if( isset($urlArray['mgcalendar']) ) checked @endif >&nbsp;
											</label>
										</p>
						      </div>
						    </div>
						  </div>
						</div>
						<div class="row">
						  <div class="col-sm-6 col-md-3">
						    <div class="thumbnail">
						      <div class="caption">
						        <h3>Administrar Descripción de Timecode</h3>
						        <p>
											<label>Dashboard Descripción de Timecode<br>
											<input type="checkbox" name="mgtiporeporte" class="toggle" @if( isset($urlArray['mgtiporeporte']) ) checked @endif >&nbsp;
											</label>
										</p>
										<p>
											<label>Agregar Descripción de Timecode<br>
											<input type="checkbox" name="add_reporte" class="toggle" @if( isset($urlArray['add_reporte']) ) checked @endif >
											</label>
										</p>
										<p>
											<label>Editar Descripción de Timecode<br>
											<input type="checkbox" name="edit_reporte-update_reporte" class="toggle" @if( isset($urlArray['edit_reporte']) ) checked @endif >
											</label>
										</p>
										<p>
											<label>Editar Descripción de Timecode<br>
											<input type="checkbox" name="edit_reporte-update_reporte" class="toggle" @if( isset($urlArray['edit_reporte']) ) checked @endif >
											</label>
										</p>
										<p>
											<label>Eliminar Descripción de Timecode<br>
											<input type="checkbox" name="delete_reporte" class="toggle" @if( isset($urlArray['delete_reporte']) ) checked @endif >&nbsp;
											</label>
										</p>
						      </div>
						    </div>
						  </div>
							<div class="col-sm-6 col-md-3">
						    <div class="thumbnail">
						      <div class="caption">
						        <h3>Administrar Calendario de llamado</h3>
						        <p>
											<label>Generar Llamados<br>
											<input type="checkbox" name="mgcalendar-llamados_salas-llamado_episodios-llamado_salas-llamado-credenciales_actores-delete_llamado-ajax_get_personajes" class="toggle" @if( isset($urlArray['mgcalendar']) ) checked @endif >
											</label>
										</p>
										<p>
											<label>Re-agendar Llamados<br>
											<input type="checkbox" name="reagendar_llamado-search_llamado_reagendado-save_llamado_reagendado" class="toggle" @if( isset($urlArray['mgcalendar']) ) checked @endif >
											</label>
										</p>
										<p>
											<label>Consultar llamado<br>
											<input type="checkbox" name="list_llamado-search_llamado-credenciales_actores-edit_llamado-delete_llamado"class="toggle"  @if( isset($urlArray['list_llamado']) ) checked @endif >
											</label>
										</p>
										<p>
											<label>Generar PDF de Llamado<br>
											<input type="checkbox" name="pdf_llamado" class="toggle" @if( isset($urlArray['pdf_llamado']) ) checked @endif >
											</label>
										</p>
						      </div>
						    </div>
						  </div>
							<div class="col-sm-6 col-md-3">
						    <div class="thumbnail">
						      <div class="caption">
						        <h3>Administrar Actores</h3>
						        <p>
											<label>Dashboard Actores<br>
											<input type="checkbox" name="mgactores" class="toggle" @if( isset($urlArray['mgactores']) ) checked @endif >
											</label>
										</p>
										<p>
											<label>Agregar Actor<br>
											<input type="checkbox" name="add_actor-delete_folio_actor" class="toggle" @if( isset($urlArray['add_actor']) ) checked @endif >
											</label>
										</p>
										<p>
											<label>Editar Actor<br>
											<input type="checkbox" name="edit_actor-update_actor" class="toggle" @if( isset($urlArray['edit_actor']) ) checked @endif >
											</label>
										</p>
										<p>
											<label>Eliminar Actor<br>
											<input type="checkbox" name="delete_actor" class="toggle" @if( isset($urlArray['delete_actor']) ) checked @endif >
											</label>
										</p>
						      </div>
						    </div>
						  </div>
							<div class="col-sm-6 col-md-3">
						    <div class="thumbnail">
						      <div class="caption">
						        <h3>Administrar Traductor</h3>
						        <p>
											<label>Lista de Episodios asignados<br>
											<input type="checkbox" name="add_traductor" class="toggle" @if( isset($urlArray['mgactores']) ) checked @endif >&nbsp;
											</label>
										</p>
						      </div>
						    </div>
						  </div>
						</div>
						<!-- -->
						<div class="row">
							<div class="col-sm-6 col-md-3">
							    <div class="thumbnail">
							      <div class="caption">
							        <h3>Administrar Contabilida</h3>
											<p>
												<label>Contabilida<br>
												<input type="checkbox" name="mgcontabilidad-reporte_general-reporte_nomina_actores-ajax_nomina_actores-ajax_reporte_general-reporte_llamado_actores-ajax_llamado_actores-reporte_nomina-ajax_nomina-reporte_proyecto-ajax_reporte_proyecto-detalle_episodios_actores-reporte_episodio-ajax_reporte_episodios-reporte_trabajo_actor-detalle_trabajo_actor-detalle_trabajo_actor-detalle_trabajo_actor-get_search_llamados-get_search_nomina_actores-get_detalle_por_actor" class="toggle" @if( isset($urlArray['mgcontabilidad']) ) checked @endif >
												</label>
											</p>
							      </div>
							    </div>
						  </div>
						</div>

@stop

@section('script')
	<script type="text/javascript">
		$(document).ready(function(){
			$('input').on('click', function(){

				var _token = $('input[name]').val();
				var id = "{{$id}}";
				var name = $(this).attr('name');
				var status = "";

				if($(this).prop('checked')){
					status = 'on';
				} else {
					status = 'off';
				}

				$.ajax({
					url: "{{ url('mgpersonal/save-permisos') }}",
					type: "POST",
					data: {'id':id, '_token':_token, 'name': name, 'status': status},
					success: function( data ){
						console.log(data);
						if(data.msg == 'success'){
							$('#resp_message').html('<div class="alert alert-success" style="text-align: center;">Exito. Permiso modificado.</div>');
							//$('#resp_message').html().delay(100);
						}
					},
					error: function(error){
						console.log(error);
					}
				});
			});
		});
	</script>
@stop
