@extends('layouts.app')

@section('guia')
	<li>
		<i class="menu-icon fa fa-bank"></i>
		<a href="{{ url('mgcontabilidad/reporte-proyectos') }}">Detalle nómina de actores2</a>
	</li>
@stop

@section('content')
    <div class="row">
		<div class="col-xs-12">
			<!-- PAGE CONTENT BEGINS -->

			<div class="row">
				<div class="col-xs-12">
					<h3 class="header smaller lighter blue">Detalle nómina de actores</h3>

						<table id="table_detalle" class="table table-striped table-bordered table-hover">\
						<thead>
							<tr>
							<th>Actor</th>
								<th>Proyecto</th>
								<th>Episodio</th>
								<th>Personaje</th>
								<th>Loops</th>
								<th>Entrada</th>
								<th>Importe</th>
							</tr>
						</thead>
						<tbody>
							@foreach($llamadoByActor as $item)
								<tr>
									<td>{{$item->nombre}}</td>
									<td>{{$item->proyecto}}</td>
									<td>{{$item->episodio}}</td>
									<td>{{$item->personaje}}</td>
									<td>{{$item->loops}}</td>
									@php
										$cita = explode(" ", $item->fecha)
									@endphp
									<td>{{$cita[0]}}</td>
									<th>${{$item->importe}}</th>
								</tr>
							@endforeach
						</tbody>
						<tfoot>
							<tr>
									<th colspan="6" style="text-align:right">Total:</th>
									<th></th>
							</tr>
					 </tfoot>
					</table>
					</div>
				</div>
			</div>

			<div class="reporte"></div>

			<!-- PAGE CONTENT ENDS -->
		</div><!-- /.col -->
	</div><!-- /.row -->
@stop

@section('modales')

@stop

@section('script')
	<script type="text/javascript">

		$(document).on('ready', function(){
			$('#table_detalle').DataTable({
				aLengthMenu: [
					[50,100,300,-1],[50,100,300,'All']
				],
				"order": [[5, 'asc']],
				dom: 'lBfrtip',
				buttons: [
						{"extend": 'excel', "text":'Excel',"className": 'btn btn-success btn-xs'}
				],
				language: {
					search:   "Buscar: ",
								lengthMenu: "Mostrar _MENU_ registros por página",
								zeroRecords: "No se encontraron registros",
								info: "Página _PAGE_ de _PAGES_",
								infoEmpty: "Se buscó en",
								infoFiltered: "(_MAX_ registros)",
								responsive:     true,
								paginate: {
										first:      "Primero",
										previous:   "Previo",
										next:       "Siguiente",
										last:       "Anterior"
						},
					},
					"footerCallback": function ( row, data, start, end, display ) {
							var api = this.api(), data;

							// Remove the formatting to get integer data for summation
							var intVal = function ( i ) {
									return typeof i === 'string' ?
											i.replace(/[\$,]/g, '')*1 :
											typeof i === 'number' ?
													i : 0;
							};

							// Total over all pages
							total = api
									.column( 6 )
									.data()
									.reduce( function (a, b) {
											return intVal(a) + intVal(b);
									}, 0 );

							// Total over this page
							pageTotal = api
									.column( 6, { page: 'current'} )
									.data()
									.reduce( function (a, b) {
											return intVal(a) + intVal(b);
									}, 0 );

							// Update footer
							$( api.column( 6 ).footer() ).html(
									//'$'+pageTotal +' ( $'+ total +' total)'
									'$'+pageTotal.toFixed(2)
							);
					}
			});
		});

	</script>
@stop
