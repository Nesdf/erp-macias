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
									<th>Configuración</th>
									<th>Número de episodio</th>
									@if(\Request::session()->has('show_fecha_entrega'))
										<th>Fecha de entrega episodio</th>
									@endif
									@if(\Request::session()->has('add_calificar_material'))
										<th>Calificar Episodio</th>
									@endif
									@if(\Request::session()->has('show_episodio') || \Request::session()->has('edit_episodio') || \Request::session()->has('delete_episodio'))
										<th></th>
									@endif
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
										<td>
											@php
												$arraymax =[];
												$episodio->bw;

												if($episodio->bw == true){
													$arraymax = ['BW' => $episodio->date_bw];
												}
												if($episodio->netcut == true){
													$arraymax = ['NetCut' => $episodio->date_netcut];
												}
												if($episodio->lockcut == true){
													$arraymax = ['Lockcut' => $episodio->date_lockcut];
												}
												if($episodio->final == true){
													$arraymax = ['Final' => $episodio->date_final];
												}
												if( count($arraymax) > 0 ){
													$max = array_search(max($arraymax), $arraymax);
											    }else{
											    	$max = "Sin configuración";
												}
												

											@endphp
											{{$max}}
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
													@if(\Request::session()->has('show_calificar_material'))
															<a href=" {{ url('mgepisodios/material-calificado/') . '/'. $episodio->id .'/'. $proyecto->id}} " title="Calificar Episodio">
															<span class="label label-success arrowed-in arrowed-in-right"> Calificado </span>
														</a>
													@endif
												@endif
											
											</td>
										@endif
										<td>
											@if(is_null($episodio->quien_modifico_productor))
												<a data-toggle="modal" data-target="#modal_create_productor" data-id="{{ $episodio->id }}" class="btn btn-xs btn-primary" title="Productor">
														<i class="glyphicon glyphicon-film "></i>
												</a>
											@endif

											@if(is_null($episodio->quien_modifico_traductor))
												<a data-toggle="modal" data-target="#modal_create_traductor" data-id="{{ $episodio->id }}" class="btn btn-xs btn-primary" title="Traductor">
														<i class="glyphicon glyphicon-indent-right"></i>
												</a>
											@endif
											
											
											<a data-toggle="modal" data-target="#modal_update_configuracion" data-id="{{ $episodio->id }}" class="btn btn-xs btn-warning " title="Configuracion">
														<i class="ace-icon fa fa-tv bigger-120"></i>
											</a>
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
					<label for="exampleInputEmail1">Título Original del episodio</label>
					<input type="text" class="form-control" id="titulo_original_episodio" name="titulo_original_episodio" placeholder="Título Original del episodio">
				</div>	
				<div class="form-group">
					<label for="configuracion">Configuración</label>
					<textarea id="configuracion" name="configuracion" class="form-control"></textarea>
				</div>	
				<div class="form-group">
					<label for="exampleInputEmail1">Número de Episodio</label>
					<input type="text" class="form-control" id="num_episodio" name="num_episodio" placeholder="Número de episodio">
				</div>
				<div>
					<table class="table">
				  		<tr>
				  			<td><input type="checkbox" name="bw"><label> &nbsp; BW</label></td>
				  			<td><input type="checkbox" name="netcut"><label> &nbsp; NetCut</label></td>
				  			<td><input type="checkbox" name="lockcut"><label> &nbsp; LockCut</label></td>
				  			<td><input type="checkbox" name="final"><label> &nbsp; Final</label></td>
				  		</tr>
				  	</table>
				</div>
				@if( $proyecto->m_and_e == true )
				<div class="form-group">
					<label for="exampleInputEmail1">Fecha de entrega M&E</label>
					<input type="text" class="form-control" id="entrega_me" name="entrega_me" readonly="true" placeholder="Fecha de entrega M&E">
				</div>
				@endif
				<div class="form-group">
					<label for="entrega_episodio">Fecha de entrega del Episodio</label>
					<input type="text" class="form-control" id="entrega_episodio" name="entrega_episodio" readonly="true" placeholder="Fecha de entrega del Episodio">
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
				<label>Fecha Doblaje</label>
				<input type="" name="fecha_doblaje" id="fecha_doblaje" class="form-control" required>
				<br>
				<div id="add_date_script"></div>
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
					<input type="checkbox" name="aprobacion_cliente" id="aprobacion_cliente" > Aprobación del cliente
					</label><br>
					<div id="input_aprobacion_cliente"></div>
					<label>
					<input type="checkbox" name="sin_script" id="sin_script" > Sin script
					</label><br>
					<label>
					<input type="checkbox" name="rayado" id="rayado" > Rayado
					</label><br>
					<div id="input_rayado"></div>
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
					<div class="modal-body">
					{{ csrf_field() }}
				<input type="hidden" name="id" id="id_update">		
				<input type="hidden" name="proyectoId" value="{{ $proyecto_id }}">
				<table class="table table-striped ">
					<tr>
						<td>
							<input type="checkbox"  id="bw_update" name="bw"> BW
						</td>
						<td>
							<input type="checkbox"  id="netcut_update" name="netcut"> NetCut
						</td>
						<td>
							<input type="checkbox"  id="lockcut_update" name="lockcut"> LockCut
						</td>
						<td>
							<input type="checkbox"  id="final_update" name="final"> Final
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
					<div class="modal-body">
					{{ csrf_field() }}
					<input type="hidden" name="id" id="id_episodio_update">		
				<input type="hidden" name="proyectoId" value="{{ $proyecto_id }}">
				<div class="form-group">
					<label for="exampleInputEmail1">Seleccionar Productor</label>
					<select class="form-control" id="productor_update" name="productor">
						<option value="">Seleccionar</option>
						@foreach($productores as $productor)
							<option value="{{ $productor->id }}"> {{ $productor->name }} {{ $productor->ap_paterno }} {{ ($productor->ap_materno )}} </option>
						@endforeach
					</select>
				</div>
				<div class="form-group">
					<label for="exampleInputEmail1">Seleccionar Responsable</label>
					<select class="form-control" id="responsable_update" name="responsable">
						<option value="">Seleccionar</option>
						@foreach($responsables as $responsable)
							<option value="{{ $responsable->id }}"> {{ $responsable->name }} {{ $responsable->ap_paterno }} {{ ($responsable->ap_materno )}} </option>
						@endforeach
					</select>
				</div>
				<div class="form-group">
					<label for="exampleInputEmail1">Título Original del episodio</label>
					<input type="text" class="form-control" id="titulo_original_episodio_update" name="titulo_original_episodio" placeholder="Título Original del episodio">
				</div>
				<div class="form-group">
					<label for="configuracion">Configuración</label>
					<textarea id="configuracion_update" name="configuracion" class="form-control"></textarea>
				</div>	
				<div class="form-group">
					<label for="exampleInputEmail1">Seleccionar Sala</label>
					<select class="form-control" id="sala_update" name="sala">
						<option value="">Seleccionar</option>
						@foreach($salas as $sala)
							<option value="{{ $sala->id }}"> {{ $sala->sala }} </option>
						@endforeach
					</select>
				</div>		
				<div class="form-group">
					<label for="exampleInputEmail1">Número de Episodio</label>
					<input type="text" class="form-control" id="num_episodio_update" name="num_episodio" placeholder="Número de episodio">
				</div>
				@if( $proyecto->m_and_e == true )
				<div class="form-group">
					<label for="exampleInputEmail1">Fecha de entrega M&E</label>
					<input type="text" class="form-control" id="entrega_me_update" name="entrega_me" readonly="true" placeholder="Fecha de entrega M&E">
				</div>
				@endif
				<div class="form-group">
					<label for="entrega_episodio">Fecha de entrega del Episodio</label>
					<input type="text" class="form-control" id="entrega_episodio_update" name="entrega_episodio" readonly="true" placeholder="Fecha de entrega del Episodio">
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
			  <form id="form_delete_episodio" method="GET" action="{{ url('mgepisodios/delete/') }}">
				  <img src="{{ asset('assets/dashboard/images/error/peligro.png') }}">
				  {{ csrf_field() }}
				  <div id="inputs"></div>
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
				<h4 class="modal-title " id="myModalLabel">Consulta Episodio</h4>
			  </div>
			  <div class="modal-body">
			  	@if(\Request::session()->has('show_fecha_entrega'))
			  		<div id="alerta_fecha"> </div>
			  	@endif
			  	<div class="row">
			  		<div class="col-md-6">
			  			<table class="table">
					  		<tr>
					  			<th><h4>Responsable:</h4> <span id="responsable_show"></span></th>
					  		</tr>
					  		<tr>
					  			<th><h4>Productor:</h4> <span id="productor_show"></span></th>
					  		</tr>
					  		<tr>
					  			<th><h4>Título Original del episodio: </h4><span id="titulo_original_show"></span></th> 
					  		</tr>
					  		<tr>
					  			@if(\Request::session()->has('show_fecha_entrega'))
					  				<th><h4>Fecha de entrega episodio</h4> <span id="fecha_entrega_show"></span></th>
					  			@endif
					  		</tr>
					  	</table>
			  		</div>
			  		<div class="col-md-6">
			  			<table class="table">			  				
					  		<tr>
					  			<th><h4>Número de Episodio:</h4> <span id="num_episodio_show"></span></th>
					  		</tr>
					  		<tr>
					  			<th><h4>Sala:</h4> <span id="sala_show"></span></th>
					  		</tr>	
					  		@if( $proyecto->m_and_e == true )	
						  		<tr>					  			
						  			<th><h4>Fecha de entrega M&E</h4> <span id="date_m_and_e_show"></span></th>
						  		</tr>
						  	@endif
					  		<tr>
					  			<th><h4>Configuración</h4><span id="configuracion_show"></span></th>
					  		</tr>
					  	</table>
			  		</div>
			  	</div>
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
						<select class="form-control" id="sala" name="sala" id="sala">
							<option value="">Seleccionar</option>
							@foreach($salas as $sala)
								<option value="{{ $sala->id }}"> {{ $sala->sala }} </option>
							@endforeach
						</select>
					</div>	
					<div class="form-group">
						<label for="traductor">Asignar Traductor</label>
						<select name="traductor" class="form-control">
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
			
			$('.update_id').on('click', function(){
				 id = $( this ).data('id');				
				$.ajax({
					url: "{{ url('mgepisodios/edit') }}" + "/" + id,
					type: "GET",
					success: function( data ){
						$('#id_episodio_update').val(data.id);
						$('#titulo_original_episodio_update').val(data.titulo_original);
						$('#duracion_update').val(data.duracion);
						$('#folio_update').val(data.folio);
						$('#num_episodio_update').val(data.num_episodio);
						$('#configuracion_update').val(data.configuracion);
						$('#observaciones_update').val(data.observaciones);
						$('#entrega_episodio_update').val(data.date_entrega);
						$("#responsable_update option[value="+ data.responsable +"]").attr("selected",true);
						$("#productor_update option[value="+ data.productor +"]").attr("selected",true);
						$('#entrega_me_update').val(data.date_m_and_e);
						$('#entrega_episodio_update').val(data.date_entrega);
						$("#sala_update option[value="+ data.salaId +"]").attr("selected",true);
						
						
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
			
			$('.delete_id').on('click', function(){
				 id = $( this ).data('id');
				  $('#form_delete_episodio').attr('action', '{{ url("mgepisodios/delete") }}/' + id + '/' + {{$proyecto->id}} );
			 });

			$('.coordinador').on('click', function(){
				 id = $( this ).data('id');
				 $('#episodioId').val(id);
			 });
			
			$('#form_create_episodio').on('submit', function(event){
				event.preventDefault();
				$.ajax({
					url: "{{ url('mgepisodios/save') }}",
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
						$('#error_create_episodio').html('<div class="alert alert-danger">' + err + '</div>');
					}
				});
			});

			$('#form_add_traductor').on('submit', function(event){
				event.preventDefault();
				$.ajax({
					url: "{{ url('mgepisodios/assign-traductor') }}",
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
						$('#error_add_traductor').html('<div class="alert alert-danger">' + err + '</div>');
					}
				});
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

			/*$('.edit_configuracion').on('click', function(){
				id = $( this ).data('id');
				$.ajax({
					url: "{{-- url('mgepisodios/edit') --}}" + "/" + id,
					type: "GET",
					success: function( data ){
						$('#id_update').val(data.id);
						
						if(data.bw == true){
							$('#bw_update').prop( "checked", true ).attr( "disabled", true ).removeAttr('name');
						} else {
							$('#bw_update').prop( "checked", false ).attr( "disabled", false ).attr('name', 'bw');
						}
						if(data.lockcut == true){
							$('#lockcut_update').prop( "checked", true ).attr( "disabled", true ).removeAttr('lockcut');
						} else {
						if(data.netcut == true){
							$('#netcut_update').prop( "checked", true ).attr( "disabled", true ).removeAttr('name');
						}							$('#bw_update').prop( "checked", false ).attr( "disabled", false ).attr('name', 'netcut');
						if(data.final == true){
							$('#final_update').prop( "checked", true ).attr( "disabled", true ).removeAttr('final');
						}						}
					},
					error: function(error){
						var err = "";
						for(var i in error.responseJSON.msg){
							err += error.responseJSON.msg[i] + "<br>";														
						}
						$('#error_update_episodios').html('<div class="alert alert-danger">' + err + '</div>');
					}
				});
			 });*/

			/*$('#form_update_configuracion').on('submit', function(event){
				event.preventDefault();
				$.ajax({
					url: "{{-- url('mgepisodios/update-configuracion') --}}",
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
			});*/

			/*
			* Modal para actualizar la configuración 
			* BW, NetCut, LockCut y Final
			*/
			$('#modal_update_configuracion').on('shown.bs.modal', function(e){
				var id = $(e.relatedTarget).data().id;

				$.ajax({
					url: "{{ url('mgepisodios/edit') }}" + "/" + id,
					type: "GET",
					success: function( data ){
						
						//BW
						if(data.bw == true){
							$('#bw_update').prop( "checked", true ).attr( "disabled", true ).removeAttr('name');
						} else {
							$('#bw_update').prop( "checked", false ).attr( "disabled", false ).attr('name', 'bw');
						}

						//LOCKOUT
						if(data.lockcut == true){
							$('#lockcut_update').prop( "checked", true ).attr( "disabled", true ).removeAttr('name');
						} else {
							$('#lockcut_update').prop( "checked", false ).attr( "disabled", false ).attr('name', 'lockcut');
						}

						//NETCUT
						if(data.netcut == true){
							$('#netcut_update').prop( "checked", true ).attr( "disabled", true ).removeAttr('name');
						} else {
							$('#netcut_update').prop( "checked", false ).attr( "disabled", false ).attr('name', 'netcut');
						}

						//FINAL
						if(data.final == true){
							$('#final_update').prop( "checked", true ).attr( "disabled", true ).removeAttr('name');
						} else {
							$('#final_update').prop( "checked", false ).attr( "disabled", false ).attr('name', 'FINAL');
						}
					}
				});
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

			
			$('.show_id').on('click', function(){
				 id = $( this ).data('id');				
				$.ajax({
					url: "{{ url('mgepisodios/show_episodio') }}" + "/" + id,
					type: "GET",
					success: function( data ){
						$('#titulo_original_show').html(data.msg[0].titulo_original);
						$('#titulo_espanol_show').html(data.msg[0].titulo_espanol);
						$('#duracion_show').html(data.msg[0].duracion);
						$('#num_episodio_show').html(data.msg[0].num_episodio);
						$('#responsable_show').html(data.msg[0].responsable + ' '+ data.msg[0].responsable_ap_paterno + ' ' + data.msg[0].responsable_ap_materno);
						$('#productor_show').html(data.msg[0].productor + ' '+ data.msg[0].productor_ap_paterno + ' ' + data.msg[0].productor_ap_materno);
						$('#date_m_and_e_show').html(data.msg[0].date_m_and_e);
						$('#sala_show').html(data.msg[0].salaId);
						$('#folio_show').html(data.msg[0].folio);
						$('#fecha_entrega_show').html("<span class='label label-"+ data.status_entrega + " '> " + data.msg[0].date_entrega + "</span>");
						$('#alerta_fecha').html("<div class='alert alert-" + data.status_entrega + "'> <h2>Fecha de entrega:  "+ data.msg[0].date_entrega +"</h2></div>");
						//$('#configuracion_show').html();
						
						
					}
				});
			 });

			//Ventana modal par asignar Productor
			$('#modal_create_productor').on('show.bs.modal', function(e){
				var id = $(e.relatedTarget).data().id;
				$('#id').val(id);
				$.ajax({
					url: '{{ url('/mgepisodios/edit') }}'+'/'+id,
					type: 'GET',
					success: function(data){
						console.log(data.sin_script)
						if(data.sin_script == false){
							$('#add_date_script').html('<label>Fecha de script</label><input type="text" id="fecha_script" name="fecha_script" class="form-control" required></input>');

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

			//Ventana modal par asignar traductor
			$('#modal_create_traductor').on('shown.bs.modal', function (e) {
				var id = $(e.relatedTarget).data().id;
				$('#id_episodio').val(id);
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
							$('#input_rayado').html('<label >Fecha de rayado</label> <input type="text" class="form-control "  name="fecha_rayado" id="fecha_rayado" readonly required>');
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

			

			//Calendarios
				$('#entrega_episodio, #entrega_episodio_update, #entrega_me, #fecha_entrega_traductor, #fecha_doblaje, fecha_entrega_traductor').datepicker({
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