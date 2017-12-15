@extends('layouts.app')

@section('guia')
	<li>
		<i class="ace-icon fa fa-child"></i>
		<a href="#">Personal</a>
	</li>
@stop

@section('content')
    <div class="row">
		<div class="col-xs-12">
			<!-- PAGE CONTENT BEGINS -->
			
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
						<div >
							<h4><strong>Administrar Paises y Ciudades</strong></h4>
							<p>
								<input type="checkbox" name="mgsucursales"  @if( isset($urlArray['mgsucursales']) ) checked @endif >&nbsp;
								<label>Dashboard Paises y Ciudades</label>
								&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
								<input type="checkbox" name="add_sucursal-add_ciudad-edit_sucursal-edit_ciudad"  @if( isset($urlArray['add_sucursal']) ) checked @endif >&nbsp;
								<label>Agregar Ciudad</label>
								&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
								<input type="checkbox" name="delete_ciudad-delete_pais"  @if( isset($urlArray['delete_ciudad']) ) checked @endif >&nbsp;
								<label>Eliminar Ciudad</label>
							</p>
						</div>
						<hr>
						<!-- -->
						<div style="background-color: rgba(150, 150, 150, 0.1); padding: 2%;">
							<h4><strong>Administrar Puestos de Trabajo</strong></h4>
							<p>
								<input type="checkbox" name="mgpuestos"  @if( isset($urlArray['mgpuestos']) ) checked @endif >&nbsp;
								<label>Dashboard Puesto de Trabajo</label>
								&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
								<input type="checkbox" name="add_puesto"  @if( isset($urlArray['add_puesto']) ) checked @endif >&nbsp;
								<label>Agregar Puesto de Trabajo</label>
								&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
								<input type="checkbox" name="edit_puesto-update_puesto"  @if( isset($urlArray['edit_puesto']) ) checked @endif >&nbsp;
								<label>Editar Puesto de Trabajo</label>
								&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
								<input type="checkbox" name="delete_puesto"  @if( isset($urlArray['delete_puesto']) ) checked @endif >&nbsp;
								<label>Eliminar Puesto de Trabajo</label>
							</p>
						</div>
						<hr>
						<!-- -->
						<div>
							<h4><strong>Administrar TCRS</strong></h4>
							<p>
								<input type="checkbox" name="mgtcr"  @if( isset($urlArray['mgtcr']) ) checked @endif >&nbsp;
								<label>Dashboard TCR</label>
								&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
								<input type="checkbox" name="add_tcr"  @if( isset($urlArray['add_tcr']) ) checked @endif >&nbsp;
								<label>Agregar TCR</label>
								&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
								<input type="checkbox" name="edit_tcr-update_tcr"  @if( isset($urlArray['edit_tcr']) ) checked @endif >&nbsp;
								<label>Editar TCR</label>
								&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
								<input type="checkbox" name="delete_tcr"  @if( isset($urlArray['delete_tcr']) ) checked @endif >&nbsp;
								<label>Eliminar TCR</label>
							</p>
						</div>
						<hr>
						<!-- -->
						<div style="background-color: rgba(150, 150, 150, 0.1); padding: 2%;">
							<h4><strong>Administrar Vias</strong></h4>
							<p>
								<input type="checkbox" name="mgvias"  @if( isset($urlArray['mgvias']) ) checked @endif >&nbsp;
								<label>Dashboard Vias</label>
								&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
								<input type="checkbox" name="add_via"  @if( isset($urlArray['add_via']) ) checked @endif >&nbsp;
								<label>Agregar Via</label>
								&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
								<input type="checkbox" name="edit_via-update_via"  @if( isset($urlArray['edit_via']) ) checked @endif >&nbsp;
								<label>Editar Via</label>
								&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
								<input type="checkbox" name="delete_via"  @if( isset($urlArray['delete_via']) ) checked @endif >&nbsp;
								<label>Eliminar Via</label>
							</p>
						</div>
						<hr>
						<!-- -->
						<div >
							<h4><strong>Administrar Salas</strong></h4>
							<p>
								<input type="checkbox" name="mgsalas"  @if( isset($urlArray['mgsalas']) ) checked @endif >&nbsp;
								<label>Dashboard Salas</label>
								&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
								<input type="checkbox" name="add_sala"  @if( isset($urlArray['add_sala']) ) checked @endif >&nbsp;
								<label>Agregar Sala</label>
								&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
								<input type="checkbox" name="edit_sala-update_sala"  @if( isset($urlArray['edit_sala']) ) checked @endif >&nbsp;
								<label>Editar Sala</label>
								&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
								<input type="checkbox" name="delete_sala"  @if( isset($urlArray['delete_sala']) ) checked @endif >&nbsp;
								<label>Eliminar Sala</label>
							</p>
						</div>
						<hr>
						<!-- -->
						<div style="background-color: rgba(150, 150, 150, 0.1); padding: 2%;">
							<h4><strong>Administrar Personal</strong></h4>
							<p>
								<input type="checkbox" name="mgpersonal"  @if( isset($urlArray['mgpersonal']) ) checked @endif >&nbsp;
								<label>Dashboard Personal</label>
								&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
								<input type="checkbox" name="add_personal"  @if( isset($urlArray['add_personal']) ) checked @endif >&nbsp;
								<label>Agregar Personal</label>
								&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
								<input type="checkbox" name="edit_personal-update_personal"  @if( isset($urlArray['edit_personal']) ) checked @endif >&nbsp;
								<label>Editar Personal</label>
								&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
								<input type="checkbox" name="delete_personal"  @if( isset($urlArray['delete_personal']) ) checked @endif >&nbsp;
								<label>Eliminar Personal</label>
								&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
								<input type="checkbox" name="permisos_acceso-add_permisos"  @if( isset($urlArray['permisos_acceso']) ) checked @endif >&nbsp;
								<label>Permisos de acceso</label>
								&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
							</p>
						</div>
						<hr>
						<!-- -->
						<h4><strong>Administrar Clientes</strong></h4>
						<p>
							<input type="checkbox" name="mgclientes-list_countries"  @if( isset($urlArray['mgclientes']) ) checked @endif >&nbsp;
							<label>Dashboard Cliente</label>
							&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
							<input type="checkbox" name="add_cliente"  @if( isset($urlArray['add_cliente']) ) checked @endif >&nbsp;
							<label>Agregar Cliente</label>
							&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
							<input type="checkbox" name="edit_cliente-update_cliente"  @if( isset($urlArray['edit_cliente']) ) checked @endif >&nbsp;
							<label>Editar Cliente</label>
							&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
							<input type="checkbox" name="delete_cliente"  @if( isset($urlArray['delete_cliente']) ) checked @endif >&nbsp;
							<label>Eliminar Cliente</label>
							&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
						</p>
						<hr>
						<!-- -->
						<div style="background-color: rgba(150, 150, 150, 0.1); padding: 2%;">
							<h4><strong>Administrar Proyectos</h4>
							<p>
								<input type="checkbox" name="mgproyectos-show_proyecto"   @if( isset($urlArray['mgproyectos']) ) checked @endif >&nbsp;
								<label>Dashboard Proyectos</label></label>
								&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
								<input type="checkbox" name="add_proyecto"   @if( isset($urlArray['add_proyecto']) ) checked @endif >&nbsp;
								<label>Agregar Proyecto</label></label>
								&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
								<input type="checkbox" name="edit_proyecto-update_proyecto"   @if( isset($urlArray['edit_proyecto']) ) checked @endif >&nbsp;
								<label>Editar Proyecto</label>
								&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
								<input type="checkbox" name="delete_proyecto"   @if( isset($urlArray['delete_proyecto']) ) checked @endif >&nbsp;
								<label>Eliminar Proyecto</label>
								&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
							</p>
						</div>
						<hr>
						<!-- -->
						<h4><strong>Administrar Episodios</strong></h4>
						<div class="alert alert-info" role="alert">
							<i class="glyphicon glyphicon-info-sign"></i> Para que el Productor y traductor puedan modificar sus actividades se debe activar todas las opciones de este módulo.
						</div>
						<p >
							<input type="checkbox" name="mgepisodios-show_episodio"   @if( isset($urlArray['mgepisodios']) ) checked @endif >&nbsp;
							<label>Dashboard Episodios</label></label>
							&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
							<input type="checkbox" name="add_episodio"   @if( isset($urlArray['add_episodio']) ) checked @endif >&nbsp;
							<label>Agregar Episodio</label>
							&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
							<input type="checkbox" name="edit_episodio-update_episodio-update_configuracion_episodio"  @if( isset($urlArray['edit_episodio']) ) checked @endif >&nbsp;
							<label>Editar Episodio</label>
							&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
							<input type="checkbox" name="delete_episodio"  @if( isset($urlArray['delete_episodio']) ) checked @endif >&nbsp;
							<label>Eliminar Episodio</label>
							&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
							<div class="form-group">
								<input type="checkbox" name="show_fecha_entrega"   @if( isset($urlArray['show_fecha_entrega']) ) checked @endif >&nbsp;
								<label style="color: blue;">Mostrar Fecha de Entrega</label>
								&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
							</div>
						</p>
						<hr>
						<!-- -->
						<div style="background-color: rgba(150, 150, 150, 0.1); padding: 2%;">
							<h4><strong>Administrar Calificación del Material </strong></h4>
							<p >
								<input type="checkbox" name="add_calificar_material-show_calificar_material" @if( isset($urlArray['add_calificar_material']) ) checked @endif >&nbsp;
								<label>Calificar Material</label>
								&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
								<label>
									<input type="checkbox" name="edit_calificar_material-update_calificar_material-add_timecode" @if( isset($urlArray['edit_calificar_material']) ) checked @endif >&nbsp;
									Editar Calificación de Material
								</label>
								&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
							</p>
						</div>
						<hr>
						<!-- -->
						<h4><strong>Administrar Timecode </strong></h4>
						<p >
							<input type="checkbox" name="mgtimecode" @if( isset($urlArray['mgtimecode']) ) checked @endif >&nbsp;
							<label>Dashboard Timecode</label>
							&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
							<input type="checkbox" name="add_tc" @if( isset($urlArray['add_tc']) ) checked @endif >&nbsp;
							<label>Agregar Timecode</label>
							&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
							<input type="checkbox" name="edit_tc-update_tc" @if( isset($urlArray['edit_tc']) ) checked @endif >&nbsp;
							<label>Editar Timecode</label>
							&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
							<input type="checkbox" name="delete_tc" @if( isset($urlArray['delete_tc']) ) checked @endif >&nbsp;
							<label>Eliminar Timecode</label>
							&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
							<input type="checkbox" name="create_timecode_pdf" @if( isset($urlArray['create_timecode_pdf']) ) checked @endif >&nbsp;
							<label>PDF Time Code</label>
						</p>
					<hr>
					<!-- Calendario -->
					<div style="background-color: rgba(150, 150, 150, 0.1); padding: 2%;">
						<h4><strong>Productor</strong></h4>
						<p >
							<input type="checkbox" name="add_productor"  @if( isset($urlArray['mgcalendar']) ) checked @endif >&nbsp;
							<label>Lista de Episodios asignados</label>
							&nbsp; 							
						</p>
					</div>
					<hr>
					<!--  Descripción de Timecode -->
					<h4><strong>Descripción de Timecode</strong></h4>
					<p>
						<input type="checkbox" name="mgtiporeporte"  @if( isset($urlArray['mgtiporeporte']) ) checked @endif >&nbsp;
						<label>Dashboard Descripción de Timecode</label>
						&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
						<input type="checkbox" name="add_reporte"  @if( isset($urlArray['add_reporte']) ) checked @endif >&nbsp;
						<label>Agregar Descripción de Timecode</label>
						&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
						<input type="checkbox" name="edit_reporte-update_reporte"  @if( isset($urlArray['edit_reporte']) ) checked @endif >&nbsp;
						<label>Editar Descripción de Timecode</label>
						&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
						<input type="checkbox" name="delete_reporte"  @if( isset($urlArray['delete_reporte']) ) checked @endif >&nbsp;
						<label>Eliminar Descripción de Timecode</label>
						&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
					</p>
					<hr>
					<!-- Calendario -->
					<div style="background-color: rgba(150, 150, 150, 0.1); padding: 2%;">
						<h4><strong>Calendario de llamado</strong></h4>
						<p >
							<input type="checkbox" name="mgcalendar-llamados_salas-llamado_episodios-llamado_salas-llamado-credenciales_actores-delete_llamado"  @if( isset($urlArray['mgcalendar']) ) checked @endif >&nbsp;
							<label>Generar Llamados</label>
							&nbsp; 							
						</p>
					</div>
					<!-- -->
					<h4><strong>Administrar Actores</strong></h4>
					<p>
						<input type="checkbox" name="mgactores"  @if( isset($urlArray['mgactores']) ) checked @endif >&nbsp;
						<label>Dashboard Actores</label>
						&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
						<input type="checkbox" name="add_actor-delete_folio_actor"  @if( isset($urlArray['add_actor']) ) checked @endif >&nbsp;
						<label>Agregar Actor</label>
						&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
						<input type="checkbox" name="edit_actor-update_actor"  @if( isset($urlArray['edit_actor']) ) checked @endif >&nbsp;
						<label>Editar Actor</label>
						&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
						<input type="checkbox" name="delete_actor"  @if( isset($urlArray['delete_actor']) ) checked @endif >&nbsp;
						<label>Eliminar Actor</label>
						&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
						<input type="checkbox" name="list_llamado-search_llamado-credenciales_actores-edit_llamado-delete_llamado"  @if( isset($urlArray['list_llamado']) ) checked @endif >&nbsp;
							<label>Consultar llamado</label>
						&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
						<input type="checkbox" name="pdf_llamado"  @if( isset($urlArray['pdf_llamado']) ) checked @endif >&nbsp;
							<label>Generar PDF de Llamado</label>
						&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
					</p>
					<hr>
					<!-- -->
					<h4><strong>Traductor</strong></h4>
					<p>
						<input type="checkbox" name="add_traductor"  @if( isset($urlArray['mgactores']) ) checked @endif >&nbsp;
						<label>Lista de Episodios asignados</label>
						&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
					</p>
					<hr>
				</div>
			</div>		

			<!-- PAGE CONTENT ENDS -->
		</div><!-- /.col -->
	</div><!-- /.row -->
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


