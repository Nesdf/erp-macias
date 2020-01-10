@extends('layouts.app')

@section('guia')
	<li>
		<i class="ace-icon fa fa-list"></i>
		<i>Elementos</i>
	</li>
	<li>
		<i class="ace-icon fa fa-history"></i>
		<a href="{{ url('mgprogramacionavances') }}">Programación y Avances</a>
	</li>
@stop

@section('content')
    <div class="row">
		<div class="col-xs-12">
			<!-- PAGE CONTENT BEGINS -->
			
			<div class="row">
				<div class="col-xs-12">
					<h3 class="header smaller lighter blue">Programación y avances de Macias Group</h3>

					@if(\Request::session()->has('success'))
							<div class="alert alert-success">{{ \Session::get('success') }}</div>
					@endif
					<div class="clearfix">
						<div class="pull-right tableTools-container"></div>
					</div>
					<div class="table-header"> Programación y Avances </div>

					<!-- div.table-responsive -->

					<!-- div.dataTables_borderWrap -->
					<div><br><br>
						<table id="table_puestos" class="stripe row-border ">
							<thead>
								<tr>
									<th>Fecha</th>
									<th>Cliente</th>
									<th>Proyecto</th>
                                    <th>Episodio</th>
                                    <th>Descarga</th>
                                    <th>Referencia de llegada</th>
                                    <th>Notificación a Producción y Pistas</th>
                                    <th>Envío a Sebastian</th>
                                    <th>OT</th>
                                    <th>Entrega Rayado</th>
                                    <th>Para QC de Daniel</th>
                                    <th>Fecha Cliente</th>
                                    <th>Productor(a)</th>
                                    <th>Director</th>
                                    <th>Sala</th>
                                    <th>Traductor</th>
                                    <th>Envío de MP4 a traductor</th>
                                    <th>Script Original</th>
                                    <th>Envío del rayado</th>
                                    <th>Subtítulos</th>
                                    <th>Envío de subtítulo a transfer</th>
                                    <th>Envío de subtítulos a Miami</th>
                                    <th>Fecha de embarque</th>
                                    <th>Título original del episodio</th>
                                    <th>Título LAS</th>
                                    <th>Título BPO</th>
                                    <th>Duración</th>
                                    <th>Enviado a</th>
                                    <th>Método de envío</th>
                                    <th>Tipo de trabajo</th>
                                    <th>Referencia e envío</th>
								</tr>
							</thead>

							<tbody>
                                @foreach($proyectos as $proyecto)
									<tr>
										<td> {{ $proyecto->proyecto_date }} </td>
										<td> {{ $proyecto->nombre_clientes }} </td>
                                        <td> {{ $proyecto->proyecto_titulo }} </td>
                                        <td> {{ $proyecto->num_episodio }}</td>
                                        <td> {{ $proyecto->date_download }} </td>
                                        <td> {{ $proyecto->reference_download }}</td>
                                        <td>@if($proyecto->notify_pistas) <span class="glyphicon glyphicon-ok text-success"></span> @else <span class="glyphicon glyphicon-remove text-danger"> @endif</td>
                                        <td>@if($proyecto->send_sebastians) <span class="glyphicon glyphicon-ok text-success"></span> @else <span class="glyphicon glyphicon-remove text-danger"> @endif</td>
                                        <td>@if($proyecto->ot) <span class="glyphicon glyphicon-ok text-success"></span> @else <span class="glyphicon glyphicon-remove text-danger"> @endif</td>
                                        <td>{{ $proyecto->fecha_entrega_rayado }}</td>
                                        <td>????{{ $proyecto->fecha_qc }}</td>
                                        <td>{{ $proyecto->fecha_entrega }}</td>
                                        <td>{{ $proyecto->productor }}</td>
                                        <td>{{ $proyecto->director }}</td>
                                        <td>{{ $proyecto->sala }}</td>
                                        <td>{{ $proyecto->traductor }}</td>
                                        <td>{{ $proyecto->envio_mp4 }}</td>
                                        <td>{{ $proyecto->script_original }}</td>
                                        <td>@if($proyecto->fecha_rayado) {{ $proyecto->fecha_rayado }} @else ------ @endif</td>
                                        <td>@if($proyecto->chk_subtitulos == true) <span class="glyphicon glyphicon-ok text-success"></span> @else <span class="glyphicon glyphicon-remove text-danger"> @endif</td>
                                        <td>@if($proyecto->send_date_subtitle_transfer)  {{$proyecto->send_date_subtitle_transfer}}  @else ---- @endif</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>@if($proyecto->las_or_lm)  {{$proyecto->las_or_lm}}  @else ---- @endif </td>
                                        <td>@if($proyecto->bpo_or_lm)  {{$proyecto->bpo_or_lm}}  @else ---- @endif </td>
                                        <td>@if($proyecto->duracion) {{$proyecto->duracion}} @else ------ @endif</td>
                                        <td>@if($proyecto->enviado_a) {{$proyecto->enviado_a}} @else ------ @endif</td>
                                        <td>@if($proyecto->metodo_envio) {{$proyecto->metodo_envio}} @else ------ @endif</td>
                                        <td>@if($proyecto->tipo_trabajo) {{$proyecto->tipo_trabajo}} @else ------ @endif </td>
                                        <td>@if($proyecto->referencia_envio) {{$proyecto->referencia_envio}} @else ------ @endif</td>
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
	
@stop

@section('script')
	<script>
		$(document).on('ready', function(){
            $('#table_puestos').DataTable({
                "scrollX": true,
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
		});
	</script>
@stop