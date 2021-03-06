@extends('layouts.app')

@section('guia')
	<li>
		<i class="ace-icon fa fa-users"></i>
		<a href="{{ url('mgproyectos') }}">Proyectos</a>
	</li>
	<li>
		<i class="ace-icon fa fa-film"></i>
		<a href="{{ url('mgepisodios'.'/'. $proyecto_id) }}">Episodios</a>
	</li>
@stop

@section('content')
    <div class="row">
		<div class="col-xs-12">
			<!-- PAGE CONTENT BEGINS -->

			<div class="row">
				<div class="col-xs-12">
					<h3 class="header smaller lighter blue center">Episodios de Macias Group</h3>
					<h3 class="header smaller lighter blue"><b>{{trans('mgproyectos::ui.attribute.titulo_serie')}}: </b>{{ $proyecto->titulo_original }} </h3>

					<div class="clearfix">
						<div class="pull-right tableTools-container"></div>
					</div>
					<div class="table-header">
						@if(\Request::session()->has('add_episodio'))
							<!--Results for "Latest Registered Domains"-->
							<a data-toggle="modal" data-target="#modal_save_episodio" class="btn btn-success">
								Episodio Nuevo
							</a>
						@endif
					</div>

					<!-- div.table-responsive -->

					<!-- div.dataTables_borderWrap -->
					<div> <br><br>
						<table id="table_episodios" class="stripe row-border">
							<thead>
								<tr>
									<th>ID</th>
									<th>Título Original Episodio</th>
									<th>Número de episodio</th>
									@if(\Request::session()->has('show_fecha_entrega'))
										<th>Fecha de entrega episodio</th>
									@endif
									@if(\Request::session()->has('add_calificar_material'))
										<th>Calificar Episodio</th>
									@endif
									<th></th>
								</tr>
							</thead>

							<tbody>

								@foreach($episodios as $episodio)
									<tr>
										<td>
											{{ $episodio->id }}
										</td>
										<td>
											{{ $episodio->titulo_original }}
										</td>
										<td> {{ $episodio->num_episodio }} </td>
										@if(\Request::session()->has('show_fecha_entrega'))
											<td>
												@php
													 $hoy = \Carbon\carbon::today('America/Mexico_City');
													 $fechaentrega = \Carbon\carbon::parse($episodio->date_entrega, 'America/Mexico_City');
													 $diferencia_dias = $fechaentrega->diffInDays($hoy, false);
													 $status_entrega = '';
										        @endphp

										        @if($diferencia_dias < -2)
											        @php
											        	$status_entrega = "success";
											        @endphp
												@endif
											    @if($diferencia_dias >= -2 && $diferencia_dias <= -1)
											    	@php
											        	$status_entrega = "warning";
											        @endphp
											    @endif
											    @if($diferencia_dias >= 0)
											        @php
											        	$status_entrega = "danger";
											        @endphp
											    @endif

												<span class="label label-{{$status_entrega}}">{{ \Carbon\carbon::parse($episodio->date_entrega)->toFormattedDateString() }}</span>
											</td>
										@endif
										@if(\Request::session()->has('add_calificar_material'))
											<td>
												@if( $episodio->material_calificado != true )
													<a href="#" title="Calificar Episodio" data-toggle="modal" data-target="#modal_calificar_material" data-id="{{ $episodio->id }}">
														<span class="label label-danger arrowed-in arrowed-in-right"> Sin Calificar </span>
													</a>
												@else
													<a href=" {{ url('mgepisodios/material-calificado/') . '/'. $episodio->id .'/'. $proyecto->id}} " title="Calificar Episodio">
													<span class="label label-success arrowed-in arrowed-in-right"> Calificado </span>
													</a>
												@endif

											</td>
										@endif
										<td>
											@if(\Request::session()->has('add_productor'))
												@if(is_null($episodio->quien_modifico_productor))
													<a data-toggle="modal" data-target="#modal_create_productor" data-id="{{ $episodio->id }}" class="btn btn-xs btn-primary" title="Agregar Productor">
															<i class="glyphicon glyphicon-film "></i>
													</a>
												@else
													<a data-toggle="modal" data-target="#modal_update_productor" data-id="{{ $episodio->id }}" class="btn btn-xs btn-success" title="Modificar Productor">
															<i class="glyphicon glyphicon-film "></i>
													</a>
												@endif
											@endif

											@if(\Request::session()->has('add_traductor'))
												@if(is_null($episodio->quien_modifico_traductor))
													<a data-toggle="modal" data-target="#modal_create_traductor" data-id="{{ $episodio->id }}" class="btn btn-xs btn-primary" title="Agregar Traductor">
															<i class="glyphicon glyphicon-indent-right"></i>
													</a>
												@else
													<a data-toggle="modal" data-target="#modal_update_traductor" data-id="{{ $episodio->id }}" class="btn btn-xs btn-success" title="Modificar Traductor">
															<i class="glyphicon glyphicon-indent-right"></i>
													</a>
												@endif
											@endif

											@if(\Request::session()->has('edit_episodio'))
												<a data-toggle="modal" data-target="#modal_update_configuracion" data-id="{{ $episodio->id }}" class="btn btn-xs btn-warning " title="Configuracion">
															<i class="ace-icon fa fa-tv bigger-120"></i>
												</a>
											@endif
											@if(\Request::session()->has('show_episodio'))
												<a data-id="{{ $episodio->id }}" data-toggle="modal" data-target="#modal_ver_episodio" class="btn btn-xs btn-warning show_id" title="Consultar">
													<i class="ace-icon fa fa-book bigger-120"></i>
												</a>
											@endif
											@if(\Request::session()->has('edit_episodio') || \Request::session()->has('update_episodio'))
												<a data-id="{{ $episodio->id }}" data-toggle="modal" data-target="#modal_update_episodio" class="btn btn-xs btn-info update_id" title="Editar">
													<i class="ace-icon fa fa-pencil bigger-120"></i>
												</a>
											@endif
											@if(\Request::session()->has('delete_episodio'))
												<a data-toggle="modal" data-target="#modal_delete_episodio" data-id="{{ $episodio->id }}" class="btn btn-xs btn-danger delete_id" title="Eliminar">
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
		<div class="modal fade" id="modal_save_episodio" data-name="modal" tabindex="-1" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="myModalLabel">
		  <div class="modal-dialog" role="document">
			<div class="modal-content">
			  <div class="modal-header">
				<!--<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>-->
				<h4 class="modal-title" id="t_header">Episodio Nuevo</h4>
				<div id="error_create_episodio"></div>
			  </div>
			  <form role="form" id="form_create_episodio">
			  <div class="modal-body">
					{{ csrf_field() }}
				<input type="hidden" name="proyectoId" value="{{ $proyecto_id }}">
				<div class="form-group">
					<label>Seleccionar Productor</label>
					<select class="form-control selectpicker" id="productor" name="productor" data-style="btn-primary" data-show-subtext="true" data-live-search="true" title="Seleccionar...">
						@if(count($productores) > 0)
							@foreach($productores as $productor)
								<option value="{{ $productor->id }} "> {{ $productor->name }} {{ $productor->ap_paterno }} {{ ($productor->ap_materno )}} </option>
							@endforeach
						@endif
					</select>
				</div>
				<div class="form-group">
					<label>Seleccionar Responsable</label>
					<select class="form-control selectpicker" id="responsable" name="responsable" data-style="btn-primary" data-show-subtext="true" data-live-search="true" title="Seleccionar...">
						@if(count($responsables) > 0)
							@foreach($responsables as $responsable)
								<option value="{{ $responsable->id }}"> {{ $responsable->name }} {{ $responsable->ap_paterno }} {{ ($responsable->ap_materno )}} </option>
							@endforeach
						@endif
					</select>
				</div>
				<div class="form-group">
					<label for="titulo_original_episodio">Título Original del episodio</label>
					<input type="text" class="form-control" id="titulo_original_episodio" name="titulo_original_episodio" placeholder="Título Original del episodio">
				</div>
				<div class="form-group">
					<label for="configuracion">Configuración</label>
					<textarea id="configuracion" name="configuracion" class="form-control"></textarea>
				</div> 
				
				<div class="form-group">
					<label for="num_episodio">Número de Episodio</label>
					<input type="text" class="form-control" id="num_episodio" name="num_episodio" placeholder="Número de episodio">
				</div>
				<div>
				   <div class=" col-md-6 form-group">
						<label for="fecha_descarga_create">Fecha de descarga</label>
						<input type="text" class="form-control" id="fecha_descarga_create" name="fecha_descarga_create" readonly="true" placeholder="Fecha de descarga">
					</div>
					<div class=" col-md-6 form-group">
						<label for="referencia">Referencia</label>
						<input type="text" class="form-control" id="referencia" name="referencia"  placeholder="Referencia">
					</div>
				</div>
				<div>
				   <div class=" col-md-6 form-group">
						<label for="envio_mp4_create">Fecha de envío de MP4 a traductor</label>
						<input type="text" class="form-control" id="envio_mp4_create" name="envio_mp4_create" readonly="true" placeholder="Fecha de envío de MP4 a traductor">
					</div>
				</div>
				<div>
					<h2>Configuraciones</h2>
					{{-- <table class="table">
				  		<tr>
				  			<td><input type="checkbox" name="bw"><label> &nbsp; BW</label></td>
				  			<td><input type="checkbox" name="netcut"><label> &nbsp; NetCut</label></td>
				  			<td><input type="checkbox" name="lockcut"><label> &nbsp; LockCut</label></td>
				  			<td><input type="checkbox" name="final"><label> &nbsp; Final</label></td>
				  		</tr>
					  </table> --}}
				
				<table class="table">
					<tr>
						@foreach($catalogos as $c)
							<td>
								<input type="checkbox" name="{{$c->id}}" >
								<label> &nbsp; {{strtoupper($c->nombre)}} </label>
							</td>
						@endforeach
					</tr>
				</table>
				
				</div>
				<div class="form-group">
					<label for="entrega_episodio">Título LAS</label>
					<input type="text" class="form-control" id="las_or_lm_create" name="las_or_lm_create" placeholder="Título LAS">
				</div>
				<div class="form-group">
					<label for="entrega_episodio">Título BPO</label>
					<input type="text" class="form-control" id="bpo_or_lm_create" name="bpo_or_lm_create" placeholder="Título BPO">
				</div>
				<div class="form-group">
					<label>Seleccionar Tipos de trabajos</label>
					<select class="form-control selectpicker" id="tipo_trabajo_create" name="tipo_trabajo_create" data-style="btn-primary" data-show-subtext="true" data-live-search="true" title="Seleccionar...">
						@if(count($tiposTrabajo) > 0)
							@foreach($tiposTrabajo as $trabajo)
								<option value="{{ $trabajo->id }}"> {{ $trabajo->nombre }} </option>
							@endforeach
						@endif
					</select>
				</div>
				<div>
					<table class="table">
				  		<tr>
				  			<td><input type="checkbox" name="notificacion_pistas"><label> &nbsp; Notificación a producción y pistas</label></td>
				  			<td><input type="checkbox" name="envio_sebastians"><label> &nbsp; Envío Sebastians</label></td>
				  			<td><input type="checkbox" name="ot"><label> &nbsp; OT</label></td>
				  		</tr>
				  	</table>
				</div>
					@if( $proyecto->m_and_e == true )
					<div class="form-group">
						<label for="entrega_me">Fecha de entrega M&E</label>
						<input type="text" class="form-control" id="entrega_me" name="entrega_me" readonly="true" placeholder="Fecha de entrega M&E">
					</div>
					@endif
					<div class="form-group">
						<label for="entrega_episodio">Fecha de entrega del Episodio</label>
						<input type="text" class="form-control" id="entrega_episodio" name="entrega_episodio" readonly="true" placeholder="Fecha de entrega del Episodio">
					</div>
				<div class=" modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal" >Cerrar</button>
					<button type="submit" class="btn btn-primary" id="btn_crear_episodio">Guardar</button>
				</div>
				<div id="info_episodio" ></div>
			  </form>
			</div>
		  </div>
		</div>
	</div>

	<!-- Agregar Productor -->
		<div class="modal fade" id="modal_create_productor" tabindex="-1" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="myModalLabel">
		  <div class="modal-dialog" role="document">
			<div class="modal-content">
			  <div class="modal-header">
				<!--<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>-->
				<h4 class="modal-title" id="t_header">Asignar Productor</h4>
				<div id="error_agregar_productor"></div>
			  </div>
			  <form role="form" id="form_agregar_productor">
			  <div class="modal-body">
					{{ csrf_field() }}
				<br>
				<input type="hidden" name="id" id="id">
				<label>Sala</label>
				<select name="sala" class="form-control selectpicker" data-style="btn-primary" data-show-subtext="true" data-live-search="true" title="Seleccionar..." required>
					@foreach($salas as $sala)
						<option value="{{ $sala->id }}">{{ $sala->sala }}</option>
					@endforeach
				</select>
				<label>Director</label>
				<select name="director" class="form-control selectpicker" data-style="btn-primary" data-show-subtext="true" data-live-search="true" title="Seleccionar..." required>
					@foreach($directores as $director)
						<option value="{{ $director->id }}">{{ $director->name }} {{ $director->ap_paterno }} {{ $director->ap_materno }}</option>
					@endforeach
				</select>
				<div class="add_date_script"></div>
				<label> Ingeniero de audio </label>
				<select name="ingeniero_audio_id" class="form-control selectpicker" data-style="btn-primary" data-show-subtext="true" data-live-search="true" title="Seleccionar..." required>
					@foreach($tecnicos as $tecnico)
						<option value="{{ $tecnico->id }}">{{ $tecnico->name }} {{ $tecnico->ap_paterno }} {{ $tecnico->ap_materno }}</option>
					@endforeach
				</select>
				<br>
				<div class="alert alert-primary date-type-rayado"></div>

				<label>
				<input type="checkbox" name="chk_edicion" id="chk_edicion" > Edición
				</label>
				<div class="dateEdicion"></div>
				<label>
				<input type="checkbox" name="chk_reprobacion" id="chk_reprobacion" > Regrabador
				</label><br>
				<div class="dateRegrabacion"></div>
				<label>
				<input type="checkbox" name="chk_qc" id="chk_qc" > Control de calidad (QC)
				</label>
				<div class="dateQC"></div>
			  </div>
			  <div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal" >Cerrar</button>
				<button type="submit" class="btn btn-primary">Guardar</button>
			  </div>
			  </form>
			</div>
		  </div>
		</div>

		<!-- Modificar Productor -->
		<div class="modal fade" id="modal_update_productor" tabindex="-1" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="myModalLabel">
		  <div class="modal-dialog" role="document">
			<div class="modal-content">
			  <div class="modal-header">
				<!--<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>-->
				<h4 class="modal-title" id="t_header">Modificar Productor</h4>
				<div id="error_agregar_productor"></div>
			  </div>
			  <form role="form" id="form_update_productor">
			  <div class="modal-body">
					{{ csrf_field() }}
				<input type="hidden" name="id" id="id">
				<label>Sala</label>
				<select name="sala" class="form-control selectpicker" data-style="btn-primary" data-show-subtext="true" data-live-search="true" title="Seleccionar..." required>
					@foreach($salas as $sala)
						<option value="{{ $sala->id }}">{{ $sala->sala }}</option>
					@endforeach
				</select>
				<label>Director</label>
				<select name="director" class="form-control selectpicker" data-style="btn-primary" data-show-subtext="true" data-live-search="true" title="Seleccionar..." required>
					@foreach($directores as $director)
						<option value="{{ $director->id }}">{{ $director->name }} {{ $director->ap_paterno }} {{ $director->ap_materno }}</option>
					@endforeach
				</select>
				<div id="add_date_script"></div>
				<label> Ingeniero de audio </label>
				<select name="ingeniero_audio_id" class="form-control selectpicker"  data-style="btn-primary" data-show-subtext="true" data-live-search="true" title="Seleccionar...">
					@foreach($tecnicos as $tecnico)
						<option value="{{ $tecnico->id }}">{{ $tecnico->name }} {{ $tecnico->ap_paterno }} {{ $tecnico->ap_materno }}</option>
					@endforeach
				</select>

				<div class="alert alert-primary date-type-rayado"></div>
				<input type="checkbox" name="chk_edicion" id="chk_edicion" > Edición
				</label><br>
				<div class="dateEdicion"></div>
				<label>
				<input type="checkbox" name="chk_reprobacion" id="chk_reprobacion" > Regrabador
				</label>
				<div class="dateRegrabacion"></div>
				<label>
				<input type="checkbox" name="chk_qc" id="chk_qc" > Control de calidad (QC)
				</label><br>
				<div class="dateQC"></div>
			  </div>
			  <div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal" >Cerrar</button>
				<button type="submit" class="btn btn-primary">Guardar</button>
			  </div>
			  </form>
			</div>
		  </div>
		</div>

		<!-- Agregar Traductor -->
		<div class="modal fade" id="modal_create_traductor" tabindex="-1" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="myModalLabel">
		  <div class="modal-dialog" role="document">
			<div class="modal-content">
			  <div class="modal-header">
				<!--<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>-->
				<h4 class="modal-title" id="t_header">Asignar Traductor</h4>
				<div id="error_agregar_traductor"></div>
			  </div>
			  <form role="form" id="form_agregar_traductor">
				  <div class="modal-body">
						{{ csrf_field() }}
					<input type="hidden" name="id" id="id_episodio">
					<input type="hidden" name="proyectoId" value="{{ $proyecto_id }}">
					<label>Traductor</label>
					<select name="traductor" class="form-control selectpicker" data-style="btn-primary" data-show-subtext="true" data-live-search="true" title="Seleccionar..." required>
						@foreach($traductores as $traductor)
							<option value="{{ $traductor->id }}">{{ $traductor->ap_paterno}} {{ $traductor->name }} @if($traductor->name) {{ $traductor->ap_materno }} @endif</option>
						@endforeach
					</select>
					<label>Fecha de entrega del traductor</label>
					<input type="text" name="fecha_entrega_traductor" class="form-control"  required>
					<label>
					<input type="checkbox" class="check" name="aprobacion_cliente" id="aprobacion_cliente" > Aprobación del cliente
					</label><br>
					<div id="input_aprobacion_cliente"></div>
					<label>
					<input type="checkbox" class="check" name="sin_script" id="sin_script" > Sin script
					</label>
					<div class="form-group">
						<label for="script_original_create">Script Original</label>
						<input type="text" class="form-control" id="script_original" name="script_original" readonly="true" placeholder="Script Original">
					</div>
					<label>
					<input type="checkbox" class="check" name="rayado" id="rayado" > Rayado
					</label>
					<div id="input_rayado"></div>
					<label>
					<input type="checkbox" class="check" name="chk_canciones" id="chk_canciones" > Canciones
					</label><br>
					<label>
					<input type="checkbox" class="check" name="chk_subtitulos" id="chk_subtitulos" > Subtitulos
					<div id="input_subtitulos_create"></div>
					</label><br>
					<label>
					<input type="checkbox" class="check" name="chk_lenguaje_diferente_original" id="chk_lenguaje_diferente_original" > Lenguaje diferente al original
					</label><br>
					<label>Observaciones</label>
					<textarea class="form-control" name="observaciones_traductor" ></textarea>
				  </div>
				  <div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal" >Cerrar</button>
					<button type="submit" class="btn btn-primary">Guardar</button>
				  </div>
			  </form>
			</div>
		  </div>
		</div>


		<!-- Actualizar Traductor -->
		<div class="modal fade" id="modal_update_traductor" tabindex="-1" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="myModalLabel">
			  <div class="modal-dialog" role="document">
				<div class="modal-content">
				  <div class="modal-header">
					<!--<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>-->
					<h4 class="modal-title" id="t_header">Asignar Traductor</h4>
					<div id="error_agregar_traductor"></div>
				  </div>
				  <form role="form" id="form_actualizar_traductor">
					  <div class="modal-body">
							{{ csrf_field() }}
						<input type="hidden" name="id" id="id_episodio">
						<input type="hidden" name="proyectoId" value="{{ $proyecto_id }}">
						<label>Traductor</label>
						<select name="traductor" class="form-control selectpicker" data-style="btn-primary" data-show-subtext="true" data-live-search="true" title="Seleccionar..." required>
							@foreach($traductores as $traductor)
								<option value="{{ $traductor->id }}">{{ $traductor->ap_paterno}} {{ $traductor->name }} @if($traductor->name) {{ $traductor->ap_materno }} @endif</option>
							@endforeach
						</select>
						<label>Fecha de entrega del traductor</label>
						<input type="text" name="fecha_entrega_traductor" id="fecha_entrega_traductor" class="form-control" required>
						<label>
						<input type="checkbox" class="check" name="aprobacion_cliente" id="aprobacion_cliente" > Aprobación del cliente
						</label><br>
						<div id="input_aprobacion2_cliente"></div>
						<label>
						<input type="checkbox" class="check" name="sin_script" id="sin_script" > Sin script
						</label>
						<div class="form-group">
							<label for="script_original_create">Script Original</label>
							<input type="text" class="form-control" id="script_original" name="script_original" readonly="true" placeholder="Script Original">
						</div>
						<label>
						<input type="checkbox" class="check" name="rayado" id="rayado" > Rayado
						</label>
						<div id="input_rayado2"></div>
						<label>
						<input type="checkbox" class="check" name="chk_canciones" id="chk_canciones" > Canciones
						</label><br>
						<label>
						<input type="checkbox" class="check" name="chk_subtitulos" id="chk_subtitulos" > Subtitulos
						<div id="input_subtitulos_update"></div>
						</label><br>
						<label>
						<input type="checkbox" class="check" name="chk_lenguaje_diferente_original" id="chk_lenguaje_diferente_original" > Lenguaje diferente al original
						</label><br>
						<label>Observaciones</label>
						<textarea class="form-control" name="observaciones_traductor" ></textarea>
					  </div>
					  <div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal" >Cerrar</button>
						<button type="submit" class="btn btn-primary">Guardar</button>
					  </div>
				  </form>
				</div>
			  </div>
			</div>

	<!-- Modal Configuración Update Eliminar Modal-->
	<div class="col-md-12">
		<div class="modal fade" id="modal_update_configuracion" tabindex="-1" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="myModalLabel">
		  <div class="modal-dialog" role="document">
			<div class="modal-content">
				  <div class="modal-header">
						<!--<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>-->
						<h4 class="modal-title" id="t_header">Modificar Configuración</h4>
						<div id="error_update_episodios"></div>
				  </div>
				  <form role="form" id="form_update_configuracion">
					  <div class="modal-body">
						{{ csrf_field() }}
						<input type="hidden" name="id" id="id_configuracion">
						<table class="table table-striped ">
							<tr>
								@foreach($catalogos as $c)
									<td>
										<input type="checkbox" name="{{$c->id}}" class="checkConfig" >
										<label> &nbsp; {{strtoupper($c->nombre)}}</label>
										<p id='{{$c->id}}'></p>
									</td>
								@endforeach
							</tr>
						</table>
						{{-- <table class="table table-striped ">
							<tr>
								<td>
									<input type="checkbox"  id="bw_update" name="bw"> BW
								</td>
							</tr>
						</table> --}}
					  </div>
					  <div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal" >Cerrar</button>
						<button type="submit" class="btn btn-primary" id="btn_update_configuracion">Guardar</button>
					  </div>
				  </form>
			</div>
		  </div>
		</div>
	</div>

	<!-- Modal Update-->
	<div class="col-md-12">
		<div class="modal fade" id="modal_update_episodio" tabindex="-1" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="myModalLabel">
		  <div class="modal-dialog" role="document">
			<div class="modal-content">
			  <div class="modal-header">
				<!--<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>-->
				<h4 class="modal-title" id="t_header">Modificar Episodio</h4>
				<div id="error_update_episodios"></div>
			  </div>
			  <form role="form" id="form_update_episodio">
			  <div class="modal-body">
						{{ csrf_field() }}
						<input type="hidden" name="id" >
						<input type="hidden" name="proyectoId" value="{{ $proyecto_id }}">
						<div class="form-group">
							<label >Seleccionar Productor</label>
							<select class="form-control selectpicker" name="productor" data-style="btn-primary" data-show-subtext="true" data-live-search="true" title="Seleccionar...">
								@foreach($productores as $productor)
									<option value="{{ $productor->id }}">{{ $productor->id }}  {{ $productor->name }} {{ $productor->ap_paterno }} {{ ($productor->ap_materno )}} </option>
								@endforeach
							</select>
						</div>
						<div class="form-group">
							<label>Seleccionar Responsable</label>
							<select class="form-control selectpicker" name="responsable" data-style="btn-primary" data-show-subtext="true" data-live-search="true" title="Seleccionar...">
								<option value="">Seleccionar</option>
								@foreach($responsables as $responsable)
									<option value="{{ $responsable->id }}"> {{ $responsable->id }} {{ $responsable->name }} {{ $responsable->ap_paterno }} {{ ($responsable->ap_materno )}} </option>
								@endforeach
							</select>
						</div>
						<div class="form-group">
							<label for="entrega_episodio">Título LAS</label>
							<input type="text" class="form-control" id="las_or_lm_update" name="las_or_lm_update" placeholder="Título LAS">
						</div>
						<div class="form-group">
							<label for="entrega_episodio">Título BPO</label>
							<input type="text" class="form-control" id="bpo_or_lm_update" name="bpo_or_lm_update" placeholder="Título BPO">
						</div>
						<div class="form-group">
							<label>Título Original del episodio</label>
							<input type="text" class="form-control" name="titulo_original_episodio" placeholder="Título Original del episodio">
						</div>
						<div class="form-group">
							<label>Configuración</label>
							<textarea name="configuracion" class="form-control"></textarea>
						</div>
						<div class="form-group">
							<label>Número de Episodio</label>
							<input type="text" class="form-control" name="num_episodio" placeholder="Número de episodio">
						</div>
						<div>
						<div class=" col-md-6 form-group">
								<label for="entrega_me">Fecha de descarga</label>
								<input type="text" class="form-control" id="fecha_descarga_update" name="fecha_descarga_update" readonly="true" placeholder="Fecha de descarga">
							</div>
							<div class=" col-md-6 form-group">
								<label for="entrega_me">Referencia</label>
								<input type="text" class="form-control" id="referencia" name="referencia"  placeholder="Referencia">
							</div>
						</div>
						<div class=" col-md-6 form-group">
								<label for="envio_mp4_update">Fecha de envío de MP4 a traductor</label>
								<input type="text" class="form-control" id="envio_mp4_update" name="envio_mp4_update" readonly="true" placeholder="Fecha de envío de MP4 a traductor">
							</div>
							<div class=" col-md-6 form-group">
								<label for="script_original_update">Script Original</label>
								<input type="text" class="form-control" id="script_original_update" name="script_original_update" readonly="true" placeholder="Script Original">
							</div>
						</div>
						<div>
						<div>
							<table class="table">
								<tr>
									<td><input type="checkbox" name="notificacion_pistas"><label> &nbsp; Notificación a producción y pistas</label></td>
									<td><input type="checkbox" name="envio_sebastians"><label> &nbsp; Envío Sebastians</label></td>
									<td><input type="checkbox" name="ot"><label> &nbsp; OT</label></td>
								</tr>
							</table>
						</div>
						<div class="col-md-12 form-group">
							<label>Seleccionar Tipos de trabajos</label>
							<select class="form-control selectpicker" id="tipo_trabajo_update" name="tipo_trabajo_update" data-style="btn-primary" data-show-subtext="true" data-live-search="true" title="Seleccionar...">
								@if(count($tiposTrabajo) > 0)
									@foreach($tiposTrabajo as $trabajo)
										<option value="{{ $trabajo->id }}"> {{ $trabajo->nombre }} </option>
									@endforeach
								@endif
							</select>
						</div>
						@if( $proyecto->m_and_e == true )
						<div class="col-md-12 form-group">
							<label>Fecha de entrega M&E</label>
							<input type="text" class="form-control" name="entrega_me" readonly="true" placeholder="Fecha de entrega M&E">
						</div>
						@endif
				<div class="col-md-12 form-group">
					<label>Fecha de entrega del Episodio</label>
					<input type="text" class="form-control" name="entrega_episodio" readonly="true" placeholder="Fecha de entrega del Episodio">
				</div>

				<div class="col-md-12 form-group">
					<label for="referencia_envio">Enviado a</label>
					<input type="text" class="form-control" id="enviado_a" name="enviado_a"  placeholder="Enviado a">
				</div>

				<div class="col-md-12 form-group">
					<label for="referencia_envio">Método de envío</label>
					<input type="text" class="form-control" id="metodo_envio" name="metodo_envio"  placeholder="Método de envío">
				</div>
				
				<div class="col-md-12 form-group">
					<label for="referencia_envio">Referencia de envío</label>
					<input type="text" class="form-control" id="referencia_envio" name="referencia_envio"  placeholder="Referencia de envío">
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
		<div class="modal fade" id="modal_delete_episodio" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		  <div class="modal-dialog" role="document">
			<div class="modal-content">
			  <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title " id="myModalLabel">Eliminar Episodio</h4>
			  </div>
			  <form id="form_delete_episodio" method="POST" action="{{ route('delete_episodio') }}">
				  <img src="{{ asset('assets/dashboard/images/error/peligro.png') }}">
				  {{ csrf_field() }}
				  <input type="hidden" name="id" value="">
				  <input type="hidden" name="id_proyecto" value="">
				  <label class="label label-default">¿Realmente deseas eliminarlo?</label><br>
				  <p class="label label-danger">Tomar en cuenta que también se eliminará su calificación.</p>
				  <div class="modal-footer">
					<button type="submit" class="btn btn-danger">Eliminar</button>
				  </div>
			  </form>
			</div>
		  </div>
		</div>
	</div>

	<!-- Modal Consulta-->
	<div class="col-md-12">
		<div class="modal fade" id="modal_ver_episodio" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		  <div class="modal-dialog" role="document">
			<div class="modal-content">
			  <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title ">Consulta Episodio</h4>
			  </div>
			  <div class="modal-body">
			  	<h2 class="center" role="alert"></h2>
		  		<table class="table table-striped">
		  			<tr><td><h5>Responsable:</h5></td><td id="responsable"></td></tr>
		  			<tr><td><h5>Productor:</h5></td><td id="productor"></td></tr>
		  			<tr><td><h5>Título Original del episodio:</h5></td><td id="titulo_original"></td></tr>
		  			@if(\Request::session()->has('show_fecha_entrega'))
		  				<tr><td><h5>Fecha de entrega episodio:</h5></td> <td id="fecha_entrega"></td></tr>
		  			@endif
		  			<tr><td><h5>Número de Episodio:</h5></td><td id="num_episodio"></td></tr>
		  			<tr><td><h5>Sala:</h5></td><td id="sala"></td></tr>
		  			<tr><td><h5>Fecha de entrega M&E:</h5></td><td id="fecha_mande"></td></tr>
		  			<tr><td><h5>Configuración:</h5></td><td id="configuracion"></td></tr>
		  		</table>
			  </div>
			  <div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
			  </div>
			</div>
		  </div>
		</div>
	</div>

	<!-- Calificar material del episodio Crear-->
	<div class="col-md-12">
		<div class="modal fade" id="modal_calificar_material" data-name="modal" tabindex="-1" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="myModalLabel">
		  <div class="modal-dialog" role="document">
			<div class="modal-content">
			  <div class="modal-header">
				<!--<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>-->
				<h4 class="modal-title" id="t_header">Calificar Material</h4>
				<div id="error_create_calificar_material"></div>
			  </div>
			  <form role="form" id="form_create_calificar_material">
				  <div class="modal-body">
						{{ csrf_field() }}
					<div class="form-group">
					@if( !empty($episodio->id) )
					<input type="hidden" name="id" id="episodioId">
						<input type="text" class="form-control" id="correo_activo"  name="correo_activo" readonly="true" value="{{ Auth::user()->email }}">
					</div>
					@endif
					<div class="form-group">
						<label for="duracion">Duración</label>
						<input type="text" class="form-control" id="duracion" name="duracion" placeholder="--:--:--:--" data_mask="hho">
					</div>
					<div class="form-group">
						<label for="tipo_reporte">Tipo de reporte</label><br>
						<select id="tipo_reporte" name="tipo_reporte" multiple="multiple" >
							@foreach($reportes as $reporte)
								<option value="{{$reporte->tipo}}">{{$reporte->tipo}}</option>
							@endforeach
						</select>
						<input type="hidden" name="reporte" id="reporte" value="">
					</div>
					<div class="form-group">
						<label for="mezcla">Mezcla</label>
						<select name="mezcla" class="form-control selectpicker" data-style="btn-primary" data-show-subtext="true" data-live-search="true" title="Seleccionar...">
							<option value="Mono">Mono</option>
							<option value="Stereo">Stereo</option>
							<option value="5.1">5.1</option>
							<option value="7.1">7.1</option>
						</select>
					</div>
					<div class="form-group">
						<label for="tipo_reporte">Tcr</label>
						<select class="form-control selectpicker" name="tcr" data-style="btn-primary" data-show-subtext="true" data-live-search="true" title="Seleccionar...">
							@foreach($tcrs as $tcr)
								<option value="{{$tcr->id}}">{{$tcr->tcr}}</option>
							@endforeach
						</select>
					</div>
					<div class="form-group">
						<label for="observaciones">Observaciones</label>
						<textarea name="observaciones" id="observaciones" placeholder="Observaciones" class="form-control"></textarea>
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
	<!-- Asignar Traductor-->
	<div class="col-md-12">
		<div class="modal fade" id="modal_coordinador" data-name="modal" tabindex="-1" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="myModalLabel">
		  <div class="modal-dialog" role="document">
			<div class="modal-content">
			  <div class="modal-header">
				<!--<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>-->
				<h4 class="modal-title" >Asignar Traductor</h4>
				<div id="error_add_traductor"></div>
			  </div>
			  <form role="form" id="form_add_traductor" >
				  <div class="modal-body">
						{{ csrf_field() }}
					<div class="form-group">
						<label for="duracion">Fecha Actual</label>
						<input type="text" class="form-control" id="fecha_generada_traductor" name="fecha_generada_traductor" value="{{date('d-m-Y')}}" disabled="true">
					</div>
					<div class="form-group">
						<label for="fecha_entrega_traductor">Fecha de Entrega por el Traductor</label>
						<input type="text" class="form-control" id="fecha_entrega_traductor" name="fecha_entrega_traductor" >
					</div>
					<div class="form-group">
						<label for="sala">Seleccionar Sala</label>
						<select class="form-control selectpicker" id="sala" name="sala" id="sala" data-style="btn-primary" data-show-subtext="true" data-live-search="true" title="Seleccionar..." >
							<option value="">Seleccionar</option>
							@foreach($salas as $sala)
								<option value="{{ $sala->id }}"> {{ $sala->sala }} </option>
							@endforeach
						</select>
					</div>
					<div class="form-group">
						<label for="traductor">Asignar Traductor</label>
						<select name="traductor" class="form-control selectpicker" data-style="btn-primary" data-show-subtext="true" data-live-search="true" title="Seleccionar...">
							<option value="">Seleccionar...</option>
							@foreach($traductores as $traductor)
								<option value="{{$traductor->id}}">{{$traductor->name}} {{$traductor->ap_paterno}} {{$traductor->ap_materno}}</option>
							@endforeach
						</select>
					</div>
					<input type="checkbox" id="script" name="script">
					<label>Con Script</label> &nbsp;&nbsp;&nbsp;&nbsp;
					<input type="checkbox" id="rayado" name="rayado">
					<label>Rayado</label>
					<input type="hidden" name="episodioId" id="episodioId" ><br>
					<label>
						<input type="checkbox" name="aprobacion_cliente" id="aprobacion_cliente"> Aprobación del Cliente
					</label>
					 <div class="modal-footer">
					   <button type="button" class="btn btn-default" data-dismiss="modal" >Cerrar</button>
					   <button type="submit" class="btn btn-primary">Guardar</button>
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

			$('#table_episodios').DataTable({
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
			
			/**
			 * Formato Fecha
			 */
			$('input[name=fecha_descarga_create]').datepicker({
				dateFormat: "yy-mm-dd",
				minDate: 0,
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

			$('input[name=envio_mp4_create], input[name=envio_mp4_update]').datepicker({
				dateFormat: "yy-mm-dd",
				minDate: 0,
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

			$('input[name=script_original_create], input[name=script_original_update]').datepicker({
				dateFormat: "yy-mm-dd",
				minDate: 0,
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
			/*
			* Modal para actualizar episodios
			*/
			$('#modal_update_episodio').on('shown.bs.modal', function(e){
				var id = $(e.relatedTarget).data().id;
				$(".loader").fadeIn();
				$.ajax({
					url: "{{ url('mgepisodios/edit') }}" + "/" + id,
					type: "GET",
					success: function(resp){
						console.log(resp);
						$(".loader").fadeOut("slow");
						$('input[name=id]').val(resp.data['0'].id);
						$('input[name=proyectoId]').val(resp.data['0'].proyectoId);
						$('select[name=productor]').val(resp.data['0'].productor);
						$('select[name=responsable]').val(resp.data['0'].responsable);
						$('select[name=tipo_trabajo_update]').val(resp.data['0'].tipo_trabajo_id);
						$('input[name=titulo_original_episodio]').val(resp.data['0'].titulo_original);
						$('textarea[name=configuracion]').val(resp.data['0'].configuracion);
						$('input[name=num_episodio]').val(resp.data['0'].num_episodio);
						$('input[name=entrega_me]').val(resp.data['0'].date_m_and_e);
						$('input[name=fecha_descarga_update]').val(resp.data['0'].date_download);
						$('input[name=referencia]').val(resp.data['0'].reference_download);
						$('input[name=entrega_episodio').val(resp.data['0'].date_entrega);
						$('input[name=notificacion_pistas]').val(resp.data['0'].notify_pistas);
						$('input[name=envio_sebastians]').val(resp.data['0'].send_sebastians);
						$('input[name=ot').val(resp.data['0'].ot);
						$('input[name=envio_mp4_update').val(resp.data['0'].envio_mp4);
						$('input[name=enviado_a').val(resp.data['0'].enviado_a);
						$('input[name=metodo_envio').val(resp.data['0'].metodo_envio);
						$('input[name=referencia_envio').val(resp.data['0'].referencia_envio);
						$('input[name=las_or_lm_update').val(resp.data['0'].las_or_lm);
						$('input[name=bpo_or_lm_update').val(resp.data['0'].bpo_or_lm);
						$('.selectpicker').selectpicker('refresh');

						//Notificacion de pistas
						if(resp.data['0'].notify_pistas == true){
							$('input[name=notificacion_pistas').prop( "checked", true ).attr( "disabled", true ).removeAttr('name');
						} else {
							$('input[name=notificacion_pistas').prop( "checked", false ).attr( "disabled", false ).attr('name', 'notificacion_pistas');
						}

						//BW
						if(resp.data['0'].send_sebastians == true){
							$('input[name=envio_sebastians').prop( "checked", true ).attr( "disabled", true ).removeAttr('name');
						} else {
							$('input[name=envio_sebastians').prop( "checked", false ).attr( "disabled", false ).attr('name', 'envio_sebastians');
						}

						//BW
						if(resp.data['0'].ot == true){
							$('input[name=ot').prop( "checked", true ).attr( "disabled", true ).removeAttr('name');
						} else {
							$('input[name=ot').prop( "checked", false ).attr( "disabled", false ).attr('name', 'ot');
						}

						$('input[name=fecha_descarga_update]').datepicker({
							dateFormat: "yy-mm-dd",
							minDate: 0,
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
						
					},
					error: function(error){
						var err = "";
						for(var i in error.responseJSON.msg){
							err += error.responseJSON.msg[i] + "<br>";
						}
						$('#error_update_episodios').html('<div class="alert alert-danger">' + err + '</div>');
					}
				});

				$('#form_update_episodio').on('submit', function(event){
					event.preventDefault();
					$.ajax({
						url: "{{ url('mgepisodios/update') }}",
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
							$('#error_update_episodios').html('<div class="alert alert-danger">' + err + '</div>');
						}
					});
				});
			});

			/*
			* Modal para eliminar episodios
			*/
			$('#modal_delete_episodio').on('shown.bs.modal', function(e){
				var id = $(e.relatedTarget).data().id;
				$("input[name=id]").val(id);
				$("input[name=id_proyecto]").val({{$proyecto->id}});
				//   $('#form_delete_episodio').attr('action',  url("mgepisodios/delete") /' + id + '/' + $proyecto->id );
			});

			/*
			* Modal para guardar episodios
			*/
			$('#modal_save_episodio').on('shown.bs.modal', function(e){
				var id = $(e.relatedTarget).data().id;

				$('#form_create_episodio').on('submit', function(event){
					event.preventDefault();
					/**
					 * Deshabilitar boton de crear despues de dar clcik
					 */

					$('#btn_crear_episodio').prop('disabled', true);
					
					$.ajax({
						url: "{{ url('mgepisodios/save') }}",
						type: "POST",
						data: $( this ).serialize(),
						success: function( res ){

							$('#info_episodio').html('');

							if(res['status'] == 200){
								$('#btn_crear_episodio').delay( 2000 ).prop('disabled', false);
								window.location.reload(true);
							}

							if(res['status']  == 201){
								console.log(res['status']);
								$('#btn_crear_episodio').delay( 2000 ).prop('disabled', false);
								$('#info_episodio').append("<div class='alert alert-danger' id='info-episodio' role='alert'>"+res['msg']+"</div>");
							}
						},
						error: function(error){
							$('#btn_crear_episodio').delay( 2000 ).prop('disabled', false);
							var err = "";
							for(var i in error.responseJSON['msg']){
								err += error.responseJSON.msg[i] + "<br>";
							}
							$('#error_create_episodio').html('<div class="alert alert-danger">' + err + '</div>');
						}
					});
				});
			});

			$('#form_add_traductor').on('submit', function(event){
				event.preventDefault();
				$(".loader").fadeIn();
				$.ajax({
					url: "{{ url('mgepisodios/assign-traductor') }}",
					type: "POST",
					data: $( this ).serialize(),
					success: function( data ){
						$(".loader").fadeOut("slow");
						if(data.msg == 'success'){
							window.location.reload(true);
						}
					},
					error: function(error){
						var err = "";
						for(var i in error.responseJSON.msg){
							err += error.responseJSON.msg[i] + "<br>";
						}
						$('#error_add_traductor').html('<div class="alert alert-danger">' + err + '</div>');
					}
				});
			});

			/*
			* Modal para actualizar la configuración
			* BW, NetCut, LockCut y Final
			*/
			$('#modal_update_configuracion').on('shown.bs.modal', function(e){
				var id = $(e.relatedTarget).data().id;
				$('.checkConfig').prop("checked", false);
				$('#id_configuracion').val(id);
				$(".loader").fadeIn();
				$.ajax({
					url: "{{ url('mgepisodios/edit') }}" + "/" + id,
					type: "GET",
					success: function( data ){
						console.log('REF-DATA', data);
						data['listConfig'].forEach(element => {
							var num = element['id'];
							$(`input[name = ${num}]`).prop( "checked", false ).attr( "disabled", false );
							$(`#${num}`).html('');
						});

						data['dataClear'].forEach(element => {
							var num = element['id_catalogo_configuracion'];
							var fecha = element['created_at'];
							var d = new Date(`${fecha}`).toLocaleDateString();
							$(`input[name = ${num}]`).prop( "checked", true ).attr( "disabled", true );
							$(`#${num}`).html(d);
						});

						
						$(".loader").fadeOut("slow");
					}
				});

				$('#form_update_configuracion').on('submit', function(event){
					event.preventDefault();

					$('#btn_update_configuracion').prop('disabled', true);

					$.ajax({
						url: "{{ url('mgepisodios/update-configuracion') }}",
						type: "POST",
						data: $( this ).serialize(),
						success: function(data) {
							if(data['msg'] == 'success'){
								window.location.reload(true);
								$('#btn_update_configuracion').delay( 2000 ).prop('disabled', false);
							}
						},
						error: function(error) {
							console.log("REF-error", error);
							$('#btn_update_configuracion').delay( 2000 ).prop('disabled', false);
						}
					});
				})
			});

			/*
			* Modal para calificar Material
			*/
			$('#modal_calificar_material').on('shown.bs.modal', function(e){
				var id = $(e.relatedTarget).data().id;
				$('#episodioId').val(id);

				$('#form_create_calificar_material').on('submit', function(event){
					event.preventDefault();
					$.ajax({
						url: "{{ url('mgepisodios/calificar_material') }}",
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
							$('#error_create_calificar_material').html('<div class="alert alert-danger">' + err + '</div>');
						}
					});
				});
			});

			$('#modal_ver_episodio').on('shown.bs.modal', function(e){
				var id = $(e.relatedTarget).data().id;
				$(".loader").fadeIn();
				$.ajax({
					url: "{{ url('mgepisodios/show_episodio	') }}" + "/" + id,
					type: "GET",
					success: function(data){
						$(".loader").fadeOut("slow");
						$('h2').html('Fecha de entrega: '+data.episodios[0].date_entrega).addClass('alert alert-'+data.status_entrega);

						if(data.msg = 'success'){
							$('td#responsable').html(data.episodios[0].responsable+' '+data.episodios[0].responsable_ap_paterno+' '+data.episodios[0].responsable_ap_materno);
							$('td#productor').html(data.episodios[0].productor+' '+data.episodios[0].productor_ap_paterno+' '+data.episodios[0].productor_ap_materno);
							$('td#titulo_original').html(data.episodios[0].titulo_original);
							$('td#fecha_entrega').html('<span class="label label-'+data.status_entrega+'">'+data.episodios[0].date_entrega+'<span>');
							$('td#num_episodio').html(data.episodios[0].num_episodio);
							if(data.episodios[0].salaId == null){
								$('td#sala').html('Sin asgnación');
							} else {
								$('td#sala').html(data.episodios[0].salaId);
							}
							$('td#fecha_mande').html(data.episodios[0].date_m_and_e);
							if(data.episodios[0].configuracion == null){
								$('td#configuracion').html('Sin Configuración');
							} else {
								$('td#configuracion').html(data.episodios[0].configuracion);
							}
						}
					},
					error: function(error){

					}
				});
			});

			/*
			* Ventana modal para asignar Productor
			*/
			$('#modal_create_productor').on('show.bs.modal', function(e){
				$(".selectpicker").val('default');
				$('.selectpicker').selectpicker('refresh');
				var id = $(e.relatedTarget).data().id;
				$('input[name=chk_edicion]').attr('checked', false);
				$('div.dateEdicion').html('');
				$('input[name=chk_reprobacion]').attr('checked', false);
				$('div.dateRegrabacion').html('');
				$('input[name=chk_qc]').attr('checked', false);
				$('div.dateQC').html('');

				$('#id').val(id);
				if($('input[name=chk_edicion]').is(':checked')){
					$('div.dateEdicion').html('<label>Fecha Edición</label>\
						<input type="text" name="fecha_edicion" class="form-control" required>');
				} else{
					$('div.dateEdicion').html('');
				}

				$('input[name=chk_edicion]').on('click', function(){
					if($(this).is(':checked')){
						$('div.dateEdicion').html('<label>Fecha Edición</label>\
							<input type="text" name="fecha_edicion" class="form-control" title="Seleccionar..." required>\
							<br>\
							<label>Editor</label>\
							<select name="nombre_editor" class="form-control " required>\
							<option value="">Seleccionar</option>\
							@foreach($tecnicos as $tecnico)\
							<option value="{{ $tecnico->id }}">{{ $tecnico->name }} {{ $tecnico->ap_paterno }} {{ $tecnico->ap_materno }}</option>\
							@endforeach\
							</select>\
							');

							$('select[name=nombre_editor]').selectpicker({
								liveSearch: true,
								style: 'btn-primary'
							});
					} else{
						$('div.dateEdicion').html('');
					}

					$('input[name=fecha_edicion]').datepicker({
						dateFormat: "yy-mm-dd",
						minDate: 0,
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
				});

				$('input[name=chk_reprobacion]').on('click', function(){
					if($(this).is(':checked')){
						$('div.dateRegrabacion').html('<label>Fecha Regrabación</label>\
							<input type="text" name="fecha_regrabacion" class="form-control" required>\
							<br>\
							<label>Regrabador</label>\
							<select name="nombre_regrabador"  class="form-control" required>\
							<option value="">Seleccionar</option>\
							@foreach($tecnicos as $tecnico)\
							<option value="{{ $tecnico->id }}">{{ $tecnico->name }} {{ $tecnico->ap_paterno }} {{ $tecnico->ap_materno }}</option>\
							@endforeach\
							</select>\
							');
							$('input[name=fecha_regrabacion]').datepicker({
								dateFormat: "yy-mm-dd",
								minDate: 0,
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

							$('select[name=nombre_regrabador]').selectpicker({
								liveSearch: true,
								style: 'btn-primary'
							});
					} else{
						$('div.dateRegrabacion').html('');
					}

					
				});

				$('input[name=chk_qc]').on('click', function(){
					if($(this).is(':checked')){
						$('div.dateQC').html('<label>Fecha QC</label>\
							<input type="text" name="fecha_qc" class="form-control" required>\
							<br>\
							<label>QC</label>\
							<select name="nombre_qc"  class="form-control" required>\
							<option value="">Seleccionar</option>\
							@foreach($tecnicos as $tecnico)\
							<option value="{{ $tecnico->id }}">{{ $tecnico->name }} {{ $tecnico->ap_paterno }} {{ $tecnico->ap_materno }}</option>\
							@endforeach\
							</select>\
							');

							$('select[name=nombre_qc]').selectpicker({
								liveSearch: true,
								style: 'btn-primary'
							});
					} else{
						$('div.dateQC').html('');
					}

					$('input[name=fecha_qc]').datepicker({
						dateFormat: "yy-mm-dd",
						minDate: 0,
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
				});

				$.ajax({
					url: '{{ url('/mgepisodios/edit') }}'+'/'+id,
					type: 'GET',
					success: function(data){

						$('.date-type-rayado').html('');
						if(data.fecha_rayado){
							$('.date-type-rayado').html('Fecha rayado: ' + data.fecha_rayado);
						} else {
							$('.date-type-rayado').html('Sin fechade rayado asignada');
						}

						if(data.sin_script == false){
							//$('.add_date_script').html('<label>Fecha de script</label><input type="text" id="fecha_script" name="fecha_script" class="form-control" required></input>');


							$('#fecha_script').datepicker({
								dateFormat: "yy-mm-dd",
								minDate: 0,
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
						}
					},
					error: function(error){

					}
				});

				$('#form_agregar_productor').on('submit', function(event){
					event.preventDefault();
					$.ajax({
						url: "{{ url('/mgepisodios/add-productor') }}",
						type: "POST",
						data: $(this).serialize(),
						success: function(data){
							if(data.msg = 'success'){
								location.reload();
							}
						},
						error: function(error){
							console.log(error)
							if(error.responseJSON.validator.length > 0){
								var err = "";
								for(var i in error.responseJSON.validator){
									err += error.responseJSON.validator[i] + "<br>";
								}
								$('#error_agregar_productor').html('<div class="alert alert-danger">' + err + '</div>');
							}
						}
					});
				});

			});

				/*
				* Ventana modal para modificar al Productor
				*/
				$('#modal_update_productor').on('shown.bs.modal', function(e){
					$(".selectpicker").val('default');
					$('.selectpicker').selectpicker('refresh');
					var id = $(e.relatedTarget).data().id;
					$(".loader").fadeIn();
					$.ajax({
						url: "{{ url('/mgepisodios/edit') }}"+"/"+id,
						type: 'GET',
						success: function(resp){
							console.log("REF-RESPONSE", resp.data[0])
							$(".loader").fadeOut("slow");
							$('.date-type-rayado').html('');
							if(resp.data[0].fecha_rayado){
								$('.date-type-rayado').html('Fecha rayado: ' + resp.data[0].fecha_rayado);
							} else {
								$('.date-type-rayado').html('Sin fecha asignada');
							}
							$('input[name=id]').val(resp.data[0].id);
							$('select[name=sala]').val(resp.data[0].salaId);
							$('select[name=director]').val(resp.data[0].directorId);
							$('select[name=ingeniero_audio_id]').val(resp.data[0].ingeniero_audio_id);
							$('.selectpicker').selectpicker('refresh');
							if(resp.data[0].chk_qc == true){
								$('input[name=chk_qc]').prop('checked', true)
							}
							if(resp.data[0].chk_reprobacion == true){
								$('input[name=chk_reprobacion]').prop('checked', true)
							}

							if(resp.data[0].sin_script == false){
								/*var fechaScript = '';
								if(data.fecha_script != null){
									fechaScript = data.fecha_script;
								}*/
								$('#add_date_script').html('<label>Fecha de script</label><input type="text" id="fecha_script2" name="fecha_script" class="form-control" value="'+resp.data[0].fecha_rayado+'" required></input>');

								$('#fecha_doblaje_update, #fecha_script2').datepicker({
									dateFormat: "yy-mm-dd",
									minDate: 0,
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
							}

							if($('input[name=chk_reprobacion]').val(resp.data[0].chk_reprobacion) == true){

								$('div.dateRegrabacion').html('<label>Fecha Regrabación</label>\
										<input type="text" name="fecha_regrabacion" class="form-control" value="'+resp.data[0].fecha_regrabacion+'" required>\
										<label>Editor</label>\
										<select name="nombre_regrabador"  class="form-control" required>\
										<option value="">Seleccionar</option>\
										@foreach($tecnicos as $tecnico)\
										<option value="{{ $tecnico->id }}" '+(resp.data[0].nombre_regrabador == {{ $tecnico->id }}) ? selected : ""+'>{{ $tecnico->name }} {{ $tecnico->ap_paterno }} {{ $tecnico->ap_materno }}</option>\
										@endforeach\
										</select>');

									$('select[name=nombre_regrabador]').selectpicker({
										liveSearch: true,
										style: 'btn-primary'
									});
							} else{
								$('input[name=chk_reprobacion]').attr('checked', false)
								$('div.dateRegrabacion').html('');
							}

							if(resp.data[0].chk_edicion == true){
								$('input[name=chk_edicion]').prop('checked', true);
								$('div.dateEdicion').html('<label>Fecha Edición</label>\
										<input type="text" name="fecha_edicion" class="form-control" value="'+resp.data[0].fecha_edicion+'" required>\
										<label>Editor</label>\
										<select name="nombre_editor"  class="form-control" required>\
										<option value="">Seleccionar</option>\
										@foreach($tecnicos as $tecnico)\
										<option value="{{ $tecnico->id }}" '+(resp.data[0].nombre_editor == {{ $tecnico->id }} ? 'selected' : '')+'>{{ $tecnico->name }} {{ $tecnico->ap_paterno }} {{ $tecnico->ap_materno }}</option>\
										@endforeach\
										</select>');
							} else{
								$('input[name=chk_edicion]').prop('checked', false);
							}

							if(resp.data[0].chk_reprobacion== true){
								var fechaRegrabacion = '';
								if(resp.data[0].fecha_regrabacion != 'null'){
									fechaRegrabacion = resp.data[0].fecha_regrabacion;
								}
								$('input[name=chk_reprobacion]').prop('checked', true);
								$('div.dateRegrabacion').html('<label>Fecha Regrabación</label>\
										<input type="text" name="fecha_regrabacion" class="form-control" value="'+fechaRegrabacion+'" required>\
										<label>Regrabador</label>\
										<select name="nombre_regrabador"  class="form-control" required>\
										<option value="">Seleccionar</option>\
										@foreach($tecnicos as $tecnico)\
										<option value="{{ $tecnico->id }}" '+(resp.data[0].nombre_regrabador == {{ $tecnico->id }} ? 'selected' : '')+'>{{ $tecnico->name }} {{ $tecnico->ap_paterno }} {{ $tecnico->ap_materno }}</option>\
										@endforeach\
										</select>');
							} else{
								$('input[name=chk_edicion]').prop('checked', false);
							}

							$('input[name=chk_edicion]').on('click', function(){
								if($(this).is(':checked')){
									if(resp.data[0].fecha_edicion){
										$('div.dateEdicion').html('<label>Fecha Edición</label>\
										<input type="text" name="fecha_edicion" class="form-control" value="'+resp.data[0].fecha_edicion+'" required>\
										<label>Editor</label>\
										<select name="nombre_editor"  class="form-control" required>\
										<option value="">Seleccionar</option>\
										@foreach($tecnicos as $tecnico)\
										<option value="{{ $tecnico->id }}">{{ $tecnico->name }} {{ $tecnico->ap_paterno }} {{ $tecnico->ap_materno }}</option>\
										@endforeach\
										</select>');
									} else{
										$('div.dateEdicion').html('<label>Fecha Edición</label>\
										<input type="text" name="fecha_edicion" class="form-control" required>');
									}

								} else{
									$('div.dateEdicion').html('');
								}
							});

							$('input[name=chk_reprobacion]').on('click', function(){
								if($(this).is(':checked')){
									if(resp.data[0].fecha_edicion){
										var fechaRegrabacion = '';
										if(resp.data[0].fecha_regrabacion != 'null'){
											fechaRegrabacion = resp.data[0].fecha_regrabacion;
										}
										$('div.dateRegrabacion').html('<label>Fecha Regrabación</label>\
										<input type="text" name="fecha_regrabacion" class="form-control" value="'+fechaRegrabacion+'" required>\
										<label>Regrabador</label>\
										<select name="nombre_regrabador"  class="form-control" required>\
										<option value="">Seleccionar</option>\
										@foreach($tecnicos as $tecnico)\
										<option value="{{ $tecnico->id }}">{{ $tecnico->name }} {{ $tecnico->ap_paterno }} {{ $tecnico->ap_materno }}</option>\
										@endforeach\
										</select>');
									} else{
										$('div.dateRegrabacion').html('<label>Fecha Regrabación</label>\
										<input type="text" name="fecha_regrabacion" class="form-control" required>');
									}

								} else{
									$('div.dateEdicion').html('');
								}
							});

							$('input[name=chk_qc]').on('click', function(){
								if($(this).is(':checked')){
									if(resp.data[0].fecha_edicion){
										$('div.dateQC').html('<label>Fecha QC</label>\
										<input type="text" name="fecha_regrabacion" class="form-control" value="'+resp.data[0].fecha_qc+'" required>\
										<label>QC</label>\
										<select name="nombre_qc"  class="form-control" required>\
										<option value="">Seleccionar</option>\
										@foreach($tecnicos as $tecnico)\
										<option value="{{ $tecnico->id }}">{{ $tecnico->name }} {{ $tecnico->ap_paterno }} {{ $tecnico->ap_materno }}</option>\
										@endforeach\
										</select>');
									} else{
										$('div.dateRegrabacion').html('<label>Fecha Regrabación</label>\
										<input type="text" name="fecha_regrabacion" class="form-control" required>');
									}

								} else{
									$('div.dateQC').html('');
								}
							});

							if(resp.data[0].chk_qc== true){
								$('input[name=chk_qc]').prop('checked', true);
								$('div.dateQC').html('<label>Fecha QC</label>\
									<input type="text" name="fecha_qc" class="form-control"  value="'+resp.data[0].fecha_qc+'" required>\
									<label>QC</label>\
									<select name="nombre_qc"  class="form-control" required>\
									<option value="">Seleccionar</option>\
									@foreach($tecnicos as $tecnico)\
									<option value="{{ $tecnico->id }}" '+(resp.data[0].nombre_qc == {{ $tecnico->id }} ? 'selected' : '')+'>{{ $tecnico->name }} {{ $tecnico->ap_paterno }} {{ $tecnico->ap_materno }}</option>\
									@endforeach\
									</select>');
							} else{
								$('input[name=chk_edicion]').prop('checked', false);
							}

							$('input[name=fecha_edicion], input[name=fecha_regrabacion], input[name=fecha_qc]').datepicker({
								dateFormat: "yy-mm-dd",
								minDate: 0,
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

							$('input[name=fecha_doblaje]').val(resp.data[0].fecha_doblaje);
							
							$('.selectpicker').selectpicker('refresh');
						},
						error: function(error){

						}
					});

					$('#form_update_productor').on('submit', function(event){
					event.preventDefault();
					$.ajax({
						url: "{{ url('/mgepisodios/add-productor') }}",
						type: "POST",
						data: $(this).serialize(),
						success: function(data){
							
							if(data.msg = 'success'){
								location.reload();
							}
						},
						error: function(error){
							console.log(error)
							if(error.responseJSON.validator.length > 0){
								var err = "";
								for(var i in error.responseJSON.validator){
									err += error.responseJSON.validator[i] + "<br>";
								}
								$('#error_agregar_productor').html('<div class="alert alert-danger">' + err + '</div>');
							}
						}
					});
				});
				});

			//Ventana modal para asignar traductor
			$('#modal_create_traductor').on('shown.bs.modal', function (e) {
				$('.check').prop("checked", false);
				var id = $(e.relatedTarget).data().id;
				$('select[name=traductor]').val('');
				$('input[name=fecha_entrega_traductor]').val('');
				$('input[name=aprobacion_cliente]').prop('checked', false);
				$('input[name=sin_script]').prop('checked', false);
				$('input[name=rayado]').prop('checked', false);
				$('.selectpicker').selectpicker('refresh');

				$('input[name=id]').val(id);
				$('#aprobacion_cliente').on('click',function(){
					if($(this).is(':checked')){
							$('#input_aprobacion_cliente').html('<label for="titulo_espanol">Fecha aprobación del cliente</label> <input type="text" class="form-control"  name="fecha_aprobacion_cliente" id="fecha_aprobacion_cliente" required>');
							$('#fecha_aprobacion_cliente').datepicker({
								dateFormat: "yy-mm-dd",
								minDate: 0,
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
					} else{
						$('#input_aprobacion_cliente').html('');
					}
				});

				$('#rayado').on('click',function(){
					if($(this).is(':checked')){
							$('#input_rayado').html('<label >Envío de rayado</label> <input type="text" class="form-control "  name="fecha_rayado" id="fecha_rayado" required>');
							$('#fecha_rayado').datepicker({
								dateFormat: "yy-mm-dd",
								minDate: 0,
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
					} else{
						$('#input_rayado').html('');
					}
				});
				$('#chk_subtitulos').on('click',function(){
					if($(this).is(':checked')){
							$('#input_subtitulos_create').html('<label >Fecha subtitulo</label> <input type="text" class="form-control "  name="fecha_subtitulos_create" id="fecha_subtitulos" required readonly=true>');
							$('#fecha_subtitulos').datepicker({
								dateFormat: "yy-mm-dd",
								minDate: 0,
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
					} else{
						$('#fecha_subtitulos').html('');
					}
				});
				$('#form_agregar_traductor').on('submit', function(event){
					event.preventDefault();
					$.ajax({
						url: "{{ url('/mgepisodios/add-traductor') }}",
						type: "POST",
						data: $(this).serialize(),
						success: function(data){
							location.reload();
						},
						error: function(error){
							console.log(error)
							if(error.responseJSON.validator.length > 0){
								var err = "";
								for(var i in error.responseJSON.validator){
									err += error.responseJSON.validator[i] + "<br>";
								}
								$('#error_agregar_traductor').html('<div class="alert alert-danger">' + err + '</div>');
							}
						}
					});
				});

			});


			/*
			* Ventana modal para modificar traductor
			*/
			$('#modal_update_traductor').on('shown.bs.modal', function (e) {
				$('.check').prop("checked", false);
				var id = $(e.relatedTarget).data().id;
				$('input[name=id]').val(id);
				$(".loader").fadeIn();
				$.ajax({
						url: "{{ url('/mgepisodios/edit') }}"+"/"+id,
						type: 'GET',
						success: function(resp){
							$(".loader").fadeOut("slow");
							$('select[name=traductor]').val(resp.data['0'].traductorId);
							$('input[name=script_original]').val(resp.data['0'].script_original);
							$('input[name=fecha_entrega_traductor]').val(resp.data['0'].fecha_entrega_traductor);
							$('input[name=fecha_entrega_traductor]').val(resp.data['0'].fecha_entrega_traductor);
							if(resp.data['0'].chk_canciones == true){
								$('input[name=chk_canciones]').prop('checked', true)
							}
							if(resp.data['0'].chk_subtitulos == true){
								$('input[name=chk_subtitulos]').prop('checked', true)
								$('#input_subtitulos_update').html('<label >Fecha subtitulo</label> <input type="text" class="form-control "  name="fecha_subtitulo_update" id="fecha_subtitulo_update" value="'+resp.data['0'].send_date_subtitle_transfer+'" readonly=true required>');
								$('input[name=fecha_subtitulo_update]').datepicker({
									dateFormat: "yy-mm-dd",
									minDate: 0,
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
							}
							if(resp.data['0'].chk_lenguaje_diferente_original == true){
								$('input[name=chk_lenguaje_diferente_original]').prop('checked', true)
							}
							if(resp.data['0'].aprobacion_cliente == true){
								$('input[name=aprobacion_cliente]').prop('checked',true);
							}
							if(resp.data['0'].sin_script == true){
								$('input[name=sin_script]').prop('checked',true);
							}
							if(resp.data['0'].rayado == true){
								$('input[name=rayado]').prop('checked',true);

								$('#input_rayado2').html('<label >Envío de rayado</label> <input type="text" class="form-control "  name="fecha_rayado" id="fecha_rayado" value="'+resp.data['0'].fecha_rayado+'" readonly=true required>');
								$('#fecha_rayado').datepicker({
									dateFormat: "yy-mm-dd",
									minDate: 0,
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
							}


							if(resp.data['0'].rayado == true){
								$('input[name=rayado]').prop('checked',true);

								$('#input_rayado2').html('<label >Envío de rayado</label> <input type="text" class="form-control "  name="fecha_rayado" id="fecha_rayado" value="'+resp.data['0'].fecha_rayado+'" readonly=true required>');
								$('#fecha_rayado').datepicker({
									dateFormat: "yy-mm-dd",
									minDate: 0,
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
							}
							$('.selectpicker').selectpicker('refresh');

							if(data.aprobacion_cliente == true){
								$('#input_aprobacion2_cliente').html('<label for="titulo_espanol">Fecha aprobación del cliente</label> <input type="text" class="form-control"  name="fecha_aprobacion_cliente" id="fecha_aprobacion_cliente" value="'+data.fecha_aprobacion_cliente+'" required>');
								$('#fecha_aprobacion_cliente').datepicker({
									dateFormat: "yy-mm-dd",
									minDate: 0,
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
							}

							$('#form_actualizar_traductor').on('submit', function(event){
								event.preventDefault();
								$.ajax({
									url: "{{ url('/mgepisodios/add-traductor') }}",
									type: "POST",
									data: $(this).serialize(),
									success: function(data){
										location.reload();
									},
									error: function(error){
										console.log(error)
										if(error.responseJSON.validator.length > 0){
											var err = "";
											for(var i in error.responseJSON.validator){
												err += error.responseJSON.validator[i] + "<br>";
											}
											$('#error_agregar_traductor').html('<div class="alert alert-danger">' + err + '</div>');
										}
									}
								});
							});
						}
				});

			});

			//Calendarios
				$('input[name=entrega_episodio], input[name=entrega_me], input[name=fecha_entrega_traductor], input[name=fecha_doblaje]').datepicker({
					dateFormat: "yy-mm-dd",
					minDate: 0,
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

			//Permite mostrar input para insertar el idioma del episodio

            /*if( $('#doblaje_espanol20').click(':checked') ){

            };*/

            $('#duracion_material, #duracion, #duracion_update').mask('00:00:00:00');
            $('#tipo_reporte').multiselect();
            $('#tipo_reporte').on('change', function(){

            	var tipo_reporte = $(this).val();
            	reporte= tipo_reporte.join(",");
            	$('#reporte').val(reporte);
            });

         });

	</script>

@stop