@extends('layouts.app')

@section('guia')
	<li>
		<i class="ace-icon fa fa-child"></i>
		<a href="#">Llamados</a>
	</li>
@stop

@section('content')
    <div class="row">
		<div class="col-xs-12">
			<!-- PAGE CONTENT BEGINS -->

			<div class="row">
				<div class="col-xs-12">
					<h3 class="header smaller lighter blue">Lista de llamados - Macias Group</h3>

					<div class="clearfix">
						<div class="pull-right tableTools-container"></div>
						@if (Session::has('message'))

							<div class="alert alert-success">
								<button type="button" class="close" data-dismiss="alert">
									<i class="ace-icon fa fa-times"></i>
								</button>
								{{  Session::get('message') }}
								<br />
							</div>

						@endif
					</div>
					<div>
						<form id="form_search">
							<div class="col-md-4">

								<label>Sala</label>
								<select name="search_sala" id="search_sala" class="form-control selectpicker" data-style="btn-primary" data-show-subtext="true" data-live-search="true" title="Seleccionar..." required>
									<option value="">Seleccionar...</option>
									@foreach($salas as $sala)
										<option {{$sala->sala}}>{{$sala->sala}}</option>
									@endforeach
								</select>
								{{ csrf_field() }}
							</div>
							<div class="col-md-4">
								<label>Fecha</label>
								<input type="text" name="search_fecha" id="search_fecha" class="form-control" autocomplete="off" required>
							</div>
							<div class="col-md-2"><br>
								<button class="btn btn-primary"><i class="glyphicon glyphicon-search"> </i> Buscar</button>
							</div>
							<div class="col-md-12">
								<div id="create-pdf" style="display: none;">
									<br><br>
									@if(\Request::session()->has('pdf_llamado'))
										<a data-toggle="modal" data-target="#modal_headers" class="btn btn-danger" id="btn-pdf">Generar Reporte PDF
										</a>
									@endif
								</div>
							</div>
						</form>
					</div>
					<!-- div.table-responsive -->

					<!-- div.dataTables_borderWrap -->

					<div class="col-md-12">
						<div id="list-table"></div>
					</div>
				</div>
			</div>

			<!-- PAGE CONTENT ENDS -->
		</div><!-- /.col -->
	</div><!-- /.row -->
@stop

@section('modales')
	<!-- Actualizar calificación-->
	<div class="col-md-12">
		<div class="modal fade" id="modal_headers" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		  <div class="modal-dialog" role="document">
			<div class="modal-content">
			  <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title " id="myModalLabel">Generar PDF</h4>
			  </div>
			  <div class="modal-body">
			  	<div id="alerta_fecha"> </div>
			  	<div class="row">
		  			<form role="form" method="post" action="{{ url('/mgcalendar/pdf-llamados') }}" >
					    <div class="modal-body">
					    	{{ csrf_field() }}
					    	<input type="hidden" name="sala" id="sala">
					    	<input type="hidden" name="fecha" id="fecha">
					    	<input type="hidden" name="search" id="search">
					    	<input type="hidden" name="data" id="data">
					    	<input type="hidden" name="headers" id="headers">
							<div class="alert alert-info" role="alert">
								Seleccionar las columas que requieres imprimir.
							</div>
							<label>Columnas: </label><br>
					    	<select id="select_headers" multiple="multiple" ></select>
							<br><br>
						 <div class="modal-footer">
						   <button type="button" class="btn btn-default" data-dismiss="modal" >Cerrar</button>
						   <button type="submit" class="btn btn-primary">Generar PDF</button>
						 </div>
				    </form>
			  	</div>
			  </div>
			</div>
		  </div>
		</div>
	</div>
@stop

@section('script')
	<script>
		$(document).on('ready', function(){

			//Calendarios
				$('#search_fecha').datepicker({
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

			$('#form_search').on('submit', function(event){
				event.preventDefault();
				$('form_search').removeAttr('action');
				$('form_search').removeAttr('method');
				$.ajax({
                  url: '{{url("mgcalendar/search-llamados")}}',
                  type: 'POST',
                  data: $( this ).serialize(),
                  success: function(data){

                  	$('#list-table').html('<br><br>\
                  		<div class="col-sm-12 col-md-12"><table style="width:100%;" class=" table table-condensed ">\
                  		<tbody style="background: #AAA;"><tr><td>PROYECTO</td><td>NÚMERO DE EPISODIO</td></tr></tbody>\
                  		<tbody>'+proyectos(data)+'</tbody>\
                  		</table></div>\
                  		<table id="table_actores" \
                  		class="table table-striped table-bordered table-hover">\
			              <thead>\
			                <tr>\
			                  <th>Actor</th>\
			                  <th>Credencial</th>\
			                  <th>Personaje</th>\
			                  <th>Director</th>'+encabezados(data)+'\
			                  <th>Total Loops</th>\
			                  <th>Fecha</th>\
			                  <th>Entrada</th>\
			                  <th>Salida</th>\
							  <th>Firma</th>\
			                </tr>\
			              </thead>\
			              <tbody> '+contenido(data)+'\
			              </tbody>\
			            </table>');
                  	$('#select_headers').append('\
                  		<option value="Actor">Actor</option>\
                  		<option value="Credencial">Credencial</option>\
                  		<option value="Personaje">Personaje</option>\
                  		<option value="Director">Director</option>'+encabezadosSelect(data)+'\
						<option value="Total Loops">Total Loops</option>\
						<option value="Entrada">Entrada</option>\
						<option value="Salida">Salida</option>\
						<option value="Firma">Firma</option>\
                  		');
					$('#select_headers').multiselect();
					$('#select_headers').multiselect('refresh');
					$('#select_headers').on('change', function(){

		            	var select_headers = $(this).val();
		            	var headers= select_headers.join(",");
		            	$('#headers').val(headers);
		            });


          var midata = $('#table_actores').DataTable({
						"order": [[8, 'asc']],
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

					$('#create-pdf').css({display: 'block'});
              	if( $('#create-pdf').is(":visible") ){
              		$('#sala').val($('#search_sala').val());
              		$('#fecha').val($('#search_fecha').val());
            	}

            	midata.on('search.dt', function() {
					    var num = midata.rows( { filter : 'applied'} ).data();
					    $('#data').val(num);
					    var n = 'ID,Actor,Credencial,Personaje,Director,'+encabezadosPdf(data)+'Total Loops,Fecha,Entrada,Salida,Firma;';
					    for(var i=0; i<num.length; i++){
					    	n +=  num[i]+';';
					    }
					    $('#data').val(n);
					});
					var num2 = midata.rows( { filter : 'applied'} ).data();
					    $('#data').val(num2);
					    var n2 = 'ID,Actor,Credencial,Personaje,Director,'+encabezadosPdf(data)+'Total Loops,Fecha,Entrada,Salida,Firma;';
					    for(var i=0; i<num2.length; i++){
					    	n2 +=  num2[i]+';';
					    }
					    $('#data').val(n2);

					/*$('input[type="search"]').keyup(function(event) {
						$('#search').val($(this).val());
					});*/
                  }
                });
			});
		});



		function contenido(data){

			console.log('CONTENIDO ', data);
			if(data.llamados.length <= 0){
				return "";
			}

			var formArray = [];
			for(var i=0; i<data.llamados.length; i++){
				formArray[i] = JSON.stringify({actor: data.llamados[i].actor});
			}

			var nuevoArray = new Array();
			for(var i=0; i<data.llamados.length; i++){

				if(nuevoArray.includes(data.llamados[i].actor)){

				} else {
					nuevoArray.push(data.llamados[i]);
				}
			}

			// Genera el nuevo arreglo
			var list_new_llamados = [];
			
      		for(var i=0; i<data.llamados.length; i++){

      			if(list_new_llamados[data.llamados[i].credencial]){
      				//Suma los loops por proyectos
      				for(var j=0; j<data.proyectos.length; j++){
      					if( data.proyectos[j].folios == data.llamados[i].folio ) {
      						list_new_llamados[data.llamados[i].credencial][String(data.proyectos[j].folios)] +=  parseInt(data.llamados[i].loops);
      					}
	      			}
	      			// suma el total de loops
	      			list_new_llamados[data.llamados[i].credencial].total = 0;
	      			for(var j=0; j<data.proyectos.length; j++){
      					list_new_llamados[data.llamados[i].credencial].total += parseInt( list_new_llamados[data.llamados[i].credencial][String(data.proyectos[j].folios)] );
	      			}

      			} else{
      				list_new_llamados[data.llamados[i].credencial] = new Array();
      				list_new_llamados[data.llamados[i].credencial].actor =  data.llamados[i].actor;
      				list_new_llamados[data.llamados[i].credencial].credencial = data.llamados[i].credencial;
      				list_new_llamados[data.llamados[i].credencial].descripcion = data.llamados[i].descr; //Aqui se almacenan los personajes
      				list_new_llamados[data.llamados[i].credencial].director = data.llamados[i].director;


      				for(var j=0; j<data.proyectos.length; j++){

      					if(data.proyectos[j].folios == data.llamados[i].folio){
      						// Permite asignar el total de loops
	      					list_new_llamados[data.llamados[i].credencial].total = list_new_llamados[data.llamados[i].credencial][String(data.proyectos[j].folios)] = parseInt(data.llamados[i].loops);
	      				} else {
	      					list_new_llamados[data.llamados[i].credencial][String(data.proyectos[j].folios)] = parseInt(0);
	      				}
	      			}


      				list_new_llamados[data.llamados[i].credencial].fecha = data.llamados[i].fecha;
      				list_new_llamados[data.llamados[i].credencial].entrada = data.llamados[i].entrada;
      				list_new_llamados[data.llamados[i].credencial].salida = data.llamados[i].salida;

      			}
      		}

      		//console.log(list_new_llamados);
      		//Permite mostrar las llaves del arreglo
			var list_llamados = '';
      		for( property in list_new_llamados ){

		      			list_llamados += "<tr>";
		      			list_llamados += "<td>"+list_new_llamados[property].actor+"</td>";
		      			list_llamados += "<td>"+list_new_llamados[property].credencial+"</td>";
		      			list_llamados += "<td>"+list_new_llamados[property].descripcion+"</td>";
		      			list_llamados += "<td>"+list_new_llamados[property].director+"</td>";
		      			for(var j=0; j<data.proyectos.length; j++){
		      				list_llamados += "<td>"+list_new_llamados[property][data.proyectos[j].folios]+"</td>";
		      			}

		      			list_llamados += "<td>"+list_new_llamados[property].total+"</td>";
		      			list_llamados += "<td>"+list_new_llamados[property].fecha+"</td>";
		      			list_llamados += "<td>"+list_new_llamados[property].entrada+"</td>";
		      			list_llamados += "<td>"+list_new_llamados[property].salida+"</td>";
								list_llamados += "<td></td>";
		      			list_llamados += "</tr>";

					}

      			return list_llamados;
      	}

      	function proyectos(data){
			if(data.proyectos.length <= 0){
				return "";
			}
      		var list_proyectos = new Array();
      		for(var i=0; i<data.proyectos.length; i++){
      			list_proyectos += "<tr>";
      			list_proyectos += "<td>"+data.proyectos[i].proyectos+"</td>";
      			list_proyectos += "<td>"+data.proyectos[i].capitulo+"</td>";
      			list_proyectos += "</tr>";
      		}

      			return list_proyectos;
      	}

      	function encabezados(data){
			if(data.proyectos.length <= 0){
				return "";
			}
      		var list_encabezados = new Array();
      		for(var i=0; i<data.proyectos.length; i++){
      			list_encabezados += "<td id="+data.proyectos[i].capitulo+">"+data.proyectos[i].capitulo+"</td>";
      		}

      			return list_encabezados;
      	}

      	function encabezadosSelect(data){

			if(data.proyectos.length <= 0){
				return "";
			}
      		var list_encabezados = new Array();
      		for(var i=0; i<data.proyectos.length; i++){
      			list_encabezados += "<option value="+data.proyectos[i].capitulo+">"+data.proyectos[i].capitulo+"</option>";
      		}

      			return list_encabezados;
      	}

      	function encabezadosPdf(data){
			if(data.proyectos.length <= 0){
				return "";
			}

      		var list_encabezados = new Array();

      		for(var i=0; i<data.proyectos.length; i++){
      			list_encabezados += data.proyectos[i].capitulo+",";
      		}

      			return list_encabezados;
      	}

	</script>
@stop
