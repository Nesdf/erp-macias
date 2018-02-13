@extends('layouts.app')

@section('guia')
	<li>
		<i class="ace-icon fa fa-users"></i>
		<a href="{{ url('mgcontabilidad/reporte-proyectos') }}">Detalle de trabajo por actor</a>
	</li>
@stop

@section('content')

	<div class="row">
		<div class="col-xs-12">
			<h3 class="header smaller lighter blue">Detalle de Trabajo por Actor</h3>
			<div class="clearfix">
				<div class="pull-right tableTools-container"></div>
			</div>

			<!-- div.table-responsive -->

			<!-- div.dataTables_borderWrap -->
			<div id="formulario">
        <form id="form_search">
          <div class="col-md-4">
            <label>Fecha Inicial</label>
            <input type="text" name="inicial_search" class="form-control" required>
          </div>
          <div class="col-md-4">
          <label>Fecha Final</label>
          <input type="text" name="final_search" class="form-control" required>
        </div>
          {{ csrf_field() }}
          <div class="col-md-2">
            <br>
            <button type="submit" class="btn btn-primary btn-lg btn-block"><i class="glyphicon glyphicon-search"> </i> Buscar</button>
          </div>
          </div>
        </form>
			</div>
		</div>

    <div class="row">
      <div class="col-md-12">
        <div class="reporte"></div>
      </div>
    </div>
@stop

@section('modales')

@stop

@section('script')
	<script>
		$(document).on('ready', function(){
      $('input[name=inicial_search], input[name=final_search]').datepicker({
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
					url: "{{ url('mgcontabilidad/ajax-detalle-actores') }}",
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
				                  <th>Actor</th>\
				                  <th>Fecha</th>\
													<th>Proyecto</th>\
                          <th>Episodio</th>\
                          <th>Loop</th>\
				                  <th>Importe</th>\
				                </tr>\
				              </thead>\
				              <tbody>'+dataActores(data)+'\
				              </tbody>\
                      <tfoot>\
                        <tr>\
                            <th colspan="5" style="text-align:right">Total:</th>\
                            <th></th>\
                        </tr>\
                     </tfoot>\
				            </table>');
						}

						$('#table_proyectos').DataTable({
							"pageLength": 100,
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
                        .column( 5 )
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );

                    // Total over this page
                    pageTotal = api
                        .column( 5, { page: 'current'} )
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );

                    // Update footer
                    $( api.column( 5 ).footer() ).html(
                        //'$'+pageTotal +' ( $'+ total +' total)'
                        '$'+pageTotal.toFixed(2)
                    );
                }
						});

						function dataActores(data){
							if(data.data.length <= 0){
								return "";
							}
				      		var list_proyectos = '';
                  var date = '';
				      		for(var i=0; i<data.data.length; i++){
				      			list_proyectos += "<tr>";
				      			list_proyectos += "<td>"+data.data[i].nombre_real+"</td>";
                    date = data.data[i].cita_end;
                    date = date.split(" ");
				      			list_proyectos += "<td>"+date[0]+"</td>";
				      			list_proyectos += "<td>"+data.data[i].titulo_original+"</td>";
                    list_proyectos += "<td>"+data.data[i].num_episodio+"</td>";
                    list_proyectos += "<td>"+data.data[i].loops+"</td>";
                    list_proyectos += "<td>$"+data.data[i].pago_total_loops+"</td>";
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
