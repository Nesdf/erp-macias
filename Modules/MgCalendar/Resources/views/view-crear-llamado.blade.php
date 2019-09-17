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
.panel-personajes {
  overflow:scroll;
  height:290px;
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
              <br>
              <div class="col-md-12" id="msgSuccess"></div>
              <div class="col-md-4">
              <form><br><br>
                  <label>Proyectos:</label>
                  <select class="form-control" id="proyecto_id" selectpicker" name="cliente" data-style="btn-primary" data-show-subtext="true" data-live-search="true" title="Seleccionar...">
                    <option value="">Seleccionar</option>
                    @foreach($proyectos as $proyecto)
                        <option value="{{$proyecto->id}}">{{$proyecto->titulo_original}}</option>
                    @endforeach
                  </select>
                  <div id="list_episodios"></div>
                  <div id="name_sala"></div>
              </form>
              </div>
              <div class="col-md-8">
                <br><br>
                <div class="panel panel-success panel-personajes">
                  <div class="panel-heading">
                    <h3 class="panel-title">Lista de Personajes</h3>
                  </div>
                  <div class="panel-body">
                      <input class="form-control" id="myInput" type="text" placeholder="Buscar personaje...">
                      <br>
                    <table class="table table-condensed" id="table-personajes">
                      <thead>
                        <tr>
                          <th>Nombre</th>
                          <th>Loops</th>
                          <th>Asignado</th>
                          <th>Agregar Personaje</th>
                        </tr>
                      </thead>
                      <tbody>

                      </tbody>
                      <!--<tr>
                        <td>Nestor</td>
                        <td>34</td>
                        <td><a href="javascript:void(0)" onclick="myFunction()">Agregar</a></td>
                      </tr>-->
                      <div id="mostrarActores">

                      </div>
                    </table>
                  </div>
                </div>
              </div>
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
                          <input type="text" name="dia" autocomplete="off" class="form-control" required><br>
                            {{ csrf_field() }}
                            <input type="hidden" name="proyecto" />
                            <input type="hidden" name="episodio" />
                            <input type="hidden" name="sala" />
                            <input type="hidden" name="episodio_folio"  />
                            <input type="hidden" name="folio" id="folio" />
                            <input type="hidden" name="nombre_real" id="nombre_real"/>
                            <input type="hidden" name="capitulo" id="capitulo"/>
                            <input type="hidden" name="fecha" id="fecha" />
                            <input type="hidden" name="ids" />
                            <label> Actor: &nbsp;</label>
                            <select class="form-control" name="actor" id="actor" data-style="btn-primary" data-show-subtext="false" data-live-search="true" title="Seleccionar..." required>
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
                            <input type="number" min="1" name="loops" class="form-control" autocomplete="off" required readonly><!--Agregar readonly-->
                            <hr>
                            <div class="form-group">
                            <input type="hidden" name="episodio_folio" >
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
                            <label>
                            <input type="checkbox" name="fijo"> Personaje fijo
                            </label>
                            </div>
                            <br><label>Personaje: </label>
                            <input type="text" class="form-control readonly" name="personaje" autocomplete="off" required>
                            <!--<div id="eliminar_select"><select name="personaje" class="form-control" data-style="btn-primary" data-show-subtext="true" data-live-search="true" title="Seleccionar..."  required>
                            </select></div>-->
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
                  <div id="foo"></div>
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

      $(".readonly").keydown(function(e){
          e.preventDefault();
      });

      $('body').on('click', '.datos_personajes', function(){
        $('input[name=loops]').val($(this).data('loops'));
        $('input[name=personaje]').val($(this).data('personaje'));
        $('input[name=episodio_folio]').val($(this).data('folio'));
        //alert($(this).data('folio'));
      })

      var dataDB = new Array();
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
              //console.log("LIST EPISODIOS: " + JSON.stringify(data));
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
                    $('#foo').empty();
                    console.log("Data 1" + dataDB.length);
                    dataDB =  [];
                    console.log("Data 2" + dataDB.length);
                    console.log(id +" - "+id_episodio);
                  $.ajax({
                    url: "{{ url('mgcalendar/list_salas') }}" + '/' + id + '/' + id_episodio,
                    type: "GET",
                    success: function( data ){
                      console.log("PRUEBA: " + JSON.stringify(data));
                      //console.log("LIST SALAS: " + JSON.stringify(data['director']));
                      //console.log("LIST SALAS: " + JSON.stringify(data));
                      var proyecto = $('#proyecto_id option:selected').text();
                      var episodio = $('#data_episodios option:selected').text();
                      var sala = $('#data_sala').text();
                      $(".loader").fadeOut("slow");
                      $('.mostrarPanel').css({display: 'block'});
                      $('input[name=director]').val(data['director']);
                      $('input[name=proyecto]').val(proyecto);
                      $('input[name=episodio]').val(episodio);
                      $('input[name=sala]').val(data['msg'][0]['sala']);

                      var table = $("#table-personajes tbody");
                      var asignado ='';
                      table.html('');
                      console.log(data['actores']);
                      $.each(data['actores'], function(idx, elem){
                        id_personaje = elem['id'];

                          if( elem.asignado == false){
                            asignado = '<i class="glyphicon glyphicon-remove"></i>';
                            table.append("<tr><td>"+elem.personaje+"</td><td>"+elem.loops+"</td>><td>"+asignado+"</td><td id='"+elem.id+"'><input type='checkbox' class='datos_personajes' data-personaje='"+elem.personaje+"' data-id='"+elem.id+"' data-loops='"+elem.loops+"' data-folio='"+elem.episodio_folio+"'></td></tr>");
                          } else if( elem.asignado == true ) {
                            asignado = '<i class="glyphicon glyphicon-ok"></i>';
                            table.append("<tr><td>"+elem.personaje+"</td><td>"+elem.loops+"</td>   <td>"+asignado+"</td><td>Asignado</td></tr>");
                          }


                          $("#myInput").on("keyup", function() {
                            var value = $(this).val().toLowerCase();
                            $("#table-personajes tr").filter(function() {
                              $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                            });
                          });
                          
                      });

                      //Permite agregar a los actores en arreglo,
                      //Ademas de sumar los loops por cada vez que se seleccione un checkbox
                      var datosLoops = 0;
                      var datosPersonajes = [];
                      var idsPersonajes = [];
                      $('.datos_personajes').on('change', function(){
                        if( $(this).is(':checked') ){
                          datosLoops += parseInt( $(this).data('loops') );
                          datosPersonajes.push( " "+$(this).data('personaje') );
                          idsPersonajes.push( $(this).data('id') );
                          $( 'input[name=loops]' ).val(datosLoops);
                          $( 'input[name=personaje]' ).val(datosPersonajes);
                          $( 'input[name=ids]' ).val(idsPersonajes);
                        } else{
                          datosLoops -= parseInt( $(this).data('loops') );
                          var i = datosPersonajes.indexOf(" "+$(this).data('personaje'));
                          if(i != -1) {
                            datosPersonajes.splice(i, 1);
                          }
                          var j = idsPersonajes.indexOf($(this).data('id'));
                          if(j != -1) {
                            idsPersonajes.splice(j, 1);
                          }
                          $( 'input[name=loops]' ).val(datosLoops);
                          $( 'input[name=personaje]' ).val(datosPersonajes);
                          $( 'input[name=ids]' ).val(idsPersonajes);
                        }
                      });

                      //$('input[name=dia]').val($('input[name=dateNow]').val());
                      //console.log("DATENOW: " + $('input[name=dateNow]').val());
                      $('input[name=folio]').val(data['folio']);
                      $('input[name=episodio_folio]').val(data['folio']);
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


                      //Guardar datos
                      $('#form-llamado').on('submit', function(ev){
                        ev.preventDefault();
                        
                        $.ajax({
                          url: '{{url("mgcalendar/cita-llamado")}}',
                          type: 'POST',
                          data: $( this ).serialize(),
                          success: function(data){
                            //Se agrega mensaje de guardado exitoso por medio de una variable flash
                            $(".loader").fadeOut("slow");
                            $('#msg').remove();
                            $('#msgSuccess').prepend('<div id="msg" class="alert alert-success">Se generó la cita con éxito.</div>');
                            $('.eliminar_select').remove();
                              datosLoops = 0;
                             // alert("Guardado Exitosamente");
                              dataDB.push( data );

                              /*var foo = dataDB.map(function(data){
                                return '<li>'+data.actor+' | '+data.start+'</li>';
                              })*/
                              $('#foo').html('');
                              for( var i = 0;   i < dataDB.length ; i++  ){
                                $('#foo').append('<li>' + dataDB[i].actor + ' | ' + dataDB[i].start + '</li>');
                              }
                             // document.getElementById("foo").innerHTML = foo; 
                             var ids_actores = $('input[name=ids]').val();
                             var idsPersonajesSuccess = ids_actores.split(",");


                            $('input[name=dia]').val('');
                            $('input[name=ids]').val('');
                            $('select[name=actor]').val('').selectpicker('refresh');
                            $('select[name=credencial]').val('');
                            $('input[name=hora_entrada]').val('');
                            $('input[name=min_entrada]').val('');
                            $('input[name=loops]').val(0);
                            $('input[name=personaje]').val('');
                            $('input[name=hora_salida]').val('');
                            $('input[name=min_salida]').val('');
                            $('select[name=personaje]').val('').selectpicker('refresh');
                            $('.personaje').html('');
                            $('.msj-error').html('');

                            $.ajax({
                                url: "{{ url('mgcalendar/ajax-get-personajes') }}",
                                type: 'GET',
                                success: function(data){
                                  if(data.msg == 'success'){
                                    for( var i=0; i<idsPersonajesSuccess.length; i++ ){
                                      $('#'+idsPersonajesSuccess[i]).html('Asignado');
                                    }

                                    var valuePersonajes = "";
                                    //console.log(data);
                                    for(var i=0; i<data.actores.length; i++){
                                      valuePersonajes += '<option value="'+data.actores[i].personaje+'"> '+data.actores[i].personaje+'</option> ';
                                    }
                                    valuePersonajes += '<option value="otro">Otro</option>';
                                    $('select[name=personaje]').append(valuePersonajes).selectpicker('refresh');

                                    $('select[name=personaje]').on('change', function(){

                                      if($(this).val() == 'otro'){

                                        $(this).removeAttr('required');
                                        //$(this).attr('disabled', true);

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
   <!--Funciones-->
@stop
