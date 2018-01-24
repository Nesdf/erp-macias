@extends('layouts.app')

@section('guia')
	<li>
		<i class="ace-icon fa fa-users"></i>
		<a href="{{ url('mgclientes') }}">Reporte por Episodio</a>
	</li>
@stop

@section('content')
    <div class="row">
		<div class="col-xs-12">
			<!-- PAGE CONTENT BEGINS -->
			
			<div class="row">
				<div class="col-xs-12">
					<h3 class="header smaller lighter blue">Reporte por Episodio</h3>
					<form id="form_search">
						<div class="col-md-4">
							<label>Episodios</label>
							<select name="sala" class="form-control" id="episodios" data-style="btn-primary" data-show-subtext="true" name="ajaxEpisodio" data-live-search="true" title="Seleccionar...">
								@foreach($episodios as $item)
									<option>{{ $item->titulo_original }}</option>
								@endforeach()
							</select>
						</div>
						<div class="col-md-4">
							<label>Fecha Inicial</label>
							<input type="text" name="fecha_inicial_search" id="fecha_inicial_search" class="form-control" >
						</div>
						{{ csrf_field() }}
						<div class="col-md-4">
							<label>Fecha final</label>
							<input type="text" name="fecha_final_search" id="fecha_final_search" class="form-control" >
						</div>
						<div class="col-md-offset-4 col-md-4">
							<br>
							<button type="submit" class="btn btn-success btn-lg btn-block">Enviar</button>
						</div>
					</form>
				</div>
			</div>	

			<div class="reporte">
				
			</div>	

			<!-- PAGE CONTENT ENDS -->
		</div><!-- /.col -->
	</div><!-- /.row -->
@stop

@section('modales')
	
@stop

@section('script')
	<script type="text/javascript">
		$(document).on('ready', function(){

			$('#episodios').selectpicker();


			$('#fecha_inicial_search, #fecha_final_search').datepicker({
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
		}); 

		$('#form_search').on('submit', function(){
			event.preventDefault();
			$.ajax({
				url: "{{ url('mgcontabilidad/ajax_reporte-episodios') }}",
				type: "POST",
				data: $( this ).serialize(),
				success: function( data ){
					if(data.msg == 'success'){
						console.log(data);
						//window.location.reload(true);

						$('.reporte').html('<br><br>\
                  		<div class="col-sm-12 col-md-12"><table style="width:100%;" class=" table table-condensed ">\
                  		</table></div>\
                  		<table id="table_actores" \
                  		class="table table-striped table-bordered table-hover">\
			              <thead>\
			                <tr>\
			                  <th>Serie</th>\
			                  <th>Capítulo</th>\
			                  <th>Título en Inglés</th>\
			                  <th>Título en español</th>\
			                  <th>Duración</th>\
			                  <th>Total IA</th>\
			                  <th>Total JL</th>\
			                  <th>Total</th>\
			                </tr>\
			              </thead>\
			              <tbody>'+dataEpisodios(data)+'\
			              </tbody>\
			            </table>');
					}

					function dataEpisodios(data){
						if(data.episodios.length <= 0){
							return "";
						}
			      		var list_episodios;
			      		for(var i=0; i<data.episodios.length; i++){
			      			list_episodios += "<tr>";
			      			list_episodios += "<td>"+data.episodios[i].titulo_original+"</td>";
			      			list_episodios += "<td>"+data.episodios[i].num_episodio+"</td>";
			      			list_episodios += "<td>"+data.episodios[i].titulo_original+"</td>";
			      			list_episodios += "<td>"+data.episodios[i].num_episodio+"</td>";
			      			list_episodios += "<td>23</td>";
			      			list_episodios += "<td>$00.00</td>";
			      			list_episodios += "<td>$00.00</td>";
			      			list_episodios += "<td>$00.00</td>";
			      			list_episodios += "</tr>";
			      		}

			      			return list_episodios;
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
	</script>
@stop