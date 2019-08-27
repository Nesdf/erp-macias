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
					<h3 class="header smaller lighter blue"><b>Proyecto: </b>{{ $proyecto->titulo_original }} </h3>

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
									<th>Título en Español</th>
									<th>Título en Inglés</th>
									<th>Título en Portugués</th>
									<th>Número de episodio</th>
									<th>Validar información</th>
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
											{{ $episodio->titulo_espanol }}
										</td>
										<td>
											{{ $episodio->titulo_ingles }}
										</td>
										<td>
											{{ $episodio->titulo_portugues }}
										</td>
										<td>
											{{ $episodio->num_episodio }}
										</td>
										<td>
											<a href="#" class="label label-danger">Validar Episodio</a>
										</td>
										@if(\Request::session()->has('add_calificar_material'))
											<td>
												@if( $episodio->material_calificado != true )
													<a href="#" title="Calificar Episodio" data-toggle="modal" data-target="#modal_save_masterial_calificado">
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
											@if(\Request::session()->has('add_asignar_traductor'))
												<a data-toggle="modal" data-target="#modal_coordinador" data-id="{{ $episodio->id }}" class="btn btn-xs btn-primary coordinador" title="Coordinador">
														<i class="ace-icon fa fa-eye bigger-120"></i>
												</a>
											@endif
											@if(\Request::session()->has('show_episodio'))
												<a data-id="{{ $episodio->id }}" data-toggle="modal" data-target="#modal_ver_episodio" class="btn btn-xs btn-warning show_id" title="Editar">
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
					<label for="exampleInputEmail1">Seleccionar Productor</label>
					<select class="form-control" id="productor" name="productor">
						<option value="">Seleccionar</option>
						@if(count($productores) > 0)
							@foreach($productores as $productor)
								<option value="{{ $productor->id }} "> {{ $productor->name }} {{ $productor->ap_paterno }} {{ ($productor->ap_materno )}} </option>
							@endforeach
						@endif
					</select>
				</div>
				<div class="form-group">
					<label for="exampleInputEmail1">Seleccionar Responsable</label>
					<select class="form-control" id="responsable" name="responsable">
						<option value="">Seleccionar</option>
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
				<div id="input_titulo_espanol" class="form-group"></div>
				<div id="input_titulo_ingles" class="form-group"></div>
				<div id="input_titulo_portugues" class="form-group"></div>
				<div class="form-group">
					<label for="exampleInputEmail1">Duración</label>
					<input type="text" class="form-control" id="duracion" name="duracion" placeholder="Duración">
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
					<label for="exampleInputEmail1">Seleccionar Sala</label>
					<select class="form-control" id="sala" name="sala">
						<option value="">Seleccionar</option>
						@foreach($salas as $sala)
							<option value="{{ $sala->id }}"> {{ $sala->sala }} </option>
						@endforeach
					</select>
				</div>	
				<div class="form-group">
					<label for="exampleInputEmail1">Número de Episodio</label>
					<input type="text" class="form-control" id="num_episodio" name="num_episodio" placeholder="Número de episodio">
				</div>
				
				<div class="form-group">
					<label for="exampleInputEmail1">Observaciones</label>
					<textarea class="form-control" id="observaciones" name="observaciones"></textarea>
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
								<input type="checkbox" id="doblaje_inglesl20" name="doblaje_inglesl20">
									<label for="doblaje_inglesl20">Doblaje Inglés 2.0</label>
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
					<input type="hidden" name="id" id="id_update">		
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

					<!--  -->
						<div id="titulo_espanol_update" class="form-group">
							<label for="exampleInputEmail1">Título del Episodio en Español</label>
							<input type="text" class="form-control" name="titulo_episodio_espanol" id="input_titulo_espanol_update" placeholder="Título del Episodio en Español">
						</div>
						<div id="titulo_ingles_update" class="form-group">
							<label for="exampleInputEmail1">Título del Episodio en Inglés</label>
							<input type="text" class="form-control" id="titulo_episodio_ingles_update" name="titulo_episodio_ingles" placeholder="Título del Episodio en Inglés">
						</div>
						<div id="titulo_portugues_update" class="form-group">
							<label for="titulo_episodio_ingles">Título del Episodio en Portugués</label>
							<input type="text" class="form-control" name="titulo_episodio_portugues"  id="input_titulo_portugues_update" placeholder="Título del Episodio en Portugués">
						</div>

					<!-- -->
				</div>
				
				
				
				<div class="form-group">
					<label for="exampleInputEmail1">Duración</label>
					<input type="text" class="form-control" id="duracion_update" name="duracion" placeholder="Duración">
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
				
				<div class="form-group">
					<label for="exampleInputEmail1">Observaciones</label>
					<textarea class="form-control" id="observaciones_update" name="observaciones">					
					</textarea>
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
					  			<th><h4>Título del episodio en español: </h4> <span id="titulo_espanol_show"></span></th>  			
					  		</tr>
					  		<tr>
					  			<th><h4>Duración</h4> <span id="duracion_show"></span></th>
					  		</tr>
					  		<tr>
					  			<th><h4>Vìa:</h4> <span id="viaId_show"></span></th>
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
					  		<tr>
					  			<th><h4>Observaciones</h4> <span id="observaciones_show"></span></th>					  			
					  		</tr>
					  		<tr>					  			
					  			<th><h4>Fecha de entrega M&E</h4> <span id="date_m_and_e_show"></span></th>
					  		</tr>
					  		<tr>
					  			@if(\Request::session()->has('show_fecha_entrega'))
					  				<th><h4>Fecha de entrega episodio</h4> <span id="fecha_entrega_show"></span></th>
					  			@endif
					  		</tr>
					  		<tr>
					  			<th><h4>Doblaje</h4> <span id="doblaje_show"></span></th>
					  		</tr>
					  		<tr>
					  			<th><h4>Subtitulaje</h4> <span id=subtitulaje_show></span></th>
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
		<div class="modal fade" id="modal_save_masterial_calificado" data-name="modal" tabindex="-1" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="myModalLabel">
		  <div class="modal-dialog" role="document">
			<div class="modal-content">
			  <div class="modal-header">
				<!--<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>-->
				<h4 class="modal-title" id="t_header">Calificar Material</h4>
				<div id="error_create_episodio"></div>
			  </div>
			  <form role="form" id="form_create_calificar_material">
				  <div class="modal-body">
						{{ csrf_field() }}		

					<div class="form-group">
					@if( !empty($episodio->id) )
					<input type="hidden" name="id_episodio" value="{{ $episodio->id }}">
						<input type="text" class="form-control" id="correo_activo"  name="correo_activo" readonly="true" value="{{ Auth::user()->email }}">
					</div>
					@endif
					<div class="form-group">
						<label for="duracion">Duración</label>
						<input type="text" class="form-control" id="duracion" name="duracion" placeholder="Duración" data_mask="hho">
					</div>
					<div class="form-group">
						<label for="tipo_reporte">Tipo de reporte</label>
						<input type="text" class="form-control" id="tipo_reporte" name="tipo_reporte" placeholder="Tipo de reporte">
					</div>
					<div class="form-group">
						<label for="mezcla">Mezcla</label>
						<select name="mezcla" class="form-control">
							<option>Seleccionar ...</option>
							<option value="Mono">Mono</option>
							<option value="Stereo">Stereo</option>
							<option value="5.1">5.1</option>
							<option value="7.1">7.1</option>
						</select>
					</div>
					<div class="form-group">
						<label for="tipo_reporte">Tcr</label>
						<select class="form-control" name="tcr">
							<option>Seleccionar TCR...</option>
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
						<label for="traductor">Asignar Traductor</label>
						<select name="traductor" class="form-control">
							<option value="">Seleccionar...</option>
							@foreach($traductores as $traductor)
								<option value="{{$traductor->id}}">{{$traductor->name}} {{$traductor->ap_paterno}} {{$traductor->ap_materno}}</option>
							@endforeach
						</select>
					</div>					
					<input type="checkbox" id="script" name="script">
					<label>Con Script</label>
					<input type="hidden" name="episodioId" id="episodioId" >
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
						$('#id_update').val(data.id);
						$('#titulo_original_episodio_update').val(data.titulo_original);
						$('#duracion_update').val(data.duracion);
						$('#num_episodio_update').val(data.num_episodio);
						$('#observaciones_update').val(data.observaciones);
						$('#entrega_episodio_update').val(data.date_entrega);
						$("#responsable_update option[value="+ data.responsable +"]").attr("selected",true);
						$("#productor_update option[value="+ data.productor +"]").attr("selected",true);
						$('#entrega_me_update').val(data.date_m_and_e_update);
						$("#via_update option[value="+ data.viaId +"]").attr("selected",true);
						$("#sala_update option[value="+ data.salaId +"]").attr("selected",true);
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
						$('#error_update_episodios').html('<div class="alert alert-danger">' + err + '</div>');
					}
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
						$('#viaId_show').html(data.msg[0].viaId);
						$('#sala_show').html(data.msg[0].salaId);
						$('#observaciones_show').html(data.msg[0].observaciones);
						$('#fecha_entrega_show').html("<span class='label label-"+ data.status_entrega + " '> " + data.msg[0].date_entrega + "</span>");
						$('#alerta_fecha').html("<div class='alert alert-" + data.status_entrega + "'> <h2>Fecha de entrega:  "+ data.msg[0].date_entrega +"</h2></div>");

						var doblaje = "";
						if(data.msg[0].dobl_espano20 == true){
							doblaje +=  "Español 2.0 ";
						}
						if(data.msg[0].dobl_espano51 == true){
							doblaje +=  "Español 5.1 ";
						}
						if(data.msg[0].dobl_espano71 == true){
							doblaje +=  "Español 7.1 ";
						}
						if(data.msg[0].dobl_ingles20 == true){
							doblaje +=  "Inglés 2.0";
						}
						if(data.msg[0].dobl_ingles51 == true){
							doblaje +=  "Inglés 5.1 ";
						}
						if(data.msg[0].dobl_ingles71 == true){
							doblaje +=  "Inglés 7.1 ";
						}
						if(data.msg[0].dobl_portugues20 == true){
							doblaje +=  "Portugues 2.0 ";
						}
						if(data.msg[0].dobl_portugues51 == true){
							doblaje +=  "Portugues 5.1 ";
						}
						if(data.msg[0].dobl_portugues71 == true){
							doblaje +=  "Portugues 7.1 ";
						}
						
						$('#doblaje_show').html(doblaje);

						var subtitulaje = "";
						if(data.msg[0].subt_espanol == true){
							subtitulaje +=  "Español ";
						}
						if(data.msg[0].subt_ingles == true){
							subtitulaje +=  "Inglés ";
						}
						if(data.msg[0].subt_portugues == true){
							subtitulaje +=  "Portugues ";
						}
						
						$('#subtitulaje_show').html(subtitulaje);
					}
				});
			 });

			//Calendarios
				$('#entrega_episodio, #entrega_episodio_update, #entrega_me, #fecha_entrega_traductor').datepicker({
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
				console.log('click');
            };*/


            //Sección de inputs para crear
            $('#doblaje_espanol20, #doblaje_espanol51, #doblaje_espanol71').on('click', function(){
            	if($('#doblaje_espanol20, #doblaje_espanol51, #doblaje_espanol71').is(':checked')){
            		 $('#input_titulo_espanol').html('<label for="titulo_episodio_espanol">Título del Episodio en Español</label> <input type="text" class="form-control" id="titulo_episodio_espanol" name="titulo_episodio_espanol" placeholder="Título del Episodio en Español">');
            	} else{
            		$('#input_titulo_espanol').html('');
            	}
            });

            $('#doblaje_ingles20, #doblaje_ingles51, #doblaje_ingles71').on('click', function(){
            	if($('#doblaje_ingles20, #doblaje_ingles51, #doblaje_ingles71').is(':checked')){
            		 $('#input_titulo_ingles').html('<label for="titulo_episodio_ingles">Título del Episodio en Inglés</label> <input type="text" class="form-control" id="titulo_episodio_ingles" name="titulo_episodio_ingles" placeholder="Título del Episodio en Inglés">');
            	} else{
            		$('#input_titulo_ingles').html('');
            	}
            });

            $('#doblaje_portugues20, #doblaje_portugues51, #doblaje_portugues71').on('click', function(){
            	if($('#doblaje_portugues20, #doblaje_portugues51, #doblaje_portugues71').is(':checked')){
            		 $('#input_titulo_portugues').html('<label for="titulo_episodio_portugues">Título del Episodio en Portugués</label> <input type="text" class="form-control" id="titulo_episodio_portugues" name="titulo_episodio_portugues" placeholder="Título del Episodio en Portugués">');
            	} else{
            		$('#input_titulo_portugues').html('');
            	}
            });

            //Sección para update
            $('#doblaje_espanol20_update, #doblaje_espanol51_update, #doblaje_espanol71_update').on('click', function(){
            	if($('#doblaje_espanol20_update, #doblaje_espanol51_update, #doblaje_espanol71_update').is(':checked')){
            		 $('#titulo_espanol_update').html('<label for="titulo_episodio_espanol">Título del Episodio en Español</label> <input type="text" class="form-control" id="titulo_episodio_espanol" name="titulo_episodio_espanol" placeholder="Título del Episodio en Español" required>');
            	} else{
            		$('#titulo_espanol_update').html('');
            	}
            });

            $('#doblaje_ingles20_update, #doblaje_ingles51_update, #doblaje_ingles71_update').on('click', function(){
            	if($('#doblaje_ingles20_update, #doblaje_ingles51_update, #doblaje_ingles71_update').is(':checked')){
            		 $('#titulo_ingles_update').html('<label for="titulo_episodio_espanol">Título del Episodio en Inglés</label> <input type="text" class="form-control"  name="titulo_episodio_ingles" placeholder="Título del Episodio en Inglés" required>');
            	} else{
            		$('#titulo_ingles_update').html('');
            	}
            });

            $('#doblaje_portugues20_update, #doblaje_portugues51_update, #doblaje_portugues71_update').on('click', function(){
            	if($('#doblaje_portugues20_update, #doblaje_portugues51_update, #doblaje_portugues71_update').is(':checked')){
            		 $('#titulo_portugues_update').html('<label for="titulo_episodio_portugues">Título del Episodio en Portugués</label> <input type="text" class="form-control"  name="titulo_episodio_portugues" placeholder="Título del Episodio en Portugués" required>');
            	} else{
            		$('#titulo_portugues_update').html('');
            	}
            });

            $('#duracion_material, #duracion, #duracion_update').mask('00:00:00:00');
		});
	</script>
@stop