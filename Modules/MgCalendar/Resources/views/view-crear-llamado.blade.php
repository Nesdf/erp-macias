@extends('layouts.app')

@section('content')

<style type="text/css">
/*No permite cambiar la hora arrastrando el*/
  .fc-resizer.fc-end-resizer {
    display: none;
}
input.tipo_numero{
  width: 42px;
  border: 1px solid white;
  outline: none;
}
.mostrarPanel{
  display: none;
}
</style>
    <div class="page-header">
              <h1>
                Calendario
                <small>
                  <i class="ace-icon fa fa-angle-double-right"></i>
                  de llamados.
                </small>
              </h1>
              <form>
                <div class="col-md-4">
                  <label>Proyectos:</label>
                  <select class="form-control" id="proyecto_id" selectpicker" name="cliente" data-style="btn-primary" data-show-subtext="true" data-live-search="true" title="Seleccionar...">
                    <option value="">Seleccionar</option>
                    @foreach($proyectos as $proyecto)
                        <option value="{{$proyecto->id}}">{{$proyecto->titulo_original}}</option>
                    @endforeach
                  </select>
                  <div id="list_episodios"></div>
                  <div id="name_sala"></div>

                </div>
              </form>
            </div><!-- /.page-header -->

            <div class="col-md-12 mostrarPanel">
              <br>
            <div class="col-md-4">
              <div class="panel panel-primary">
                <div class="panel-heading">
                  <h3 class="panel-title">Agendar llamados</h3>
                </div>
                <div class="panel-body">
                  <div >                         
                         
                         <form id="form-llamado" class="no-margin">
                          <label> Fecha: &nbsp;</label><br>
                          <input type="text" name="dia" class="form-control" required><br>
                            {{ csrf_field() }}
                            <input type="hidden" name="proyecto" />
                            <input type="hidden" name="episodio" />
                            <input type="hidden" name="sala" />
                            <!--<input type="hidden" name="dia" id="dia" />-->
                            <input type="hidden" name="folio" id="folio" />
                            <input type="hidden" name="nombre_real" id="nombre_real"/>
                            <input type="hidden" name="capitulo" id="capitulo"/>
                            <input type="hidden" name="fecha" id="fecha" />
                            <label> Actor: &nbsp;</label>
                            <select class="form-control actor" name="actor" id="actor" data-style="btn-primary" data-show-subtext="true" data-live-search="true" title="Seleccionar..." required>
                            <option value="">Selecccionar</option>
                            @foreach($actores as $actor)
                             <option value="{{$actor->nombre_artistico}}" data-id="{{$actor->id}}">{{$actor->nombre_artistico}}</option>
                            @endforeach
                            </select>
                            <label> Credencial: &nbsp;</label>
                            <select class="form-control credencial" name="credencial" id="credencial" required>
                            <option value="">Selecccionar</option>
                            </select>
                            <label> Director: &nbsp;</label>
                            <input type="text" name="director"  class="form-control" readonly>
                            <label>Loops</label>
                            <input type="number" min="1" name="loops" class="form-control" required>
                            <hr>
                            <div class="form-group">
                            <input type="hidden" name="episodio_folio" value="'+data.folio+'">
                            Hora de Entrada:
                            <input type="number" name="hora_entrada" id="hora_entrada" class="tipo_numero" min="00" max="23"  required> : <input type="number" name="min_entrada" class="tipo_numero" min="00" max="59" required>
                            </div>
                            Hora de Salida:
                            <input type="number" name="hora_salida" class="tipo_numero" min="00" max="23" required> : <input type="number" name="min_salida" class="tipo_numero" min="00" max="59" required>
                            <br><br>
                            <div class="alert alert-warning">
                            <label>
                            <input type="checkbox" name="estatus_grupo"> Permitir varios actores en el mismo horario
                            </label>
                            </div>
                            <br><label>Personaje: </label>
                            <div id="eliminar_select"><select name="personaje" class="form-control" data-style="btn-primary" data-show-subtext="true" data-live-search="true" title="Seleccionar..."  required>
                            </select></div>
                            <div class="personaje"> </div>
                            <div class="msj-error" ></div>
                            <br><br><button type="submit" class="btn btn-sm btn-success submit_cita"><i class="ace-icon fa fa-check"></i> Guardar</button>
                         </form>
                       </div>
                       <div class="modal-footer">
                        <button type="button" class="btn btn-sm" data-dismiss="modal"><i class="ace-icon fa fa-times"></i> Cancelar</button>
                       
                    </div>
                </div>
              </div>
            </div>
            <div class="col-md-8">
              <div class="panel panel-info">
                <div class="panel-heading">
                  <h3 class="panel-title">Lista de llamados</h3>
                </div>
                <div class="panel-body">
                  <div id="foo">

                  </div>
                </div>
              </div>
            </div>
            </div>

            <div class="row">
              <div class="col-xs-12">
                <!-- PAGE CONTENT BEGINS -->
                <div class="row">
                  <div class="col-sm-12">
                     <div id="reload" class="center" ></div>
                  </div>

                  <!--<div class="col-sm-3">
                    <div class="widget-box transparent">
                      <div class="widget-header"></div>

                      <div class="widget-body">
                      	<a href="#" class="btn btn-success">Agregar Actor</a>
                      </div>
                    </div>
                  </div>
                </div>-->

                <!-- PAGE CONTENT ENDS -->
              </div><!-- /.col -->
            </div><!-- /.row -->
          </div>
@stop

@section('modales')
@stop

@section('script')
	 <script type="text/javascript">
    $(document).on('ready', function(){
      $( '#proyecto_id' ).on('change', function(){
        $(".loader").fadeIn();
        var id = $(this).val();
        if(id != 'Seleccionar'){
          $.ajax({
            url: "{{ url('mgcalendar/list_episodios') }}" + '/' +id,
            type: "GET",
            success: function( data ){
              var dataAll = data;
              $(".loader").fadeOut("slow");
              console.log("LIST EPISODIOS: " + JSON.stringify(data));
              if(data.msg.length > 0){
                $('#list_episodios').html('<br><label>Episodio: </label><br><select id="data_episodios" class="form-control" data-style="btn-primary" data-show-subtext="true" name="ajaxEpisodio" data-live-search="true" title="Seleccionar..." >\
                        <option value="">Seleccionar...</option>\
                      </select>');
                for(var i=0;  i < data.msg.length; i++ ){
                  $("#data_episodios").append('<option value="'+ data.msg[i].salaId + '" data-id="'+data.msg[i].id+'">' + data.msg[i].titulo_original+ ' - ' + data.msg[i].num_episodio + '</option>');
                }
                $('select[name=ajaxEpisodio]').selectpicker();

                $( '#data_episodios' ).on('change', function(){
                  $(".loader").fadeIn();
                    var id = $(this).val();
                    var id_episodio = $(this).find(':selected').data('id');
                    var dataDB = new Array();
                  $.ajax({
                    url: "{{ url('mgcalendar/list_salas') }}" + '/' + id + '/' + id_episodio,
                    type: "GET",
                    success: function( data ){
                      //console.log("LIST SALAS: " + JSON.stringify(data['director']));
                      console.log("LIST SALAS: " + JSON.stringify(data));
                      var proyecto = $('#proyecto_id option:selected').text();
                      var episodio = $('#data_episodios option:selected').text();
                      var sala = $('#data_sala').text();
                      $(".loader").fadeOut("slow");
                      $('.mostrarPanel').css({display: 'block'});
                      $('input[name=director]').val(data['director']);
                      $('input[name=proyecto]').val(proyecto);
                      $('input[name=episodio]').val(episodio);
                      $('input[name=sala]').val(data['msg'][0]['sala']);
                      //$('input[name=dia]').val($('input[name=dateNow]').val());
                      //console.log("DATENOW: " + $('input[name=dateNow]').val());
                      $('input[name=folio]').val(data['folio']);
                      $('input[name=nombre_real]').val(dataAll['msg'][0]['titulo_original']);
                      $('input[name=capitulo]').val(['capitulo']);
                      $('input[name=fecha]').val(dataAll['msg'][0]['date_entrega']);
                      $('div#reload').html('');
                        $('#name_sala').html('<h3 style="text-align: center;" ><strong>Estudio: </strong> '+data.estudio+' </h3>\
                        <h3 style="text-align: center;" ><strong>Sala:</strong> <span id="data_sala">'+data.msg[0].sala+'</span></h3>'); 

                        $('select[name=actor]').on('change', function(){
                          var id_val = $(this).find(':selected').data('id');
                          $.ajax({
                            url: '{{url("mgcalendar/credenciales-actores")}}'+'/'+id_val,
                            type: 'GET',
                            success: function(data){
                              $(".credencial").html('');
                              $('input[name=nombre_real]').val(data.nombre_real.nombre_completo);
                              $(".credencial").html('<option value="">Seleccionar...</option>');
                              for(var i=0;  i < data.credenciales.length; i++ ){
                                $(".credencial").append('<option value='+ data.credenciales[i].folio + '>' + data.credenciales[i].folio +'</option>');
                              }
                            }
                          });
                        });

                        $('select[name=actor], select[name=personaje]').selectpicker();
                      $('input[name=dia]').datepicker({
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

                      $.ajax({
                        url: "{{ url('mgcalendar/ajax-get-personajes') }}",
                        type: 'GET',
                        success: function(data){
                          if(data.msg == 'success'){
                            var valuePersonajes = "";
                            console.log(data);
                            for(var i=0; i<data.actores.length; i++){
                              valuePersonajes += '<option value="'+data.actores[i].personaje+'"> '+data.actores[i].personaje+'</option> ';
                            }
                            valuePersonajes += '<option value="otro">Otro</option>';
                            $('select[name=personaje]').append(valuePersonajes).selectpicker('refresh');

                            $('select[name=personaje]').on('change', function(){

                              if($(this).val() == 'otro'){

                                $(this).removeAttr('required');
                                $(this).attr('disabled', true);
                                $('.personaje').html('\
                                  <label>Agregar nuevo personaje</label>\
                                  <input name="nuevo_personaje" class="form-control" required>\
                                  <label> Fijo\
                                  <input type="checkbox" name="fijo" >\
                                  </label> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;\
                                  <label> Cine\
                                  <input type="checkbox" name="proyecto" >\
                                  </label><br>\
                                  <a href="javascript:void(0)" class="cancelar btn bt-info">Cancelar</a>\
                                ');
                              } else {
                                $('.personaje').html('');
                              }

                              $('.cancelar').on('click', function(){
                                $('.personaje').html('');
                                $('select[name=personaje]').attr('required', true);
                                $('select[name=personaje]').removeAttr('disabled');
                              });

                            });
                            //$('select[name=personaje]').selectpicker('refresh');
                          }
                        },
                        beforeSend: function() {
                            $(".loader").fadeIn();
                        },
                        complete: function() {
                            $(".loader").fadeOut("slow");
                        },
                        error: function(error){

                        }
                      });


                      //Guardar datos
                      $('#form-llamado').on('submit', function(ev){
                        ev.preventDefault();
                        
                        $.ajax({
                          url: '{{url("mgcalendar/cita-llamado")}}',
                          type: 'POST',
                          data: $( this ).serialize(),
                          success: function(data){
                            console.log("MIDATA: " + JSON.stringify(data))
                            $('.eliminar_select').remove();
                            var inicio = String(data.start);
                            var fin = String(data.end);
                            var start = inicio.split(" ");
                            var end = fin.split(" ");

                            dataDB.push( data );

                            var foo = dataDB.map(function(data){
                                return '<li>'+data.actor+' '+data.start+'</li>';
                              })
                              document.getElementById("foo").innerHTML = foo;

                            //modal.modal("hide");

                            /*calendar.fullCalendar('renderEvent',
                              {
                                title: data.actor,
                                start: data.start,
                                end: data.end,
                                className: 'label-primary',
                                descripcion: data.actor + ' <br> Entrada: ' + start[1] + ':00' + '<br> Salida: '+  end[1] + ':00'
                              },
                              false // make the event "stick"
                            );*/
                          },
                          beforeSend: function() {
                            $(".submit_cita").attr("disabled");
                            $(".loader").fadeIn();
                          },
                          complete: function() {
                            $(".submit_cita").removeAttr("disabled");
                            $(".loader").fadeOut("slow");
                          },
                          error: function(error){
                            $('.msj-error').html('<div class="alert alert-danger" role="alert">'+error.responseJSON.error+'</div>')
                            if(error.status == 400){
                              //modal.find('.msj-error').html('<div class="alert alert-danger" role="alert">'+error.responseJSON.error+'</div>');
                            }

                            if(error.status == 401){
                              //modal.find('.msj-error').html('<div class="alert alert-danger" role="alert">'+error.responseJSON.error+'</div>');
                            }

                            if(error.status == 404){
                              //modal.find('.msj-error').html('<div class="alert alert-danger" role="alert">Este horario ya se encuentra ocupado.</div>');
                            }

                          }
                        });
                      })
                    }
                  });

                });
              }
            }
          });
        }

      });
    });
    $('select[name=cliente]').selectpicker();
   </script>
@stop
