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

					<div id="div_form_search">
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

					<div id="div_form_search_proyecto">
						<form id="form_search_proyecto">
							<div class="col-md-4">
								<label>Proyecto</label>
								<select class="form-control selectpicker" name="proyecto_search" data-style="btn-primary" data-show-subtext="true" name="ajaxEpisodio" data-live-search="true" title="Seleccionar...">
									@foreach($proyectos as $item)
										<option value="{{$item->id}}">{{$item->titulo_original}}</option>
									@endforeach
								</select>
							</div>
							<div id="input_episodio"></div>
							{{ csrf_field() }}
							<div class="col-md-2">
								<br>
								<button type="submit" class="btn btn-primary btn-lg btn-block"><i class="glyphicon glyphicon-search"> </i> Buscar</button>
							</div>
						</form>
					</div>
					<div class="col-md-12">
						<br><br>
						<label>
							<span style="color: blue;">Buscar por Proyecto</span>
							<input type="checkbox" name="select_por_proyecto" id="select_por_proyecto">
						</label>
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

			$('#div_form_search_proyecto').css({display: 'none'});

			$('#select_por_proyecto').on('click', function(){
				if( $(this).is(":checked") ) {
					$('#div_form_search').css({display: 'none'});
					$('#div_form_search_proyecto').css({display: 'block'});
				} else {
					$('#div_form_search').css({display: 'block'});
					$('#div_form_search_proyecto').css({display: 'none'});
				}
			});

			$('#proyectos').selectpicker();

			$('select[name=proyecto_search]').on('change', function(){
				console.log($(this).val());

				$.ajax({
					url: '{{url("mgcontabilidad/ajax-search-proyecto")}}/'+$(this).val(),
					type: 'GET',
					success: function(data){
						if(data.code = 200){
							console.log(data);
							$('#input_episodio').html('\
								<div class="col-md-4">\
								<lable>Episodios</label>\
								<select class="form-control" name="episodios_search"  data-style="btn-primary" data-show-subtext="true" name="ajaxEpisodio" data-live-search="true" title="Seleccionar..." >'+allEpisodios(data)+'\
								</select>\
								</div>\
							');
						}

						$('select[name=episodios_search]').selectpicker();

						//Buscar por Proyectos
						$('#form_search_proyecto').on('submit', function(event){
							event.preventDefault();
							$.ajax({
								url: '{{url("mgcontabilidad/ajax-search-episodio")}}',
								type: 'POST',
								data: $(this).serialize(),
								success: function(data){
									if(data.code == 200){
										console.log(data);
										$('.reporte').html('<br><br><div class="col-sm-12 col-md-12"><table style="width:100%;" class=" table table-condensed ">\
		                  		</table></div>\
		                  		<table id="table_proyectos" \
		                  		class="table table-striped table-bordered table-hover">\
					              <thead>\
					                <tr>\
					                  <th>Actor</th>\
					                  <th>Fecha Llamado</th>\
														<th>Personaje</th>\
					                  <th>Loops</th>\
														<th>Importe</th>\
					                </tr>\
					              </thead>\
					             <tbody>'+dataEpisodio(data)+'\
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

									function dataEpisodio(data){
										if(data.llamados.length <= 0){
											return "";
										}
							      		var list_proyectos = '';
							      		for(var i=0; i<data.llamados.length; i++){
							      			list_proyectos += "<tr>";
							      			list_proyectos += "<td>"+data.llamados[i].nombre_real+"</td>";
													var cita = data.llamados[i].cita_end;
													var fecha = cita.split(" ");
							      			list_proyectos += "<td>"+fecha[0]+"</td>";
							      			list_proyectos += "<td>"+data.llamados[i].descripcion+"</td>";
													list_proyectos += "<td>"+data.llamados[i].loops+"</td>";
													list_proyectos += "<td>$"+data.llamados[i].pago_total_loops+"</td>";
							      			list_proyectos += "</tr>";
							      		}

							      			return list_proyectos;
									}
								},
								error: function(error){

								}
							});
						});

						function allEpisodios(datos){
							console.log(datos.episodios.length);
							var episodios = '';
							for (var i = 0; i < datos.episodios.length; i++) {
								    episodios += "<option value="+datos.episodios[i].folio+"> "+datos.episodios[i].titulo_original+"</option>"
							}
							return episodios;
						}
					},
					error: function(error){
						console.log(error);
					}
				});
			});

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
			    dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá']
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
