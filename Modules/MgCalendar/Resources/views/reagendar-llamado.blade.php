@extends('layouts.app')

@section('guia')
	<li>
		<i class="ace-icon fa fa-child"></i>
		<a href="{{url('mgcalendar/reagendar-llamado')}}">Re-agendar llamado</a>
	</li>
@stop

@section('content')
<div class="row">
<div class="col-xs-12">
  <!-- PAGE CONTENT BEGINS -->

  <div class="row">
    <div class="col-xs-12">
      <h3 class="header smaller lighter blue">Re-agendar llamado</h3>
			@if(Session::has('success'))
				<div class="alert alert-success">{{ Session::get('success') }}</div>
			@endif
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
            <label>Actor</label>
            <select name="search_actor" id="search_actor" selectpicker data-style="btn-primary" data-show-subtext="true" data-live-search="true" title="Seleccionar..." class="form-control" required>
              @foreach($actores as $item)
                <option {{$item->nombre_artistico}}>{{$item->nombre_artistico}}</option>
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
  <div class="modal fade" id="modal_reagendar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <h4 class="modal-title " id="myModalLabel">Re-agendar</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <form role="form" method="post" action="{{ url('/mgcalendar/save-llamado-reagendado') }}" >
            <div class="modal-body">
              {{ csrf_field() }}
              <input type="hidden" name="id" id="id">

              <label>Fecha: </label><br>
              <input type="text" name="new_date" id="new_date" required><br><br>
            <label>Hora Entrada: </label><br>
            <input type="number" name="hora_entrada" id="hora_entrada" class="tipo_numero" min="00" max="23"  required> :
            <input type="number" name="min_entrada" class="tipo_numero" min="00" max="59" required>
            <br><br>
            <label>Hora Salida</label><br>
            <input type="number" name="hora_salida" class="tipo_numero" min="00" max="23" required> :
            <input type="number" name="min_salida" class="tipo_numero" min="00" max="59" required>
            </div>
           <div class="modal-footer">
             <button type="button" class="btn btn-default" data-dismiss="modal" >Cerrar</button>
             <button type="submit" class="btn btn-primary">Guardar</button>
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

        $('#form_search').on('submit', function(e){
            e.preventDefault();
          $.ajax({
                url: '{{url("mgcalendar/search-llamado-reagendado")}}',
                type: 'POST',
                data: $( this ).serialize(),
                success: function(data){

                  $('#list-table').html('<br><br>\
                    <table id="table_actores" \
                    class="table table-striped table-bordered table-hover">\
                    <thead>\
			                <tr>\
			                  <th>Actor</th>\
			                  <th>Director</th>\
                        <th>Capítulo</th>\
			                  <th>Loops</th>\
                        <th>Personaje</th>\
			                  <th>Entrada</th>\
			                  <th>Salida</th>\
                        <th>Acciones</th>\
			                </tr>\
			              </thead>\
			              <tbody> '+listaLlamdos(data)+'\
			              </tbody>\
                  </table>');

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

                  var d = new Date();
                  var h = d.getHours();
                  var m = d.getMinutes();
                  var h_entrada = $('input[name=hora_entrada]').val(h);
                  var h_salida = $('input[name=hora_salida]').val(h);
                  var m_entrada = $('input[name=min_entrada]').val(m);
                  var m_entrada = $('input[name=min_salida]').val(m);

                  //Si se modifica la hora de entrada, se modifica también la hora de salida
                    $('input[name=hora_entrada]').on('change', function(){

                      $('input[name=hora_salida]').val($(this).val());

                      var dia = end._d;
                      dia = String(dia).split(" ");

                      if( parseInt( $(this).val() ) < parseInt( h ) && parseInt( dia[2] ) == parseInt( d.getDate() ) ){
                        $(this).val(h);
                        $($('input[name=hora_salida]')).val(h);
                        alert('Hora fuera de horario.');
                      }
                    });
                  //Si se modifica los minutos de entrada, se modifica también los minutos de salida
                  $('input[name=min_entrada]').on('change', function(){
                    $('input[name=min_salida]').val($(this).val());
                  });
                   //Si se modifica la hora de salida y es menor a la de entrada, éste no se podrá modificar
                  $('input[name=hora_salida]').on('change', function(){
                    var salida = 0;
                    var entrada = 0;
                    salida = parseInt($(this).val());
                    entrada = parseInt($('input[name=hora_entrada]').val());
                    if( ( entrada - salida)  > 0  ){
                      $(this).val($('input[name=hora_entrada]').val());
                      alert('El tiempo debe ser mayor a la de entrada.');
                    }
                  });

                  $('input[name=min_salida]').on('change', function(){

                    if( parseInt( $('input[name=hora_salida]').val() ) == parseInt( $('input[name=hora_entrada]').val() )){
                      if( parseInt( $(this).val() ) < parseInt( $('input[name=min_entrada]').val() ) ) {
                        $('input[name=min_salida]').val($('input[name=min_entrada]').val());
                        alert('El tiempo de salida debe ser mayor a la de entrada.');
                      }
                    }
                  });

                  $('#new_date').datepicker({
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

                },
                error: function(error){
                  console.log(error);
                }
            });
        });

        //Ventana modal
        $('#modal_reagendar').on('shown.bs.modal', function(e){
          var id = $(e.relatedTarget).data().id;

          $('input[name=id]').val(id);

        });

				$('select[name=search_actor]').selectpicker();

    });

    function listaLlamdos(data){
      var filas = "";

      for(var i=0; i<data.msg.length; i++){
        var entrada;
        var strEntrada = data.msg[i].cita_start;
        var salida;
        var strSalida = data.msg[i].cita_end;

        entrada = strEntrada.split(' ');
        entrada = entrada[1].split(':');
        salida = strSalida.split(' ');
        salida = salida[1].split(':');

        filas += '<tr>';
        filas += '<td>'+data.msg[i].actor+'</td>';
        filas += '<td>'+data.msg[i].director+'</td>';
        filas += '<td>'+data.msg[i].capitulo+'</td>';
        filas += '<td>'+data.msg[i].loops+'</td>';
        filas += '<td>'+data.msg[i].descripcion+'</td>';
        filas += '<td>'+entrada[0]+':'+entrada[1]+'</td>';
        filas += '<td>'+salida[0]+':'+salida[1]+'</td>';
        filas += '<td><a href="javascript:void(0)" data-id="'+data.msg[i].id+'" data-toggle="modal" data-target="#modal_reagendar" title="Re-agendar"><i class="glyphicon glyphicon-book"></i></a></td>';
        filas += '</tr>';
      }
      return filas;
    }
  </script>
@stop
