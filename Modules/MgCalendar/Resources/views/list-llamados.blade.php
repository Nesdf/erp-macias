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
								{{ csrf_field() }}						
								<label>Sala</label>
								<select name="search_sala" id="search_sala" class="form-control" required>
									<option value="">Seleccionar...</option>
									@foreach($salas as $sala)
										<option {{$sala->sala}}>{{$sala->sala}}</option>
									@endforeach
								</select>								
							</div>
							<div class="col-md-4">
								<label>Fecha</label>
								<input type="text" name="search_fecha" id="search_fecha" class="form-control" required>								
							</div>
							<div class="col-md-2"><br>
								<button class="btn btn-primary"><i class="glyphicon glyphicon-search"> </i> Buscar</button>								
							</div>
							<div class="col-md-12">
								<div id="create-pdf" style="display: none;">
									<br><br>
									<a data-toggle="modal" data-target="#modal_headers" class="btn btn-danger" id="btn-pdf">Generar Reporte PDF
									</a>
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
		  			<form method="post" action="{{ url('/mgcalendar/pdf-llamados') }}" >
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
			                  <th>ID</th>\
			                  <th>Actor</th>\
			                  <th>Credencial</th>\
			                  <th>Personaje</th>\
			                  <th>Director</th>\
			                  <th>Sala</th>\
			                  <th>Estudio</th>'+encabezados(data)+'\
			                  <th>Total Loops</th>\
			                  <th>Fecha</th>\
			                  <th>Entrada</th>\
			                  <th>Salida</th>\
			                </tr>\
			              </thead>\
			              <tbody> '+contenido(data)+'\
			              </tbody>\
			            </table>');
                  	$('#select_headers').append('\
                  		<option value="Actor">Actor</option>\
                  		<option value="Credencial">Credencial</option>\
                  		<option value="Personaje">Personaje</option>\
                  		<option value="Director">Director</option>\
                  		<option value="Sala">Sala</option>\
						<option value="Estudio">Estudio</option>'+encabezadosSelect(data)+'\
						<option value="Total Loops">Total Loops</option>\
						<option value="Entrada">Entrada</option>\
						<option value="Salida">Salida</option>\
                  		'); 
					$('#select_headers').multiselect();
					$('#select_headers').multiselect('refresh');
					$('#select_headers').on('change', function(){
            	
		            	var select_headers = $(this).val();
		            	var headers= select_headers.join(",");
		            	$('#headers').val(headers);
		            });

                  	
                  	var midata = $('#table_actores').DataTable({
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

					//console.log(midata.row());
					//console.log(midata.data());


					$('#create-pdf').css({display: 'block'});
                  	if( $('#create-pdf').is(":visible") ){
                  		$('#sala').val($('#search_sala').val());
                  		$('#fecha').val($('#search_fecha').val());
	              	}
	              	
	              	midata.on('search.dt', function() {
					    var num = midata.rows( { filter : 'applied'} ).data();
					    $('#data').val(num);  
					    var n = 'ID,Actor,Credencial,Personaje,Director,Sala,Estudio,'+encabezadosPdf(data)+'Total Loops,Fecha,Entrada,Salida;';
					    for(var i=0; i<num.length; i++){
					    	n +=  num[i]+';';
					    } 
					    $('#data').val(n);                
					});
					var num2 = midata.rows( { filter : 'applied'} ).data();
					    $('#data').val(num2);  
					    var n2 = 'ID,Actor,Credencial,Personaje,Director,Sala,Estudio,'+encabezadosPdf(data)+'Total Loops,Fecha,Entrada,Salida;';
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
			if(data.llamados.length <= 0){
				return "";
			}
      		var list_llamados = new Array();
      		for(var i=0; i<data.llamados.length; i++){
      			list_llamados += "<tr>";
      			list_llamados += "<td>"+data.llamados[i].id+"</td>";
      			list_llamados += "<td>"+data.llamados[i].actor+"</td>";
      			list_llamados += "<td>"+data.llamados[i].credencial+"</td>";
      			list_llamados += "<td>"+data.llamados[i].descr+"</td>";
      			list_llamados += "<td>"+data.llamados[i].director+"</td>";
      			list_llamados += "<td>"+data.llamados[i].sala+"</td>";
      			list_llamados += "<td>"+data.llamados[i].estudio+"</td>";
      			for(var j=0; j<data.proyectos.length; j++){
      				if(data.proyectos[j].folios == data.llamados[i].folio){
      					list_llamados += "<td>"+data.llamados[i].loops+"</td>";
      				} else{
      					list_llamados += "<td>0</td>";
      				}      				
      			}
      			for(var j=0; j<data.proyectos.length; j++){
      				if(data.proyectos[j].folios == data.llamados[i].folio){
      					list_llamados += "<td>"+data.llamados[i].loops+"</td>";
      				}     				
      			}
      			list_llamados += "<td>"+data.llamados[i].fecha+"</td>";
      			list_llamados += "<td>"+data.llamados[i].entrada+"</td>";
      			list_llamados += "<td>"+data.llamados[i].salida+"</td>";
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
      			console.log(list_proyectos);
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
      			console.log(list_encabezados);
      			return list_encabezados;
      	}

      	function encabezadosSelect(data){
      		console.log(data);
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
