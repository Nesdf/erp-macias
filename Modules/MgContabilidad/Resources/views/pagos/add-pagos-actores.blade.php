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
		<a href="{{ url('mgclientes') }}">Pago de Actores</a>
	</li>
@stop

@section('content')
    <div class="row">
		<div class="col-xs-12">
			<!-- PAGE CONTENT BEGINS -->
			<div class="row">
				<div class="col-xs-12">
					<h3 class="header smaller lighter blue">Pago de Actores</h3>
					<form id="form_search">
						{{ csrf_field() }}
						<div class="col-md-3">
							<label>Actores</label>
							<select class="form-control selectpicker" name="actor_search" data-style="btn-primary" data-show-subtext="true" data-live-search="true" title="Seleccionar..." required>
								@foreach($actores as $item)
									<option value="{{$item->nombre_completo}}">{{$item->nombre_completo}}</option>
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

<div class="modal fade" id="pagos" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
    	<form id="form_xml_pdf" accept-charset="UTF-8" enctype="multipart/form-data">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title">Pago de Actor</h4>
	      </div>
	      <div class="modal-body">
	      	{{ csrf_field() }}
	        <label>No.</label><br>
	        <input type="text" name="folio_factura" class="form-control" required><br>
	        <label>Archivo XML</label><br>
	        <input type="file" name="xml" class="form-control" required><br>
	        <label>Archivo PDF</label><br>
	        <input type="file" name="pdf" class="form-control" required><br>
	        <label>Fecha de Pago</label><br>
	        <input type="text" name="fecha_propuesta_pago" class="form-control" required><br>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
	        <button type="submit" class="btn btn-primary">Generar Pago</button>
	      </div>
	  </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" id="pagos_final" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
    	<form id="form_xml_pdf" accept-charset="UTF-8" enctype="multipart/form-data">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title">Pago de Actor</h4>
	      </div>
	      <div class="modal-body">
	      	{{ csrf_field() }}
	        <label>Fecha del pago realizado</label><br>
	        <input type="text" name="fecha_pago_realizado" class="form-control" required><br>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
	        <button type="submit" class="btn btn-primary">Generar Pago</button>
	      </div>
	  </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

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

			$('input[name=fecha_propuesta_pago], input[name=fecha_pago_realizado]').datepicker({
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
					url: "{{url('mgcontabilidad/get-pagos-actores')}}",
					type: "POST",
					data: $( this ).serialize(),
					success: function(data){
						
						if(data.code == 200){
							console.log(data);
							var pago = {};
							var send_pago = {};
							var send_pago_demo = {};
							var id = '';
							var pago_loops = '';
							var p = 0;

							for(var j=0; j<data.actores.length; j++){
								p += parseFloat(data.actores[j].pago_total_loops);
								pago[data.actores[j].id] = data.actores[j].pago_total_loops;
							}

							for(var j=0; j<data.actores.length; j++){
								send_pago[data.actores[j].id] =  {'personaje': data.actores[j].descripcion, 'capitulo': data.actores[j].capitulo, 'director': data.actores[j].director, 'sala': data.actores[j].sala, 'loops': data.actores[j].loops, 'fecha': data.actores[j].cita_end, 'importe': data.actores[j].pago_total_loops};
								send_pago_demo[data.actores[j].id] =  {'personaje': data.actores[j].descripcion, 'capitulo': data.actores[j].capitulo, 'director': data.actores[j].director, 'sala': data.actores[j].sala, 'loops': data.actores[j].loops, 'fecha': data.actores[j].cita_end, 'importe': data.actores[j].pago_total_loops};
							}

							p = 'Por pagar: $' + Math.round(parseFloat(p) * 100) / 100;

							$('.detalle').html('<div class="col-sm-12 col-md-12 col-lg-12">\
								<div class="col-sm-2"><button id="btn-pago" data-toggle="modal" data-target="#pagos" class="btn btn-success">Subir XML y PDF</button> </div>\
							<div class="col-sm-2"><button id="btn-correo" class="btn btn-info">Enviar Correo</button></div>\
							<div class="col-sm-2"><button id="btn-pago" data-toggle="modal" data-target="#pagos_final" class="btn btn-success">Pago de Factura</button> </div>\
							<h2 style="padding-left: 58%;">'+p+'</h2>\
		            		<table id="table_nomina" \
		            		class="table table-striped table-bordered table-hover">\
							<thead>\
								<tr>\
								<th>Nombre</th>\
								<th>Personaje</th>\
								<th>Director</th>\
								<th>Sala</th>\
								<th>Loops</th>\
								<th>Fecha</th>\
								<th>Pago</th>\
								<th>Importe</th>\
								<th>Estatus</th>\
								</tr>\
							</thead>\
							<tbody>'+allDataActor(data)+'\
							</tbody>\
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
									}
								});
						}

						

						$('.chk_pago').on('click', function(e){
							id = $(this).attr('data-id');
							pago_loops = $(this).attr('data-total');

							if(!pago[id]){
								pago[id] = pago_loops;
								send_pago[id] = send_pago_demo[id];
							} else {
								delete pago[id];
								delete send_pago[id];
							}

							if(Object.keys(pago).length < 1){
								$('#btn-pago').css('display', 'none');
							} else {
								$('#btn-pago').css('display', 'block');
							}
							var p = 0;
							for (value in pago){
								p +=  parseFloat(pago[value]);
							}

							p = 'Por pagar: $' + Math.round(p * 100) / 100;

							$('h2').html(p);

							$('#btn-pago').on('click', function(){
								console.log('submit');
							});

						});
						//Enviar Correo
						$('#btn-correo').on('click', function(){
							var confirmacion = confirm('Requieres enviar Correo para informar el pago.');
							$(".loader").fadeIn();
							if( confirmacion == true ){
								$.ajax({
									url: "{{ url('mgcontabilidad/send-email-pagos') }}",
									type: "POST",
									data: {_token: "{{ csrf_token() }}", data: send_pago, pago: p},
									success: function(data){
										$(".loader").fadeOut("slow");
										alert("El correo se envio con éxito");
										console.log(data);
									}
								});
							} else {
								alert('Envio de correo cancelado.');
							}

						});
						//Subir archivo XML y PDF
						$('#form_xml_pdf').on('submit', function(e){
							e.preventDefault();
							$(".loader").fadeIn();
							$.ajax({
								url: "{{ url('mgcontabilidad/save-files-pagos') }}",
								type: "POST",
								data: $( this ).serialize(),
								success: function(data1){
									if( data1.code == 200){
										$.ajax({
											url: "{{ url('mgcontabilidad/update-status-pagos') }}",
											type: "POST",
											data: {_token: "{{ csrf_token() }}", data: send_pago},
											success: function(data2){
												$(".loader").fadeOut("slow");
												console.log(data2);
												$('#pagos').modal('toggle');
											}
										});
									}
								}
							});
						});

					},
					error: function(error){
						console.log(error);
					}
				});
			})
		});

		function allDataActor(data){
			
			var datos = '';
			for(var i=0; i<data.actores.length; i++){
				datos += "<tr>";
				datos += "<td>"+data.actores[i].nombre_real+"</td>";
				datos += "<td>"+data.actores[i].descripcion+"</td>";
				datos += "<td>"+data.actores[i].director+"</td>";
				datos += "<td>"+data.actores[i].sala+"</td>";
				datos += "<td>"+data.actores[i].loops+"</td>";
				var fecha = data.actores[i].cita_end;
				fecha = fecha.split(" ");
				datos += "<td>"+fecha[0]+"</td>";
				datos += "<td ><input type='checkbox' checked class='chk_pago' data-id='"+data.actores[i].id+"' data-total='"+data.actores[i].pago_total_loops+"'></td>";
				datos += "<td>$"+data.actores[i].pago_total_loops+"</td>";
				datos += "<td>"+data.actores[i].estatus_pago+"</td>";

				datos += "</tr>";

			}

			return datos;
		}
	</script>
@stop
