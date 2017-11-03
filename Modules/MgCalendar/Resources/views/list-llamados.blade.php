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
								<div id="create-pdf"></div>
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
	
@stop

@section('script')
	<script>
		$(document).on('ready', function(){
			//Calendarios
				$('#search_fecha').datepicker({
					dateFormat: "yy-mm-dd",
					minDate: 0,
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
                  	$('#create-pdf').html('<br><br><a href="" class="btn btn-danger" id="btn-pdf">Generar Reporte PDF</a>');
                  	$('#list-table').html('<br><br>\
                  		<div class="col-md-12"><table class=" table table-condensed">\
                  		<tbody style="background: #AAA;"><tr><td>PROYECTO</td><td>EPISODIO</td><td>FOLIO</td></tr></tbody>\
                  		<tbody>'+proyectos(data)+'</tbody>\
                  		</table></div>\
                  		<table id="table_actores" \
                  		class="table table-striped table-bordered table-hover">\
			              <thead>\
			                <tr>\
			                  <th>ID</th>\
			                  <th>Actor</th>\
			                  <th>Credencial</th>\
			                  <th>Descripción</th>\
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

                  	//Generar PDF
			$('#btn-pdf').on('click', function(event){
				event.preventDefault();
				$.ajax({
                  url: '{{url("mgcalendar/pdf-llamados")}}',
                  type: 'GET',
                  data: $( this ).serialize(),
                  success: function(data){

                  }
                });
			});
                  	
                  	$('#table_actores').DataTable({
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
      			list_proyectos += "<td>"+data.proyectos[i].episodios+"</td>";
      			list_proyectos += "<td>"+data.proyectos[i].folios+"</td>";
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
      			list_encabezados += "<td id="+data.proyectos[i].folios+">"+data.proyectos[i].folios+"</td>";
      		}
      		
      			return list_encabezados;
      	}

	</script>
@stop
