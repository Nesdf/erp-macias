@extends('layouts.app')

@section('guia')
	<li>
		<i class="ace-icon fa fa-video-camera"></i>
		<a href="{{ route('trafico') }}">Tráfico</a>
	</li>
@stop

@section('content')
    <div class="row">
		<div class="col-xs-12">
			<!-- PAGE CONTENT BEGINS -->
			
			<div class="row">
				<div class="col-xs-12">
					<h3 class="header smaller lighter blue center">Tráfico </h3>

					<div class="clearfix">
						<div class="pull-right tableTools-container"></div>
					</div>
					<div class="table-header">
						<br>
					</div>

					<!-- div.table-responsive -->

					<!-- div.dataTables_borderWrap -->
					<div> <br><br>
						<table id="table_episodios" class="stripe row-border">
							<thead>
								<tr>
									<th>ID</th>
									<th>Nombre del proyecto</th>
									<th>Cliente</th>
									<th>Temporada</th>
									<th>Título original del episodio inglés</th>
									<th>Fecha entrega</th>
									<th>Duración</th>
									@if(\Request::session()->has('add_calificar_material'))
										<th>Calificar Episodio</th>
									@endif
									@if(\Request::session()->has('show_episodio') || \Request::session()->has('edit_episodio') || \Request::session()->has('delete_episodio'))
										<th></th>
									@endif
								</tr>
							</thead>

							<tbody>
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
			
		});
	</script>
@stop