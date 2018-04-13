@extends('layouts.app')
@section('css')
	<li>
		<i class="ace-icon fa fa-users"></i>
		<a href="{{ url('mgclientes') }}">Estatus de Pagos de Actores</a>
	</li>
@stop

@section('guia')
	<li>
		<i class="ace-icon fa fa-users"></i>
		<a href="{{ url('mgclientes') }}">Estatus de Pagos de Actores</a>
	</li>
@stop

@section('content')
    <div class="row">
		<div class="col-xs-12">
			<!-- PAGE CONTENT BEGINS -->
			<div class="row">
				<div class="col-xs-12">
					<h3 class="header smaller lighter blue">Estatus de Pagos de Actores</h3>
					<form id="form_search">
						{{ csrf_field() }}
						<div class="col-md-3">
							<label>Estatus</label>
							<select class="form-control selectpicker" name="status_search" data-style="btn-primary" data-show-subtext="true" data-live-search="true" title="Seleccionar..." required>
								<option value="No Pagado">No Pagado</option>
								<option value="Correo Enviado">Correo Enviado</option>
								<option value="Tránsito a Pago">Tránsito a Pago</option>
								<option value="Pagado">Pagado</option>
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

			$('#form_search').on('submit', function(event){
				event.preventDefault();
				$(".loader").fadeIn();
				$.ajax({
					url: "{{url('mgcontabilidad/get-pagos-status-actores')}}",
					type: "POST",
					data: $( this ).serialize(),
					success: function(data){
						console.log(data);
						$(".loader").fadeOut('slow');
						if(data.code == 200){

							$('.detalle').html('<div class="col-sm-12 col-md-12 col-lg-12">\
		            		<table id="table_nomina" \
		            		class="table table-striped table-bordered table-hover">\
							<thead>\
								<tr>\
									<th>Nombre</th>\
									<th>Personaje</th>\
									<th>Director</th>\
									<th>Sala</th>\
									<th>Estudio</th>\
									<th>Proyecto</th>\
									<th>Episodio</th>\
									<th>Loops</th>\
									<th>Fecha</th>\
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

					},
					error: function(error){
						console.log(error);
					}
				});
			});
		});

		function allDataActor(data){
			
			var datos = '';
			for(var i=0; i<data.estatus.length; i++){
				datos += "<tr>";
				datos += "<td>"+data.estatus[i].nombre_real+"</td>";
				datos += "<td>"+data.estatus[i].descripcion+"</td>";
				datos += "<td>"+data.estatus[i].director+"</td>";
				datos += "<td>"+data.estatus[i].sala+"</td>";
				datos += "<td>"+data.estatus[i].estudio+"</td>";
				datos += "<td>"+data.estatus[i].titulo_proyecto+"</td>";
				datos += "<td>"+data.estatus[i].num_episodio+"</td>";
				datos += "<td>"+data.estatus[i].loops+"</td>";
				var fecha = data.estatus[i].cita_end;
				fecha = fecha.split(" ");
				datos += "<td>"+fecha[0]+"</td>";
				datos += "<td>$"+data.estatus[i].pago_total_loops+"</td>";
				datos += "<td>"+data.estatus[i].estatus_pago+"</td>";

				datos += "</tr>";

			}

			return datos;
		}
	</script>
@stop
