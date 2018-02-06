@extends('layouts.app')

@section('guia')
	<li>
		<i class="ace-icon fa fa-users"></i>
		<a href="{{ url('mgclientes') }}">Reporte por Llamado de Actores</a>
	</li>
@stop

@section('content')
    <div class="row">
		<div class="col-xs-12">
			<!-- PAGE CONTENT BEGINS -->

			<div class="row">
				<div class="col-xs-12">
					<h3 class="header smaller lighter blue">Reporte por Llamado de Actores</h3>

					<form id="form_search">
						{{ csrf_field() }}
						<div class="col-md-4">
							<label>Fecha</label>
							<input type="text" name="fecha_search" id="fecha_search" class="form-control" required>
						</div>
						<div class="col-md-4">
							<label>Sala</label>
							<select name="sala" class="form-control" id="sala" data-style="btn-primary" data-show-subtext="true" name="ajaxEpisodio" data-live-search="true" title="Seleccionar..." required>
								@foreach($salas as $item)
									<option>{{ $item->sala }}</option>
								@endforeach
							</select>
						</div>
						<div class="col-md-2"><br>
							<button type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-search"> </i> Buscar</button>
						</div>
					</form>

				</div>
			</div>
			<br> <br> <br>
			<div class="detalle" class="col-md-12"> </div>
			<!-- PAGE CONTENT ENDS -->
		</div><!-- /.col -->
	</div><!-- /.row -->
@stop

@section('modales')

@stop

@section('script')
	<script type="text/javascript">
		$(document).on('ready', function(){

			$('#sala').selectpicker();
			//Calendarios
			$('#fecha_search').datepicker({
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
					url: '{{url("mgcontabilidad/ajax-llamado-actores")}}',
          	type: 'POST',
          	data: $( this ).serialize(),
          	success: function(data){
          		$('.detalle').html('<br>\
            		<div class="col-sm-12 col-md-12 col-lg-12">\
								<table style="width:100%" class=" table table-condensed ">\
            		<tbody style="background: #AAA;"><tr><td>PROYECTO</td><td>NÚMERO DE EPISODIO</td></tr></tbody>\
            		<tbody>'+proyectos(data)+'</tbody>\
            		</table></div>\
            		<table id="table_actores" \
            		class="table table-striped table-bordered table-hover">\
              <thead>\
                <tr>\
                  <th>Actor</th>\
                  <th>Personaje</th>\
									<th>Sala</th>\
                  <th>Director</th>'+encabezados(data)+'\
                  <th>Total Loops</th>\
									<th>Total</th>\
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
            		<option value="Director">Director</option>'+encabezadosSelect(data)+'\
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
						"order": [[9, 'asc']],
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
		    var n = 'ID,Actor,Credencial,Personaje,Director,'+encabezadosPdf(data)+'Total Loops,Fecha,Entrada,Salida;';
		    for(var i=0; i<num.length; i++){
		    	n +=  num[i]+';';
		    }
		    $('#data').val(n);
		});

		var num2 = midata.rows( { filter : 'applied'} ).data();
	    $('#data').val(num2);
	    var n2 = 'ID,Actor,Credencial,Personaje,Director,S'+encabezadosPdf(data)+'Total Loops,Fecha,Entrada,Salida;';
	    for(var i=0; i<num2.length; i++){
	    	n2 +=  num2[i]+';';
	    }
	    $('#data').val(n2);

		/*$('input[type="search"]').keyup(function(event) {
			$('#search').val($(this).val());
		});*/
    	},
    	error: function(error){

    	}
				})
			});
		});

		function contenido(data){
			if(data.llamados.length <= 0){
				return "";
			}
			var nuevoArray = new Array();
			for(var i=0; i<data.llamados.length; i++){

				if( nuevoArray.indexOf(data.llamados[i].actor) ){
				} else {
					nuevoArray.push(data.llamados[i]);
				}
			}
			console.log(nuevoArray);
      		var list_llamados = new Array();
      		for(var i=0; i<data.llamados.length; i++){
      			list_llamados += "<tr>";
      			list_llamados += "<td>"+data.llamados[i].actor+"</td>";
						list_llamados += "<td>"+data.llamados[i].descr+"</td>";
      			list_llamados += "<td>"+data.llamados[i].sala+"</td>";
      			list_llamados += "<td>"+data.llamados[i].director+"</td>";
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
						list_llamados += "<td>$"+data.llamados[i].pago_total_loops+"</td>";
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
