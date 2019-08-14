@extends('layouts.app')

@section('guia')
	<li>
		<i class="ace-icon fa fa-warning"></i>
		<a href="{{ url('mgclientes') }}">Rechazos</a>
	</li>
@stop

@section('content')
    <div class="row">
		<div class="col-xs-12">
			<!-- PAGE CONTENT BEGINS -->
			
			<div class="row">
				<div class="col-xs-12">
					<h3 class="header smaller lighter blue">Rechazos - GPS by MG</h3>

					@if(Session::has('success'))
						<div class="alert alert-success">{{ Session::get('success') }}</div>
					@endif
					<div class="clearfix">
						<div class="pull-right tableTools-container"></div>
					</div>
					<div class="table-header">
						<a data-toggle="modal" data-target="#modal_create_rechazos" class="btn btn-success">
							Rechazo nuevo
						</a>
						<a data-toggle="modal" data-target="#modal_aadd_programa" class="btn btn-success">
							Agregar programa 
						</a>
						<div class="pull-right"><span class="glyphicon glyphicon-save-file" aria-hidden="true" title="Excel"></span> | <span class="glyphicon glyphicon-list-alt " aria-hidden="true" title="PDF" right></span> | </div>
					</div>
					<div class="col-md-3">
						<form>
							<a href="javascript:void(0)" id="buscar">Buscar</a>
							<input type="text" class="form-control" id="input-buscar" placeholder="Escribe una palabra"> 
						</form>
					</div>
					@foreach ( $rechazos as $rechazo)
						<div class="container-fluid">
							<div class="col-lg-12 col-md-12 col-xs-12">
								<div class="panel panel-primary">
									<div class="panel-heading">{{$rechazo->fecha_rechazo}} | {{$rechazo->cliente}} | {{$rechazo->titulo_programa}} | <a data-toggle="modal" data-target="#modal_update_rechazos" style="color:white">
										<span class="glyphicon glyphicon-pencil" aria-hidden="true" title="Editar"></span>
									</a> </div>
									<div class="panel-body">
										<div class="col-md-4">
												<div class="form-group">
													<strong>Fecha original del envío al cliente: </strong><br> {{$rechazo->fecha_original_envio}}
												</div>
												<div class="form-group">
													<strong>Temporada: </strong> {{$rechazo->temporada}}
												</div>
												<div class="form-group">
													<strong>Número completo del episodio: </strong><br> {{$rechazo->num_episodio}}
												</div>
												<div class="form-group">
													<strong>Idioma: </strong> {{$rechazo->idioma}}
												</div>
												<div class="form-group">
													<strong>Tipo de error: </strong> {{$rechazo->tipo_error}}
												</div>
												<div class="form-group">
													<strong>Departamento responsable: </strong><br> {{$rechazo->departamento_responsable}}
												</div>
										</div>
										<div class="col-md-4">
												<div class="form-group">
													<strong>Puesto responsable:</strong> {{$rechazo->puesto_responsable}}
												</div>
												<div class="form-group">
													<strong>Nombre del responsable: </strong><br> {{$rechazo->nombre_completo_responsable}}
												</div>
												<div class="form-group">
													<strong>Descripción del motivo del rechazo: </strong><br> {{$rechazo->descripcion_motivo_rechazo}}
												</div>
												<div class="form-group">
													<strong>Nivel de gravedad: </strong> {{$rechazo->nivel_gravedad}}
												</div>
												<div class="form-group">
													<strong>Número de rechazo: </strong> {{$rechazo->numero_rechazo}}
												</div>
												<div class="form-group">
													<strong>Coordinador: </strong> {{$rechazo->nombre_coordinador}}
												</div>
												<div class="form-group">
													<strong>Productor: </strong> {{$rechazo->nombre_productor}}
												</div>
										</div>
										<div class="col-md-4">
												<div class="form-group">
													<strong>Director: </strong> {{$rechazo->nombre_director}}
												</div>
												<div class="form-group">
													<strong>Editor: </strong> {{$rechazo->nombre_editor}}
												</div>
												<div class="form-group">
													<strong>Regrabador: </strong> {{$rechazo->nombre_regrabador}}
												</div>
												<div class="form-group">
													<strong>Observaciones: </strong> {{$rechazo->observaciones}}
												</div>
												<div class="form-group">
													<strong>Instrucciones  de acciones a tomar para prevenir futuros rechazos por la misma causa: </strong> {{$rechazo->tomar_acciones_prevencion}}
												</div>
												<div class="form-group">
													<strong>Acción tomada / comentarios del departamento responsable: </strong> {{$rechazo->acciones_tomadas}}
												</div>
										</div>
									</div>
								</div>
							</div>
						</div><br>
					@endforeach
					</div>
				</div>
			</div>		

			<!-- PAGE CONTENT ENDS -->
		</div><!-- /.col -->
	</div><!-- /.row -->
@stop

@section('modales')
<div class="col-md-12">
		<div class="modal fade" id="modal_create_rechazos" tabindex="-1" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="myModalLabel">
			<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
				<!--<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>-->
				<h4 class="modal-title" id="t_header">Rechazo</h4>
				<div id="error_update_responsables"></div>
				</div>
				<form role="form" id="form_create_rechazo">
				<div class="modal-body">
					{{ csrf_field() }}
					<div class="col-md-12">
						<div class="col-md-4">
							<div class="form-group">
								<label for="fecha_rechazo">Fecha del rechazo</label>
								<input type="text" class="form-control" name="fecha_rechazo" readonly="true" placeholder="Fecha del rechazo" required>
							</div>
							<div class="form-group">
								<label for="fecha_original_envio">Fecha original del envío del cliente</label>
								<input type="text" class="form-control" name="fecha_original_envio" readonly="true" placeholder="Fecha original del envío del cliente" required>
							</div>
							<div class="form-group">
								<label for="cliente">Cliente</label>
								<select class="form-control selectpicker"  id="cliente" name="cliente" data-style="btn-primary" data-show-subtext="true" data-live-search="true" title="Seleccionar...">
									@if(count($clientes) > 0)
										@foreach($clientes as $cliente)
											<option value="{{ $cliente->id }} "> {{ $cliente->razon_social }}  </option>
										@endforeach
									@endif
								</select>
							</div>
							<div class="form-group">
								<label for="titulo_programa">Título de programa</label>
								<select class="form-control selectpicker"  id="titulo_programa" name="titulo_programa" data-style="btn-primary" data-show-subtext="true" data-live-search="true" title="Seleccionar..."></select>
							</div>
							<div class="form-group">
								<label for="id_episodio_temporada">Temporada</label>
								<select class="form-control selectpicker"  id="id_episodio_temporada" name="id_episodio_temporada" data-style="btn-primary" data-show-subtext="true" data-live-search="true" title="Seleccionar..."></select>
							</div>
							<div class="form-group">
								<label for="id_numero_episodio">Número completo de episodio</label>
								<select class="form-control selectpicker"  id="id_numero_episodio" name="id_numero_episodio" data-style="btn-primary" data-show-subtext="true" data-live-search="true" title="Seleccionar..."></select>
							</div>
							<div class="form-group">
								<label for="idioma">Idioma(LAS/BPO)</label>
								<select class="form-control selectpicker" name="idioma" data-style="btn-primary" data-show-subtext="true" data-live-search="true" title="Seleccionar...">
									@if(count($idiomas) > 0)
										@foreach($idiomas as $idioma)
											<option value="{{ $idioma }} "> {{ $idioma }}  </option>
										@endforeach
									@endif
								</select>
							</div>
							<div class="form-group">
								<label for="id_tipo_error">Tipo de error</label>
								<select class="form-control selectpicker" name="id_tipo_error" data-style="btn-primary" data-show-subtext="true" data-live-search="true" title="Seleccionar...">
									@if(count($tipoErrores) > 0)
										@foreach($tipoErrores as $tipoError)
											<option value="{{ $tipoError->id }} "> {{ $tipoError->nombre }}  </option>
										@endforeach
									@endif
								</select>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label for="id_departamento_responsable">Departmento responsable</label>
								<select class="form-control selectpicker" name="id_departamento_responsable" data-style="btn-primary" data-show-subtext="true" data-live-search="true" title="Seleccionar...">
									@if(count($deptoResponsable) > 0)
										@foreach($deptoResponsable as $depto)
											<option value="{{ $depto->id }} "> {{ $depto->nombre }}  </option>
										@endforeach
									@endif
								</select>
							</div>
							<div class="form-group">
								<label for="id_puesto_responsable">Puesto responsable</label>
								<select class="form-control selectpicker" name="id_puesto_responsable" data-style="btn-primary" data-show-subtext="true" data-live-search="true" title="Seleccionar...">
									@if(count($puestoResponsable) > 0)
										@foreach($puestoResponsable as $puesto)
											<option value="{{ $puesto->id }} "> {{ $puesto->job }}  </option>
										@endforeach
									@endif
								</select>
							</div>
							<div class="form-group">
								<label for="nombre_completo_responsable">Nombre del responsable</label>
								<input type="text" class="form-control" name="nombre_completo_responsable" placeholder="Nombre del departamento responsable" required>
							</div>
							<div class="form-group">
								<label for="nombre_completo">Descripción del motivo de rechazo</label>
								<textarea class="form-control" name="descripcion_motivo_rechazo" required></textarea>
							</div>
							<div class="form-group">
								<label for="nivel_gravedad">Nivel de gravedad</label>
								<select class="form-control selectpicker" name="nivel_gravedad" data-style="btn-primary" data-show-subtext="true" data-live-search="true" title="Seleccionar...">
									@if(count($nivelGravedad) > 0)
										@foreach($nivelGravedad as $nivel)
											<option value="{{ $nivel }} "> {{ $nivel }}  </option>
										@endforeach
									@endif
								</select>
							</div>
							<div class="form-group">
								<label for="numero_rechazo">Número de rechazo</label>
								<select class="form-control selectpicker" name="numero_rechazo" data-style="btn-primary" data-show-subtext="true" data-live-search="true" title="Seleccionar...">
									@if(count($numeroRechazo) > 0)
										@foreach($numeroRechazo as $rechazo)
											<option value="{{ $rechazo }} "> {{ $rechazo }}  </option>
										@endforeach
									@endif
								</select>	
							</div>
							<div class="form-group">
								<label for="id_coordinador">Coordinador</label>
								<select class="form-control selectpicker"  id="id_coordinador" name="id_coordinador" data-style="btn-primary" data-show-subtext="true" data-live-search="true" title="Seleccionar...">
									@if(count($coordinadores) > 0)
										@foreach($coordinadores as $coordinador)
											<option value="{{ $coordinador->id }} "> {{ $coordinador->name }} {{ $coordinador->ap_paterno }} {{ $coordinador->ap_materno }}  </option>
										@endforeach
									@endif
								</select>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label for="id_productor">Productor</label>
								<select class="form-control selectpicker"  id="id_productor" name="id_productor" data-style="btn-primary" data-show-subtext="true" data-live-search="true" title="Seleccionar...">
									@if(count($productores) > 0)
										@foreach($productores as $productor)
											<option value="{{ $productor->id }} "> {{ $productor->name }} {{ $productor->ap_paterno }} {{ $productor->ap_materno }}  </option>
										@endforeach
									@endif
								</select>	
							</div>
							<div class="form-group">
								<label for="id_director">Director</label>
								<select class="form-control selectpicker"  id="id_director" name="id_director" data-style="btn-primary" data-show-subtext="true" data-live-search="true" title="Seleccionar...">
									@if(count($directores) > 0)
										@foreach($directores as $director)
											<option value="{{ $director->id }} "> {{ $director->name }} {{ $director->ap_paterno }} {{ $director->ap_materno }}  </option>
										@endforeach
									@endif
								</select>	
							</div>
							<div class="form-group">
								<label for="id_editor">Editor</label>
								<select class="form-control selectpicker"  id="id_editor" name="id_editor" data-style="btn-primary" data-show-subtext="true" data-live-search="true" title="Seleccionar...">
									@if(count($editores) > 0)
										@foreach($editores as $editor)
											<option value="{{ $editor->id }} "> {{ $editor->name }} {{ $editor->ap_paterno }} {{ $editor->ap_materno }}  </option>
										@endforeach
									@endif
								</select>		
							</div>
							<div class="form-group">
								<label for="id_regrabador">Regrabador</label>
								<select class="form-control selectpicker"  id="id_regrabador" name="id_regrabador" data-style="btn-primary" data-show-subtext="true" data-live-search="true" title="Seleccionar...">
									@if(count($regrabadores) > 0)
										@foreach($regrabadores as $regrabador)
											<option value="{{ $regrabador->id }} "> {{ $regrabador->name }} {{ $regrabador->ap_paterno }} {{ $regrabador->ap_materno }}  </option>
										@endforeach
									@endif
								</select>		
							</div>
							<div class="form-group">
								<label for="observaciones">Observaciones</label>
								<textarea class="form-control" name="observaciones" required></textarea>
							</div>
							<div class="form-group">
								<label for="tomar_acciones_prevencion">Tomar acciones de prevención</label>
								<textarea class="form-control" name="tomar_acciones_prevencion" required></textarea>
							</div>
							<div class="form-group">
								<label for="acciones_tomadas">Acciones tomadas</label>
								<textarea class="form-control" name="acciones_tomadas" required></textarea>
							</div>
					</div>
				</div>
				<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal" >Cerrar</button>
				<button type="submit"  class="btn btn-primary btn-enviar">Guardar</button>
				</div>
				</form>
			</div>
			</div>
		</div>
	</div>

	<div class="col-md-12">
		<div class="modal fade" id="modal_update_rechazos" tabindex="-1" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="myModalLabel">
			<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
				<!--<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>-->
				<h4 class="modal-title" id="t_header">Rechazo</h4>
				<div id="error_update_responsables"></div>
				</div>
				<form role="form" id="form_create_rechazo">
				<div class="modal-body">
					{{ csrf_field() }}
					<div class="col-md-12">
						<div class="col-md-4">
							<div class="form-group">
								<label for="fecha_rechazo">Fecha del rechazo</label>
								<input type="text" class="form-control" name="fecha_rechazo" readonly="true" placeholder="Fecha del rechazo" required>
							</div>
							<div class="form-group">
								<label for="fecha_original_envio">Fecha original del envío del cliente</label>
								<input type="text" class="form-control" name="fecha_original_envio" readonly="true" placeholder="Fecha original del envío del cliente" required>
							</div>
							<div class="form-group">
								<label for="cliente">Cliente</label>
								<select class="form-control selectpicker"  id="cliente" name="cliente" data-style="btn-primary" data-show-subtext="true" data-live-search="true" title="Seleccionar...">
									@if(count($clientes) > 0)
										@foreach($clientes as $cliente)
											<option value="{{ $cliente->id }} "> {{ $cliente->razon_social }}  </option>
										@endforeach
									@endif
								</select>
							</div>
							<div class="form-group">
								<label for="titulo_programa">Título de programa</label>
								<select class="form-control selectpicker"  id="titulo_programa" name="titulo_programa" data-style="btn-primary" data-show-subtext="true" data-live-search="true" title="Seleccionar..."></select>
							</div>
							<div class="form-group">
								<label for="id_episodio_temporada">Temporada</label>
								<select class="form-control selectpicker"  id="id_episodio_temporada" name="id_episodio_temporada" data-style="btn-primary" data-show-subtext="true" data-live-search="true" title="Seleccionar..."></select>
							</div>
							<div class="form-group">
								<label for="id_numero_episodio">Número completo de episodio</label>
								<select class="form-control selectpicker"  id="id_numero_episodio" name="id_numero_episodio" data-style="btn-primary" data-show-subtext="true" data-live-search="true" title="Seleccionar..."></select>
							</div>
							<div class="form-group">
								<label for="idioma">Idioma(LAS/BPO)</label>
								<select class="form-control selectpicker" name="idioma" data-style="btn-primary" data-show-subtext="true" data-live-search="true" title="Seleccionar...">
									@if(count($idiomas) > 0)
										@foreach($idiomas as $idioma)
											<option value="{{ $idioma }} "> {{ $idioma }}  </option>
										@endforeach
									@endif
								</select>
							</div>
							<div class="form-group">
								<label for="id_tipo_error">Tipo de error</label>
								<select class="form-control selectpicker" name="id_tipo_error" data-style="btn-primary" data-show-subtext="true" data-live-search="true" title="Seleccionar...">
									@if(count($tipoErrores) > 0)
										@foreach($tipoErrores as $tipoError)
											<option value="{{ $tipoError->id }} "> {{ $tipoError->nombre }}  </option>
										@endforeach
									@endif
								</select>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label for="id_departamento_responsable">Departmento responsable</label>
								<select class="form-control selectpicker" name="id_departamento_responsable" data-style="btn-primary" data-show-subtext="true" data-live-search="true" title="Seleccionar...">
									@if(count($deptoResponsable) > 0)
										@foreach($deptoResponsable as $depto)
											<option value="{{ $depto->id }} "> {{ $depto->nombre }}  </option>
										@endforeach
									@endif
								</select>
							</div>
							<div class="form-group">
								<label for="id_puesto_responsable">Puesto responsable</label>
								<select class="form-control selectpicker" name="id_puesto_responsable" data-style="btn-primary" data-show-subtext="true" data-live-search="true" title="Seleccionar...">
									@if(count($puestoResponsable) > 0)
										@foreach($puestoResponsable as $puesto)
											<option value="{{ $puesto->id }} "> {{ $puesto->job }}  </option>
										@endforeach
									@endif
								</select>
							</div>
							<div class="form-group">
								<label for="nombre_completo_responsable">Nombre del responsable</label>
								<input type="text" class="form-control" name="nombre_completo_responsable" placeholder="Nombre del departamento responsable" required>
							</div>
							<div class="form-group">
								<label for="nombre_completo">Descripción del motivo de rechazo</label>
								<textarea class="form-control" name="descripcion_motivo_rechazo" required></textarea>
							</div>
							<div class="form-group">
								<label for="nivel_gravedad">Nivel de gravedad</label>
								<select class="form-control selectpicker" name="nivel_gravedad" data-style="btn-primary" data-show-subtext="true" data-live-search="true" title="Seleccionar...">
									@if(count($nivelGravedad) > 0)
										@foreach($nivelGravedad as $nivel)
											<option value="{{ $nivel }} "> {{ $nivel }}  </option>
										@endforeach
									@endif
								</select>
							</div>
							<div class="form-group">
								<label for="numero_rechazo">Número de rechazo</label>
								<select class="form-control selectpicker" name="numero_rechazo" data-style="btn-primary" data-show-subtext="true" data-live-search="true" title="Seleccionar...">
									@if(count($numeroRechazo) > 0)
										@foreach($numeroRechazo as $rechazo)
											<option value="{{ $rechazo }} "> {{ $rechazo }}  </option>
										@endforeach
									@endif
								</select>	
							</div>
							<div class="form-group">
								<label for="id_coordinador">Coordinador</label>
								<select class="form-control selectpicker"  id="id_coordinador" name="id_coordinador" data-style="btn-primary" data-show-subtext="true" data-live-search="true" title="Seleccionar...">
									@if(count($coordinadores) > 0)
										@foreach($coordinadores as $coordinador)
											<option value="{{ $coordinador->id }} "> {{ $coordinador->name }} {{ $coordinador->ap_paterno }} {{ $coordinador->ap_materno }}  </option>
										@endforeach
									@endif
								</select>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label for="id_productor">Productor</label>
								<select class="form-control selectpicker"  id="id_productor" name="id_productor" data-style="btn-primary" data-show-subtext="true" data-live-search="true" title="Seleccionar...">
									@if(count($productores) > 0)
										@foreach($productores as $productor)
											<option value="{{ $productor->id }} "> {{ $productor->name }} {{ $productor->ap_paterno }} {{ $productor->ap_materno }}  </option>
										@endforeach
									@endif
								</select>	
							</div>
							<div class="form-group">
								<label for="id_director">Director</label>
								<select class="form-control selectpicker"  id="id_director" name="id_director" data-style="btn-primary" data-show-subtext="true" data-live-search="true" title="Seleccionar...">
									@if(count($directores) > 0)
										@foreach($directores as $director)
											<option value="{{ $director->id }} "> {{ $director->name }} {{ $director->ap_paterno }} {{ $director->ap_materno }}  </option>
										@endforeach
									@endif
								</select>	
							</div>
							<div class="form-group">
								<label for="id_editor">Editor</label>
								<select class="form-control selectpicker"  id="id_editor" name="id_editor" data-style="btn-primary" data-show-subtext="true" data-live-search="true" title="Seleccionar...">
									@if(count($editores) > 0)
										@foreach($editores as $editor)
											<option value="{{ $editor->id }} "> {{ $editor->name }} {{ $editor->ap_paterno }} {{ $editor->ap_materno }}  </option>
										@endforeach
									@endif
								</select>		
							</div>
							<div class="form-group">
								<label for="id_regrabador">Regrabador</label>
								<select class="form-control selectpicker"  id="id_regrabador" name="id_regrabador" data-style="btn-primary" data-show-subtext="true" data-live-search="true" title="Seleccionar...">
									@if(count($regrabadores) > 0)
										@foreach($regrabadores as $regrabador)
											<option value="{{ $regrabador->id }} "> {{ $regrabador->name }} {{ $regrabador->ap_paterno }} {{ $regrabador->ap_materno }}  </option>
										@endforeach
									@endif
								</select>		
							</div>
							<div class="form-group">
								<label for="observaciones">Observaciones</label>
								<textarea class="form-control" name="observaciones" required></textarea>
							</div>
							<div class="form-group">
								<label for="tomar_acciones_prevencion">Tomar acciones de prevención</label>
								<textarea class="form-control" name="tomar_acciones_prevencion" required></textarea>
							</div>
							<div class="form-group">
								<label for="acciones_tomadas">Acciones tomadas</label>
								<textarea class="form-control" name="acciones_tomadas" required></textarea>
							</div>
					</div>
				</div>
				<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal" >Cerrar</button>
				<button type="submit"  class="btn btn-primary btn-enviar">Guardar</button>
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
			//Limpiar campos
			$('input[name=fecha_rechazo]').val('');
			$('input[name=fecha_original_envio]').val('');
			$('input[name=id_numero_episodio]').val('');
			$('input[name=nombre_completo_responsable]').val('');

			$('textarea[name=descripcion_motivo_rechazo]').val('');
			$('textarea[name=observaciones]').val('');
			$('textarea[name=tomar_acciones_prevencion]').val('');
			$('textarea[name=acciones_tomadas]').val('');
			
			//
            $('#table_rechazos').DataTable({
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

			$('#modal_create_rechazos').on('shown.bs.modal', function (e) {
				$('input[name=nombre]').focus();
			})
			
			//Calendarios
			$('input[name=fecha_rechazo], input[name=fecha_original_envio]').datepicker({
				dateFormat: "yy-mm-dd",
				closeText: 'Cerrar',
				prevText: '<Ant',
				nextText: 'Sig>',
				currentText: 'Hoy',
				monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
				monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
				dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
				dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
				dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
			});

			$('#cliente').on('changed.bs.select', function(e, clickedIndex, isSelected, previousValue){
				if(isSelected){
					$.ajax({
						url: "{{ route('rechazos-select-proyectos') }}",
						type: "POST",
						data: {id:this.value, _token: "{{ csrf_token() }}"},
						success: function(e){
							var valueTituloPrograma = '';
							$('#titulo_programa').html("").selectpicker('refresh');
							for(var i=0; i<e.length; i++){
								valueTituloPrograma += '<option value="' + e[i].id + '"> ' + e[i].titulo_original +'</option> ';
							 }
							//valueTituloPrograma += '<option value="otro">Otro</option>';
							$('select[name=titulo_programa]').append(valueTituloPrograma).selectpicker('refresh');
						},
						error :function(e){
							console.log(e)
							if(e.status == 404){
								alert("Verificar ruta");
							}
						}
					})
				}	
			});
			$('#titulo_programa').on('changed.bs.select', function(e, clickedIndex, isSelected, previousValue){
				console.log(this.value)
				if(isSelected){
					$.ajax({
						url: "{{ route('rechazos-select-proyectos-id') }}",
						type: "POST",
						data: {id:this.value, _token: "{{ csrf_token() }}"},
						success: function(e){
							console.log(e);
							var valueTemporada = '';
							$('#id_episodio_temporada').html("").selectpicker('refresh');
							for(var i=0; i<e.length; i++){
								console.log("temporada:", e)
								valueTemporada += '<option value="' + e[i].id + '"> '+ e[i].temporada +'</option> ';
							 }
							 $('select[name=id_episodio_temporada]').append(valueTemporada).selectpicker('refresh');
						},
						error :function(e){
							console.log(e)
							if(e.status == 404){
								alert("Verificar ruta");
							}
						}
					})
				}	
			});
			$('#id_episodio_temporada').on('change.bs.select', function(e, clickedIndex, isSelected, previousValue){
				//$('#numero_completo_temporada').val(this.value);
				console.log(this.value);
				console.log("ness");
					$.ajax({
						url: "{{ route('rechazos-select-temporada') }}",
						type: "POST",
						data: {id:this.value, _token: "{{ csrf_token() }}"},
						success: function(e){
							console.log("select", e);
							var valueTemporada = '';
							$('#id_numero_episodio').html("").selectpicker('refresh');
							for(var i=0; i<e.length; i++){
								console.log("temporada:", e)
								valueTemporada += '<option value="' + e[i].id + '"> '+ e[i].num_episodio +'</option> ';
							 }
							 $('select[name=id_numero_episodio]').append(valueTemporada).selectpicker('refresh');
						},
						error :function(e){
							console.log(e)
							if(e.status == 404){
								alert("Verificar ruta");
							}
						}
					})
			
			})

			$('#form_create_rechazo').on('submit', function(event){
				event.preventDefault();
				$.ajax({
					url: "{{ route('create-rechazos') }}",
					type: "POST",
					data: $( this ).serialize(),
					success: function( data ){
						console.log(data);
						if(data.status == 'success'){
							window.location.reload(true);
						}
					},
					error: function(error){
						console.log(error)
						//alert(error['message']);
					}
				});
			});

			$('#buscar').on('click', function(){
				var buscar = $('#input-buscar').val();
				if(buscar == '') { 
					alert('Favor de ingresar un valor') 
				} else {
					$.ajax({
						url: "{{ route('lista-rechazos') }}",
						type: "POST",
						data: {buscar: buscar,  _token: "{{ csrf_token() }}"},
						success: function( data ){
							console.log(data);
							if(data.status == 'success'){
								window.location.reload(true);
							}
						},
						error: function(error){
							console.log(error)
							//alert(error['message']);
						}
					});
				}
			})

		});
		
	</script>
@stop