@extends('layouts.app')

@section('guia')
	<li>
		<i class="menu-icon fa fa-bank"></i>
		<a href="{{ url('mgcontabilidad/reporte-proyectos') }}">Reporte por Proyecto</a>
	</li>
@stop

@section('content')
    <div class="row">
		<div class="col-xs-12">
			<!-- PAGE CONTENT BEGINS -->

			<div class="row">
				<div class="col-xs-12">
					<h3 class="header smaller lighter blue">Reporte por Proyecto</h3>

					<form id="form_search">
						<div class="col-md-4">
							<label>Lunes</label>
							<input type="text" name="lunes_search" id="lunes_search" class="form-control" required>
						</div>
						{{ csrf_field() }}
						<div class="col-md-2">
							<br>
							<button type="submit" class="btn btn-primary btn-lg btn-block"><i class="glyphicon glyphicon-search"> </i> Buscar</button>
						</div>
					</form>
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

			$('#proyectos').selectpicker();

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

			$('#form_search').on('submit', function(event){
				event.preventDefault();
				$.ajax({
					url: "{{ url('mgcontabilidad/ajax-reporte-proyectos') }}",
					type: "POST",
					data: $( this ).serialize(),
					success: function( data ){
						if(data.msg == 'success'){

							$('.reporte').html('<br><br><div class="col-sm-12 col-md-12"><table style="width:100%;" class=" table table-condensed ">\
	                  		</table></div>\
	                  		<table id="table_proyectos" \
	                  		class="table table-striped table-bordered table-hover">\
				              <thead>\
				                <tr>\
				                  <th>Proyecto</th>\
				                  <th>Episodio</th>\
													<th>Capítulo</th>\
				                  <th>Importe</th>\
													<th>Detalle</th>\
				                </tr>\
				              </thead>\
				              <tbody>'+dataProyectos(data)+'\
				              </tbody>\
				            </table>');
						}

						$('#table_proyectos').DataTable({
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
								}
						});

						function dataProyectos(data){
							if(data.proyectos.length <= 0){
								return "";
							}
				      		var list_proyectos = '';
				      		for(var i=0; i<data.proyectos.length; i++){
				      			list_proyectos += "<tr>";
				      			list_proyectos += "<td>"+data.proyectos[i].titulo_proyecto+"</td>";
				      			list_proyectos += "<td>"+data.proyectos[i].titulo_original+"</td>";
				      			list_proyectos += "<td>"+data.proyectos[i].num_episodio+"</td>";
										list_proyectos += "<td>$"+data.proyectos[i].total+"</td>";
										list_proyectos += "<td><a href='{{url("mgcontabilidad/detalle-episodios-actores" )}}"+"/"+data.proyectos[i].folio+"/"+data.lunes+"/"+data.sabado+"'>Detalle</a></td>";
				      			list_proyectos += "</tr>";
				      		}

				      			return list_proyectos;
						}
					},
					error: function(error){
						var err = "";
						for(var i in error.responseJSON.msg){
							err += error.responseJSON.msg[i] + "<br>";
						}
						$('#error_create_actor').html('<div class="alert alert-danger">' + err + '</div>');
					}
				});
			});
		});

	</script>
@stop
