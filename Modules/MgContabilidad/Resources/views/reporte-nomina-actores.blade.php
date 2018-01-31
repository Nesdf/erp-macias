@extends('layouts.app')

@section('guia')
	<li>
		<i class="ace-icon fa fa-users"></i>
		<a href="{{ url('mgclientes') }}">Nómina Actores</a>
	</li>
@stop

@section('content')
    <div class="row">
		<div class="col-xs-12">
			<!-- PAGE CONTENT BEGINS -->


			<div class="row">
				<div class="col-xs-12">
					<h3 class="header smaller lighter blue">Nómina Actores</h3>

					<form id="form_search">
						{{ csrf_field() }}
						<div class="col-md-3">
							<label>Fecha Inicial</label>
							<input type="text" name="fecha_inicial_search"  class="form-control" >
						</div>
						<div class="col-md-3">
							<label>Fecha Final</label>
							<input type="text" name="fecha_final_search" class="form-control" >
						</div>
						<div class="col-md-4">
							<label>Actores</label>
							<select name="actor" class="form-control" id="salas" data-style="btn-primary" data-show-subtext="true"  data-live-search="true" >
								<option value="">Seleccionar...</option>
								@foreach($actores as $item)
									<option >{{ $item->nombre_artistico }}</option>
								@endforeach()
							</select>
						</div>
						<div class="col-md-2"><br>
							<button type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-search"> </i> Buscar</button>
						</div>
					</form>
				</div>
			</div>
			<!-- PAGE CONTENT ENDS -->
		</div><!-- /.col -->
	</div><!-- /.row -->

<br><br>
	<div class="detalle"></div>
@stop

@section('modales')

@stop

@section('script')
	<script type="text/javascript">
		$(document).on('ready', function(){

			$('#salas').selectpicker();
			//Calendarios
			$('input[name=fecha_inicial_search], input[name=fecha_final_search]').datepicker({
					dateFormat: "yy-mm-dd",
					//minDate: 0,
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


				$('#form_search').on('submit', function(e){
						e.preventDefault();

						$.ajax({
							url: '{{url("mgcontabilidad/ajax-nomina-actores")}}',
		          	type: 'POST',
		          	data: $( this ).serialize(),
		          	success: function(data){
		          		$('.detalle').html('<div><a href="javascript:void(0)" class="btn btn-success">Excel</a></div><br><br>\
		            		<div class="col-sm-12 col-md-12 col-lg-12">\
		            		<table id="table_nomina" \
		            		class="table table-striped table-bordered table-hover">\
		              <thead>\
		                <tr>\
		                  <th>Nombre</th>\
		                  <th>Clave</th>\
											<th>R.F.C.</th>\
											<th>Importe</th>\
		                </tr>\
		              </thead>\
		              <tbody> <tr><td></td><td></td><td></td><td></td></tr>\
		              </tbody>\
		            </table>\
								</div>');



								$('#table_nomina').DataTable({
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

								});							},
							error: function(error){

							}

						});
				});

		});
	</script>
@stop
