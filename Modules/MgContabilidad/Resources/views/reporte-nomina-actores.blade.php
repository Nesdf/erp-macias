@extends('layouts.app')
@section('css')
	<li>
		<i class="ace-icon fa fa-users"></i>
		<a href="{{ url('mgclientes') }}">Nómina Actores</a>
	</li>
@stop

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
							<label>Fecha día lunes</label>
							<input type="text" name="lunes_search"  class="form-control" required>
						</div>
						<div class="col-md-3">
							<label>Estudio</label>
							<select class="form-control selectpicker" name="estudio_search" data-style="btn-primary" data-show-subtext="true" data-live-search="true" title="Seleccionar..." required>
								<option value="ALL">TODOS LOS ESTUDIOS</option>
								@foreach($estudios as $item)
									<option value="{{$item->estudio}}">{{$item->estudio}}</option>
								@endforeach
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


			//Calendarios
			$('input[name=lunes_search]').datepicker({
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
						beforeShowDay: function(date){
                 return [date.getDay() == 1,"","Solo los lunes"];
           }
				});


				$('#form_search').on('submit', function(e){
						e.preventDefault();

						$.ajax({
							url: '{{url("mgcontabilidad/ajax-nomina-actores")}}',
		          	type: 'POST',
		          	data: $( this ).serialize(),
		          	success: function(data){

		          		$('.detalle').html('<div class="col-sm-12 col-md-12 col-lg-12">\
		            		<table id="table_nomina" \
		            		class="table table-striped table-bordered table-hover">\
		              <thead>\
		                <tr>\
		                  <th>Nombre</th>\
		                  <th>Clave</th>\
											<th>Lunes</th>\
											<th>Martes</th>\
											<th>Miércoles</th>\
											<th>Jueves</th>\
											<th>Viernes</th>\
											<th>Sábado</th>\
											<th>Importe</th>\
		                </tr>\
		              </thead>\
		              <tbody>'+allData(data.datos)+'\
		              </tbody>\
									<tfoot>\
										<tr>\
												<th colspan="8" style="text-align:right">Total:</th>\
												<th></th>\
										</tr>\
								 </tfoot>\
		            </table>\
								</div>');
								$('#table_nomina').DataTable({
									"pageLength": 200,
									aLengthMenu: [
							        [50, 100, 200, -1],
							        [50, 100, 200, "All"]
							    ],
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
			                        .column( 8 )
			                        .data()
			                        .reduce( function (a, b) {
			                            return intVal(a) + intVal(b);
			                        }, 0 );

			                    // Total over this page
			                    pageTotal = api
			                        .column( 8, { page: 'current'} )
			                        .data()
			                        .reduce( function (a, b) {
			                            return intVal(a) + intVal(b);
			                        }, 0 );

			                    // Update footer
			                    $( api.column( 8 ).footer() ).html(
			                        //'$'+pageTotal +' ( $'+ total +' total)'
			                        '$'+pageTotal.toFixed(2)
			                    );
			                }
								});
							},
							error: function(error){

							}

						});
				});

		});

		function allData(data){
			console.log(data)
			var fecha = $('input[name=lunes_search]').val();
			var sala = $('select[name=estudio_search]').val();
			var datos = '';
			for(var i=0; i<data.length; i++){
				datos += "<tr>";
				datos += "<td><a href='{{url("mgcontabilidad/get-search-nomina-actores")}}/"+fecha+"/"+sala+"/"+data[i].nombre_real+"' target='_blank'>"+data[i].nombre_real+"</a></td>";
				datos += "<td>"+data[i].credencial+"</td>";
				datos += "<td>$"+data[i].lunes+"</td>";
				datos += "<td>$"+data[i].martes+"</td>";
				datos += "<td>$"+data[i].miercoles+"</td>";
				datos += "<td>$"+data[i].jueves+"</td>";
				datos += "<td>$"+data[i].viernes+"</td>";
				datos += "<td>$"+data[i].sabado+"</td>";
				datos += "<td>$"+data[i].importe+"</td>";

				datos += "</tr>";
			}
			return datos;
		}
	</script>
@stop
