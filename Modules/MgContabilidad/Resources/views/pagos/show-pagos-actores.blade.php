@extends('layouts.app')
@section('css')
	<li>
		<i class="ace-icon fa fa-users"></i>
		<a href="{{ url('mgclientes') }}">Pagos Realizados</a>
	</li>
@stop

@section('guia')
	<li>
		<i class="ace-icon fa fa-users"></i>
		<a href="{{ url('mgclientes') }}">Pagos realizados de Actores</a>
	</li>
@stop

@section('content')
    <div class="row">
		<div class="col-xs-12">
			<!-- PAGE CONTENT BEGINS -->
			<div class="row">
				<div class="col-xs-12">
					<h3 class="header smaller lighter blue">Pagos realizados de Actores</h3>
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



@stop

@section('script')
	<script type="text/javascript">
		$(document).on('ready', function(){

			$('#form_search').on('submit', function(event){
				event.preventDefault();
				$.ajax({
					url: "{{url('mgcontabilidad/get-pagos-completado-actores')}}",
					type: "POST",
					data: $( this ).serialize(),
					success: function(data){
						
						if(data.code == 200){

							$('.detalle').html('<div class="col-sm-12 col-md-12 col-lg-12">\
		            		<table id="table_nomina" \
		            		class="table table-striped table-bordered table-hover">\
							<thead>\
								<tr>\
								<th>Nombre</th>\
								<th>Folio</th>\
								<th>Fecha de Pago</th>\
								<th>Total</th>\
								<th>Archivos</th>\
								</tr>\
							</thead>\
							<tbody>\
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
			for(var i=0; i<data.actores.length; i++){
				datos += "<tr>";
				datos += "<td>"+data.actores[i].nombre_real+"</td>";
				datos += "<td>"+data.actores[i].nombre_actor+"</td>";
				datos += "<td>"+data.actores[i].folio+"</td>";
				datos += "<td>"+data.actores[i].director+"</td>";
				datos += "<td>"+data.actores[i].sala+"</td>";
				datos += "<td>"+data.actores[i].loops+"</td>";

				datos += "</tr>";

			}

			return datos;
		}
	</script>
@stop
