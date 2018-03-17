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
							<div class="col-md-4">
							<label>Estudios</label>
							<select class="form-control selectpicker" name="estudio_search" data-style="btn-primary" data-show-subtext="true" data-live-search="true" title="Seleccionar..." required>
								<option value="ALL">TODOS LOS ESTUDIOS</option>
								@foreach($estudios as $item)
									<option value="{{$item->estudio}}">{{$item->estudio}}</option>
								@endforeach
							</select>
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
								<select class="form-control selectpicker" name="proyecto_search" data-style="btn-primary" data-show-subtext="true" data-live-search="true" title="Seleccionar...">
									@foreach($proyectos as $item)
										<option value="{{$item->id}}">{{$item->titulo_original}}</option>
									@endforeach
								</select>
							</div>
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

			//Mostrar los episodios con detalle
			$('#form_search_proyecto').on('submit', function(event){
				event.preventDefault();
				$.ajax({
					url: '{{url("mgcontabilidad/ajax-search-episodios")}}',
					type: 'POST',
					data: $(this).serialize(),
					success: function(data){
						if(data.code == 200){
							$('.reporte').html('<br><br><div class="col-sm-12 col-md-12"><table style="width:100%;" class=" table table-condensed ">\
										</table></div>\
										<table id="table_proyectos" \
										class="table table-striped table-bordered table-hover">\
									<thead>\
										<tr>\
											<th>Título</th>\
											<th>Capìtulo</th>\
											<th>Importe Total</th>\
											<th>Detalle</th>\
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
								},
						});

						function dataEpisodio(data){
							if(data.episodios.length <= 0){
								return "";
							}
									var list_proyectos = '';
									for(var i=0; i<data.episodios.length; i++){
										list_proyectos += "<tr>";
										list_proyectos += "<td>"+data.episodios[i].titulo_original+"</td>";
										list_proyectos += "<td>"+data.episodios[i].num_episodio+"</td>";
										list_proyectos += "<td>$"+data.episodios[i].sum+"</td>";
										list_proyectos += "<td><a href='{{url('mgcontabilidad/get-search-llamados')}}/"+data.episodios[i].folio+"/"+data.episodios[i].titulo_original+"' target='_blank' >Detalle</a></td>";
										list_proyectos += "</tr>";
									}

										return list_proyectos;
						}

						$('#table_detalle').DataTable({
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


					},
					error: function(error){

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
							console.log(data);

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
											<tfoot>\
												<tr>\
														<th colspan="3" style="text-align:right">Total:</th>\
														<th></th>\
												</tr>\
										 </tfoot>\
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
												.column( 3 )
												.data()
												.reduce( function (a, b) {
														return intVal(a) + intVal(b);
												}, 0 );

										// Total over this page
										pageTotal = api
												.column( 3, { page: 'current'} )
												.data()
												.reduce( function (a, b) {
														return intVal(a) + intVal(b);
												}, 0 );

										// Update footer
										$( api.column( 3 ).footer() ).html(
												//'$'+pageTotal +' ( $'+ total +' total)'
												'$'+pageTotal.toFixed(2)
										);
								}
						});

						function dataProyectos(data){
							var estudios = $('select[name=estudio_search]').val()
							if(data.proyectos.length <= 0){
								return "";
							}
				      		var list_proyectos = '';
				      		for(var i=0; i<data.proyectos.length; i++){
				      			if(data.proyectos[i].total != '0'){
											list_proyectos += "<tr>";
					      			list_proyectos += "<td>"+data.proyectos[i].titulo_proyecto+"</td>";
					      			list_proyectos += "<td>"+data.proyectos[i].titulo_original+"</td>";
					      			list_proyectos += "<td>"+data.proyectos[i].num_episodio+"</td>";
											list_proyectos += "<td>$"+data.proyectos[i].total+"</td>";
											list_proyectos += "<td><a target='_blank' href='{{url("mgcontabilidad/detalle-episodios-actores" )}}"+"/"+data.proyectos[i].folio+"/"+data.lunes+"/"+data.sabado+"/"+estudios+"'>Detalle</a></td>";
					      			list_proyectos += "</tr>";
										}
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
