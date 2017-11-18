@extends('layouts.app')

@section('content')
<style type="text/css">
/*No permite cambiar la hora arrastrando el*/
  .fc-resizer.fc-end-resizer {
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
                  <select class="form-control" id="proyecto_id">
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

            <div class="row">
              <div class="col-xs-12">
                <!-- PAGE CONTENT BEGINS -->
                <div class="row">
                  <div class="col-sm-12">
                     <div id="reload" class="center" ></div>
                    <div class="space"></div>

                    <div id="show-calendar">
                      <div id="calendario"></div>
                    </div>
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
@stop

@section('modales')


@stop

@section('script')
	<script type="text/javascript">
    $(document).on('ready', function(){

      $( '#proyecto_id' ).on('change', function(){
          var id = $(this).val();
          if(id != 'Seleccionar'){
            $.ajax({
              url: "{{ url('mgcalendar/list_episodios') }}" + '/' +id,
              type: "GET",
              success: function( data ){
                 if(data.msg.length > 0){
                    $('#list_episodios').html('<label>Episodio</label><br><select id="data_episodios" class="form-control">\
                        <option value="">Seleccionar...</option>\
                      </select>');
                    for(var i=0;  i < data.msg.length; i++ ){
                      $("#data_episodios").append('<option value="'+ data.msg[i].salaId + '" data-id="'+data.msg[i].id+'">' + data.msg[i].titulo_original+ ' - ' + data.msg[i].num_episodio + '</option>');
                    } 

                    // Sala
                    $( '#data_episodios' ).on('change', function(){
                        var id = $(this).val();
                        var id_episodio = $(this).find(':selected').data('id');

                        if(!id){
                          $('#show-calendar').html('');
                          $('#name_sala').html('');
                          return false;
                        }else{
                          $('#show-calendar').html('<div id="calendario"></div>');
                        }

                          $.ajax({
                            url: "{{ url('mgcalendar/list_salas') }}" + '/' + id + '/' + id_episodio,
                            type: "GET",
                            success: function( data ){
                              
                              $('div#reload').html('');
                               $('#name_sala').html('<h3 style="text-align: center;" ><strong>Sala:</strong> <span id="data_sala">'+data.msg[0].sala+'</span></h3>');

                               $('#external-events div.external-event').each(function() {

                                // create an Event Object (http://arshaw.com/fullcalendar/docs/event_data/Event_Object/)
                                // it doesn't need to have a start or end
                                var eventObject = {
                                  title: $.trim($(this).text()) // use the element's text as the event title
                                };

                                // store the Event Object in the DOM element so we can get to it later
                                $(this).data('eventObject', eventObject);

                                // make the event draggable using jQuery UI
                                $(this).draggable({
                                  zIndex: 999,
                                  revert: true,      // will cause the event to go back to its
                                  revertDuration: 0  //  original position after the drag
                                });
                                
                              });




                              /* initialize the calendar
                              -----------------------------------------------------------------*/

                              var date = new Date();
                              var d = date.getDate();
                              var m = date.getMonth();
                              var y = date.getFullYear();
                              var n = new Array();

                              var list_llamados = data[1];
                              function llamado(){
                                for(var i = 0; i < list_llamados.length; i++) {
                                  n.push(new Object(list_llamados[i]));
                                }
                                return n;
                              }

                              var calendar = $('#calendario').fullCalendar({
                                //isRTL: true,
                                //firstDay: 1,// >> change first day of week 
                                
                                buttonHtml: {
                                  prev: '<i class="ace-icon fa fa-chevron-left"></i>',
                                  next: '<i class="ace-icon fa fa-chevron-right"></i>'
                                },

                                allDayText: 'Horas',

                                buttonText: {
                                    today:'Hoy',
                                    month:    'Mes',
                                    week:     'Semana',
                                    day:      'Día'
                                },                              
                                header: {
                                  left: 'prev,next today',
                                  center: 'title',
                                  right: 'month,agendaWeek,agendaDay'

                                },
                                viewRender: function() {
                                  $(".fc-sun, .fc-mon, .fc-tue, .fc-wed, .fc-thu, .fc-fri, .fc-sat").css("color", "#000");
                                  $(".fc-sun").css("background-color", "#A9D0F5");
                                  $(".fc-mon").css("background-color", "#F781BE");
                                  $(".fc-tue").css("background-color", "#F6CECE");
                                  $(".fc-wed").css("background-color", "#F5D0A9");                                  
                                  $(".fc-thu").css("background-color", "#CEE3F6");
                                  $(".fc-fri").css("background-color", "#F5A9BC");
                                  $(".fc-sat").css("background-color", "#E0F8E6");
                                  $("table").css("border-collapse", "collapse");
                                  $("table, td, tr").css("border", "1px solid #555");
                                },
                                
                                events: llamado(),
                                eventAfterRender: function(event, element) {
                                  element.find('.fc-content').html(event.descripcion);
                                },
                                eventRender: function(event, element) {
                                  element.find('.fc-content').html(event.descripcion);
                                },
                                editable: true,
                                droppable: true, // this allows things to be dropped onto the calendar !!!
                                drop: function(date) { // this function is called when something is dropped
                                
                                  // retrieve the dropped element's stored Event Object
                                  var originalEventObject = $(this).data('eventObject');
                                  var $extraEventClass = $(this).attr('data-class');
                                  
                                  
                                  // we need to copy it, so that multiple events don't have a reference to the same object
                                  var copiedEventObject = $.extend({}, originalEventObject);
                                  
                                  // assign it the date that was reported
                                  copiedEventObject.start = date;
                                  copiedEventObject.allDay = false;
                                  if($extraEventClass) copiedEventObject['className'] = [$extraEventClass];
                                  
                                  // render the event on the calendar
                                  // the last `true` argument determines if the event "sticks" (http://arshaw.com/fullcalendar/docs/event_rendering/renderEvent/)
                                  $('#calendar').fullCalendar('renderEvent', copiedEventObject, true);
                                  
                                  // is the "remove after drop" checkbox checked?
                                  if ($('#drop-remove').is(':checked')) {
                                    // if so, remove the element from the "Draggable Events" list
                                    $(this).remove();
                                  }
                                  
                                },
                                selectable: true,
                                monthNames: [ "Enero","Febrero","Marzo","Abril","Mayo","Junio", "Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre" ],
                                monthNamesShort: [ "Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic" ],
                                dayNames: [ "Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado" ],
                                dayNamesShort: [ "Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab" ], // For formatting
                                dayNamesMin: [ "Do","Lu","Ma","Mi","Ju","Vi","Sa" ],
                                selectHelper: true,
                                select: function(start, end, allDay) {
                                  
                                  if(start.isBefore(moment())) {
                                    alert('No se puede agregar llamado en este día.');
                                      $('#calendar').fullCalendar('unselect');
                                      return false;
                                  }
                                  var proyecto = $('#proyecto_id option:selected').text();
                                  var episodio = $('#data_episodios option:selected').text();
                                  var sala = $('#data_sala').text();
                                  console.log(data);
                                  var modal = 
                                  '<div class="modal fade">\
                                    <div class="modal-dialog">\
                                     <div class="modal-content">\
                                     <div class="modal-body">\
                                       <button type="button" class="close" data-dismiss="modal" style="margin-top:-10px;">&times;</button>\
                                       <h2>Crear Llamado</h2>\
                                       <h4 class="diaColor">Fecha:</h4>\
                                       <form class="no-margin">\
                                          {{ csrf_field() }}\
                                          <input type="hidden" name="proyecto" value="'+proyecto+'"/>\
                                          <input type="hidden" name="episodio" value="'+episodio+'"/>\
                                          <input type="hidden" name="sala"  value="'+sala+'"/>\
                                          <input type="hidden" name="dia" id="dia" value="'+end._d+'"/>\
                                          <input type="hidden" name="folio" id="folio" value="'+data.folio+'"/>\
                                          <input type="hidden" name="capitulo" id="capitulo" value="'+data.capitulo+'"/>\
                                          <input type="hidden" name="fecha" id="fecha" />\
                                          <label> Actor: &nbsp;</label>\
                                          <select class="form-control actor" name="actor" id="actor" required>\
                                          <option value="">Selecccionar</option>\
                                          @foreach($actores as $actor)\
                                           <option value="{{$actor->nombre_artistico}}" data-id="{{$actor->id}}">{{$actor->nombre_artistico}}</option>\
                                          @endforeach\
                                          </select>\
                                          <label> Credencial: &nbsp;</label>\
                                          <select class="form-control credencial" name="credencial" id="credencial" required>\
                                          <option value="">Selecccionar</option>\
                                          </select>\
                                          <label> Director: &nbsp;</label>\
                                          <input type="text" name="director" value="'+data.director+'" class="form-control" readonly>\
                                          <label>Loops</label>\
                                          <input type="number" min="1" name="loops" class="form-control" required>\
                                          <hr>\
                                          Hora de Entrada:\
                                          <input type="time" name="entrada" id="entrada" data-entrada="" class="entrada form-control" required>\
                                          Hora de Salida:\
                                          <input type="time" name="salida" id="salida" data-salida=""  class="salida form-control" required>\
                                          <br><br><label>\
                                          <input type="checkbox" name="estatus_grupo"> Permitir varios actores en el mismo horario\
                                          </label>\
                                          <br><label>Personaje</label>\
                                          <textarea name="descripcion" class="form-control"></textarea>\
                                          <div class="msj-error" ></div>\
                                          <br><br><button type="submit" class="btn btn-sm btn-success"><i class="ace-icon fa fa-check"></i> Guardar</button>\
                                       </form>\
                                     </div>\
                                     <div class="modal-footer">\
                                      <button type="button" class="btn btn-sm" data-dismiss="modal"><i class="ace-icon fa fa-times"></i> Cancelar</button>\
                                     </div>\
                                    </div>\
                                   </div>\
                                  </div>';

                                  var modal = $(modal).appendTo('body');
                                  modal.find(function(){
                                    var dia_ingles = end._d;
                                    dia_ingles = dia_ingles.toString();
                                    var dia_semana = dia_ingles.split(" ");

                                    if(dia_semana[0] == 'Sun'){
                                      $('.diaColor').css("background-color", "#A9D0F5");
                                    }
                                    if(dia_semana[0] == 'Mon'){
                                      $('.diaColor').css("background-color", "#F781BE");
                                    }
                                    if(dia_semana[0] == 'Tue'){
                                      $('.diaColor').css("background-color", "#F6CECE");
                                    }
                                    if(dia_semana[0] == 'Wed'){
                                      $('.diaColor').css("background-color", "#F5D0A9");
                                    }
                                    if(dia_semana[0] == 'Thu'){
                                      $('.diaColor').css("background-color", "#CEE3F6");
                                    }
                                    if(dia_semana[0] == 'Fri'){
                                      $('.diaColor').css("background-color", "#F5A9BC");
                                    }
                                    if(dia_semana[0] == 'Sat'){
                                      $('.diaColor').css("background-color", "#E0F8E6");
                                    }
                                    var Days = { "Sun":"Domingo", "Mon":"Lunes", "Tue":"Martes", "Wed":"Miércoles", "Thu":"Jueves", "Fri":"Viernes", "Sat":"Sábado" };

                                    $('.diaColor').css({"font-size": "15px", "padding": "5px", "text-align": "center"}).html(Days[dia_semana[0]]+' '+dia_semana[2]+' de '+ dia_semana[3]);
                                  });
                                  //Asignar hora y minutos
                                    var d = new Date();
                                    var h = d.getHours();
                                    var m = d.getMinutes();
                                    var tiempo = {'1':'01', '2':'02', '3':'03', '4':'04', '5':'05', '6':'06', '7':'07', '8':'08', '9':'09' , '10':'10', '11':'11', '12':'12', '13':'13', '14':'14', '15':'15', '16':'16', '17':'17', '18':'18', '19':'19', '20':'20', '21':'21', '22':'22', '23':'23', '24':'24', '25':'25', '26':'26', '27':'27', '28':'28', '29':'29' , '30':'30', '31':'31', '32':'32', '33':'33', '34':'34', '35':'35', '36':'36', '37':'37', '38':'38', '39':'39' , '40':'40', '41':'41', '42':'42', '43':'43', '44':'44', '45':'45', '46':'46', '47':'47', '48':'48', '49':'49', '50':'50', '51':'51', '52':'52', '53':'53', '54':'54', '55':'55', '56':'56', '57':'57', '58':'58', '59':'59' , '0':'00', '00':'00'};
                                                                       
                                    $('.entrada').timepicker({
                                      timeOnlyTitle: 'Hora de Entrada',
                                      showSecond: false,
                                      showMillisec: false,
                                      showMicrosec: false,
                                      showTimezone: false
                                    });
                                    $('.salida').timepicker({
                                      timeOnlyTitle: 'Hora de Salida',
                                      showSecond: false,
                                      showMillisec: false,
                                      showMicrosec: false,
                                      showTimezone: false
                                    });
                                    $('#entrada, #salida').val(tiempo[h]+':'+tiempo[m]);
                                    var dia = end._d;
                                    dia = dia.toString();
                                    var hoy = dia.split(" ");

                                    $('#fecha').val($('#data_episodios').val())

                                    //$('#data_episodios').v

                                  //Cambia el horario de salida para que no sea menor al de entrada
                                  $('.entrada').on('change', function(){
                                    var entrada = $(this).val();
                                    var newEntrada = toDate(entrada,"h:m");
                                    var newHoraActual = toDate(tiempo[h]+':'+tiempo[m],"h:m");
                                    /*if(newEntrada < newHoraActual && hoy[2] == d.getDate()){
                                      alert('Horario no disponible');
                                      $(this).val(tiempo[h]+':'+tiempo[m]);
                                    }*/

                                    $('#salida').val(tiempo[h]+':'+tiempo[m]);
                                  });
                                  //Verifica que la salida no sea menor al de entrada
                                  $('.salida').on('change', function(){
                                    var salida = $(this).val();
                                    var newSalida = toDate(salida,"h:m");

                                    var entrada = $('#entrada').val();
                                    var newEntrada = toDate(entrada,"h:m");
                                    /*if(newSalida < newEntrada){
                                      alert('Horario no disponible');
                                      $(this).val($('#entrada').val());
                                    }*/
                                  });

                                  function toDate(dStr,format) {
                                    var now = new Date();
                                    if (format == "h:m") {
                                      now.setHours(dStr.substr(0,dStr.indexOf(":")));
                                      now.setMinutes(dStr.substr(dStr.indexOf(":")+1));
                                      now.setSeconds(0);
                                      return now;
                                    }else 
                                      return "Invalid Format";
                                  }
                                  modal.find('form').on('submit', function(ev){
                                    ev.preventDefault();
                                    $.ajax({
                                      url: '{{url("mgcalendar/cita-llamado")}}',
                                      type: 'POST',
                                      data: $( this ).serialize(),
                                      success: function(data){
                                        var inicio = data.start;
                                        var fin = data.end
                                        var start = inicio.split(" ");
                                        var end = fin.split(" ");

                                        modal.modal("hide");
                                        calendar.fullCalendar('renderEvent',
                                          {
                                            title: data.actor,
                                            start: data.start,
                                            end: data.end,
                                            className: 'label-primary',
                                            descripcion: data.actor + ' <br> Entrada: ' + start[1] + ':00' + '<br> Salida: '+  end[1] + ':00'
                                          },
                                          false // make the event "stick"
                                        );
                                      },
                                      error: function(error){
                                          modal.find('.msj-error').html('<div class="alert alert-danger" role="alert">Este horario ya se encuentra ocupado.</div>');

                                          modal.on('click', function(){
                                            modal.find('.msj-error').html('');
                                          });
                                      }
                                    });

                                    //start.title = $(this).find("input[type=text]").val();
                                    //calendar.fullCalendar('updateEvent', title);
                                    //modal.modal("hide");
                                  });
                                  modal.find('button[data-action=delete]').on('click', function() {
                                    calendar.fullCalendar('removeEvents' , function(ev){
                                      return (ev._id == start._id);
                                    })
                                    modal.modal("hide");
                                  });
                                  
                                  modal.modal('show').on('hidden', function(){
                                    modal.remove();
                                  });

                                  calendar.fullCalendar('unselect');

                                  $('.actor').on('change', function(){
                                    var id_val = $(this).find(':selected').data('id');
                                    $.ajax({
                                      url: '{{url("mgcalendar/credenciales-actores")}}'+'/'+id_val,
                                      type: 'GET',
                                      success: function(data){
                                        $(".credencial").html('');
                                        $(".credencial").html('<option value="">Seleccionar...</option>');
                                        for(var i=0;  i < data.credenciales.length; i++ ){
                                          $(".credencial").append('<option value='+ data.credenciales[i].folio + '>' + data.credenciales[i].folio +'</option>');
                                        } 
                                      }
                                    });
                                  });
                                  
                                },
                                eventClick: function(calEvent, jsEvent, view) {
                                  $.ajax({
                                    url: '{{url("mgcalendar/edit-llamado")}}'+'/'+id,
                                    type: 'GET',
                                    success: function(data){
                                      $(".credencial").html('');
                                      $(".credencial").html('<option value="">Seleccionar...</option>');
                                      /*for(var i=0;  i < data.credenciales.length; i++ ){
                                        $(".credencial").append('<option value='+ data.credenciales[i].folio + '>' + data.credenciales[i].folio +'</option>');
                                      } */ 
                                    }
                                  });

                                  //display a modal
                                  var modal = 
                                  '<div class="modal fade">\
                                    <div class="modal-dialog">\
                                     <div class="modal-content">\
                                     <div class="modal-body">\
                                       <button type="button" class="close" data-dismiss="modal" style="margin-top:-10px;">&times;</button>\
                                       <h2>Detalle del Llamado</h2>\
                                       <div>\
                                       <h3>Actor: </h3> '+calEvent.title+'<br>\
                                       <h3>Credencial: </h3> '+calEvent.credencial+'<br>\
                                       <h3>Director: </h3> '+calEvent.director+'<br>\
                                       <h3>Loops: </h3> '+calEvent.loops+'<br>\
                                       <h3>Entrada: </h3> '+calEvent.cita_start+'<br>\
                                       <h3>Salida: </h3> '+calEvent.cita_end+'<br>\
                                       <h3>Personaje: </h3> '+calEvent.descr+'<br>\
                                       <div>\
                                     </div>\
                                     <div class="modal-footer">\
                                      <button  type="button"  class="btn btn-sm btn-danger btn-eliminar"  data-action="delete"><i class="ace-icon fa fa-trash-o"></i> Eliminar Evento</button>\
                                      <button type="button" class="btn btn-sm" data-dismiss="modal"><i class="ace-icon fa fa-times"></i> Cancelar</button>\
                                     </div>\
                                    </div>\
                                   </div>\
                                  </div>';

                                  var tiempo = {'1':'01', '2':'02', '3':'03', '4':'04', '5':'05', '6':'06', '7':'07', '8':'08', '9':'09', '01':'01', '02':'02', '03':'03', '04':'04', '05':'05', '06':'06', '07':'07', '08':'08', '09':'09', '10':'10', '11':'11', '12':'12', '13':'13', '14':'14', '15':'15', '16':'16', '17':'17', '18':'18', '19':'19', '20':'20', '21':'21', '22':'22', '23':'23', '24':'24', '25':'25', '26':'26', '27':'27', '28':'28', '29':'29' , '30':'30', '31':'31', '32':'32', '33':'33', '34':'34', '35':'35', '36':'36', '37':'37', '38':'38', '39':'39' , '40':'40', '41':'41', '42':'42', '43':'43', '44':'44', '45':'45', '46':'46', '47':'47', '48':'48', '49':'49', '50':'50', '51':'51', '52':'52', '53':'53', '54':'54', '55':'55', '56':'56', '57':'57', '58':'58', '59':'59' , '0':'00', '00':'00'};
                                
                                  /*var mes = {"Ene":'01', "Feb":'02', "Mar":'03', "Abr":'04', "May":'05', "Jun":'06', "Jul":'07', "Ago":'08', "Sep":'09', "Oct":'10', "Nov":'11', "Dic":'12'};
                                  var d = new Date();
                                  var fechaHoy = d.getFullYear()+'-'+tiempo[d.getMonth()]+'-'+tiempo[d.getDay()]+' '+tiempo[d.getHours()]+':'+tiempo[d.getMinutes()]+':'+tiempo[d.getMinutes()];
                                  console.log(fechaHoy);*/

                                  var eSplit = String(calEvent.cita_start);
                                  eSplit = eSplit.split(" ");
                                  var f0Evento = eSplit[0].split('-');
                                  var f1Evento = eSplit[1].split(':');
                                  var diaEvento = tiempo[f0Evento[2]];
                                  var mesEvento = tiempo[f0Evento[1]];
                                  var anioEvento = f0Evento[0];
                                  var horaEvento = tiempo[f1Evento[0]];
                                  var minutosEvento = tiempo[f1Evento[1]];
                                  var segundosEvento = tiempo[f1Evento[2]];
                                  var fechaEvento = new Date( anioEvento, mesEvento, diaEvento );
                                  fechaEvento.setHours(horaEvento, minutosEvento, segundosEvento, 0);
                                  var utc = new Date();
                                  var d = new Date().toLocaleString('en-ES', { timeZone: 'America/Mexico_City' }).toString();
                                  dSplit = d.split(" ");
                                  var fecha0 = dSplit[0].split('/');
                                  fecha0[2] = fecha0[2].substr(0,4); 
                                  var fecha1 = dSplit[1].split(':');
                                  var diaActual = tiempo[fecha0[1]];
                                  var mesActual = tiempo[fecha0[0]];
                                  var anioActual = fecha0[2];
                                  var horaActual = tiempo[fecha1[0]];
                                  var minutosActual = tiempo[fecha1[1]];
                                  var segundosctual = tiempo[fecha1[2]];
                                  var fechaActual = new Date(anioActual, mesActual, diaActual);
                                  fechaActual.setHours(horaActual, minutosActual, segundosctual, 0);
                                  
                                  var modal = $(modal).appendTo('body');
                                  if( fechaEvento.getTime() <= fechaActual.getTime() ){
                                    modal.find('.btn-eliminar').css({display:"none"});
                                  } else {
                                    modal.find('.btn-eliminar').css({display:"block"});
                                  }
                                  
                                  modal.find('form').on('submit', function(ev){
                                    ev.preventDefault();

                                    //calEvent.title = $(this).find("input[type=text]").val();
                                    //calendar.fullCalendar('updateEvent', calEvent);
                                    //modal.modal("hide");
                                  });
                                  modal.find('button[data-action=delete]').on('click', function() {
                                    console.log(calEvent.id);
                                    $.ajax({
                                      url: '{{url("/mgcalendar/delete_llamado")}}'+'/'+calEvent.id,
                                      type: 'GET',
                                      success: function(data){
                                        console.log(data);
                                      }
                                    });

                                    calendar.fullCalendar('removeEvents' , function(ev){
                                      return (ev._id == calEvent._id);
                                    })
                                    modal.modal("hide");
                                  });
                                  
                                  modal.modal('show').on('hidden', function(){
                                    modal.remove();
                                  });


                                  // change the border color just for fun
                                  //$(this).css('border-color', 'red');

                                }
                                
                              });
                            },
                            beforeSend: function(){
                               $('div#reload').html('<img src="{{ asset('assets/mg/img/cargando.gif') }}">');
                            },
                            error: function(error){
                              $('div#reload').html('');
                            }
                          });
                      });

                 } else {
                   $('#list_episodios').html('<label>Episodio</label><br><select class="form-control" disabled>\
                        <option value="">No hay episodios</option>\
                      </select>');
                   $('#show-calendar').html('');
                   $('#name_sala').html('');
                 }
              },
              error: function(error){
              }
            });
          } else {
            $('#list_episodios').html('');
            $('#show-calendar').html('');
            $('#name_sala').html('');
          }
        });
      

      $( '#estudio_id' ).on('change', function(){
        var id = $(this).val();
        $.ajax({
          url: "{{ url('mgcalendar/list_salas') }}" + '/' +id,
          type: "GET",
          success: function( data ){
            $("#sala").empty();
            $("#sala").append('<option> Seleccionar</option>');
            for(var i=0;  i < data.msg.length; i++ ){
              $("#sala").append('<option value='+ data.msg[i].id + '>' + data.msg[i].sala +'</option>');
            } 
          },
          error: function(error){

          }
        });
      });
      
  });

    </script>
@stop