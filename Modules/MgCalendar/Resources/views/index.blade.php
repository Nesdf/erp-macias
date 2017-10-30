@extends('layouts.app')

@section('content')
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
                    <option>Seleccionar</option>
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
                      $("#data_episodios").append('<option value='+ data.msg[i].salaId + '>' + data.msg[i].titulo_original +'</option>');
                    } 

                    // Sala
                    $( '#data_episodios' ).on('change', function(){
                        var id = $(this).val();

                        if(!id){
                          $('#show-calendar').html('');
                          $('#name_sala').html('');
                          return false;
                        }else{
                          $('#show-calendar').html('<div id="calendario"></div>');
                        }

                          $.ajax({
                            url: "{{ url('mgcalendar/list_salas') }}" + '/' +id,
                            type: "GET",
                            success: function( data ){
                               $('#name_sala').html('<h3 style="text-align: center;" ><strong>Sala:</strong> <span id="data_sala">'+data.msg[0].sala+'</span></h3>');
                              // console.log(data[1]);
                               


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

                              for(var i = 0; i < data[1].length; i++) {
                                n.push(new Object(data[1][i]));
                              }

                              console.log(n);

                              var calendar = $('#calendario').fullCalendar({
                                //isRTL: true,
                                //firstDay: 1,// >> change first day of week 
                                
                                buttonHtml: {
                                  prev: '<i class="ace-icon fa fa-chevron-left"></i>',
                                  next: '<i class="ace-icon fa fa-chevron-right"></i>'
                                },
                              
                                header: {
                                  left: 'prev,next today',
                                  center: 'title',
                                  right: 'month,agendaWeek,agendaDay'
                                },
                                events: n,
                                
                                /**eventResize: function(event, delta, revertFunc) {

                                  alert(event.title + " end is now " + event.end.format());

                                  if (!confirm("is this okay?")) {
                                    revertFunc();
                                  }

                                },*/
                                
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
                                selectHelper: true,
                                select: function(start, end, allDay) {
                                  
                                  /*bootbox.prompt("Evento nuevo:", function(title) {
                                    if (title !== null) {
                                      calendar.fullCalendar('renderEvent',
                                        {
                                          title: title,
                                          start: start,
                                          end: end,
                                          allDay: allDay,
                                          className: 'label-info'
                                        },
                                        true // make the event "stick"
                                      );
                                    }
                                  });*/
                                  var proyecto = $('#proyecto_id option:selected').text();
                                  var episodio = $('#data_episodios option:selected').text();
                                  var sala = $('#data_sala').text();
                                  var modal = 
                                  '<div class="modal fade">\
                                    <div class="modal-dialog">\
                                     <div class="modal-content">\
                                     <div class="modal-body">\
                                       <button type="button" class="close" data-dismiss="modal" style="margin-top:-10px;">&times;</button>\
                                       <h2>Crear Llamado</h2>\
                                       <form class="no-margin">\
                                          {{ csrf_field() }}\
                                          <input type="hidden" name="proyecto" value="'+proyecto+'"/>\
                                          <input type="hidden" name="episodio" value="'+episodio+'"/>\
                                          <input type="hidden" name="sala" value="'+sala+'"/>\
                                          <input type="hidden" name="dia" value="'+end._d+'"/>\
                                          <label> Actor: &nbsp;</label>\
                                          <select class="form-control" name="actor" required>\
                                          <option value="">Selecccionar</option>\
                                          @foreach($actores as $actor)\
                                           <option value="{{$actor->nombre_artistico}}">{{$actor->nombre_artistico}}</option>\
                                          @endforeach\
                                          </select>\
                                          <label> Director: &nbsp;</label>\
                                          <select class="form-control" name="director" required>\
                                          <option value="">Selecccionar</option>\
                                          @foreach($directores as $director)\
                                           <option value="{{$director->name}} {{$director->ap_paterno}} @if($director->ap_materno) {{$director->ap_materno}}  @endif">{{$director->name}} {{$director->ap_paterno}} @if($director->ap_materno) {{$director->ap_materno}}  @endif</option>\
                                          @endforeach\
                                          </select>\
                                          <hr>\
                                          Hora de Entrada:\
                                          <input type="time" name="entrada" value="01:00" required> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;\
                                          Hora de Salida:\
                                          <input type="time" name="salida" value="00:00" required>\
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
                                  modal.find('form').on('submit', function(ev){
                                    ev.preventDefault();
                                    $.ajax({
                                      url: '{{url("mgcalendar/cita-llamado")}}',
                                      type: 'POST',
                                      data: $( this ).serialize(),
                                      success: function(data){
                                        modal.modal("hide");
                                      }
                                    });

                                    start.title = $(this).find("input[type=text]").val();
                                    calendar.fullCalendar('updateEvent', start);
                                    modal.modal("hide");
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
                                },
                                eventClick: function(calEvent, jsEvent, view) {

                                  //display a modal
                                  var modal = 
                                  '<div class="modal fade">\
                                    <div class="modal-dialog">\
                                     <div class="modal-content">\
                                     <div class="modal-body">\
                                       <button type="button" class="close" data-dismiss="modal" style="margin-top:-10px;">&times;</button>\
                                       <form class="no-margin">\
                                        <label>Modificar Evento &nbsp;</label>\
                                        <input class="middle" autocomplete="off" type="text" value="' + calEvent.title + '" />\
                                       <button type="submit" class="btn btn-sm btn-success"><i class="ace-icon fa fa-check"></i> Guardar</button>\
                                       </form>\
                                     </div>\
                                     <div class="modal-footer">\
                                      <button type="button" class="btn btn-sm btn-danger" data-action="delete"><i class="ace-icon fa fa-trash-o"></i> Eliminar Evento</button>\
                                      <button type="button" class="btn btn-sm" data-dismiss="modal"><i class="ace-icon fa fa-times"></i> Cancelar</button>\
                                     </div>\
                                    </div>\
                                   </div>\
                                  </div>';
                                
                                
                                  var modal = $(modal).appendTo('body');
                                  modal.find('form').on('submit', function(ev){
                                    ev.preventDefault();

                                    calEvent.title = $(this).find("input[type=text]").val();
                                    calendar.fullCalendar('updateEvent', calEvent);
                                    modal.modal("hide");
                                  });
                                  modal.find('button[data-action=delete]').on('click', function() {
                                    calendar.fullCalendar('removeEvents' , function(ev){
                                      return (ev._id == calEvent._id);
                                    })
                                    modal.modal("hide");
                                  });
                                  
                                  modal.modal('show').on('hidden', function(){
                                    modal.remove();
                                  });


                                  //console.log(calEvent.id);
                                  //console.log(jsEvent);
                                  //console.log(view);

                                  // change the border color just for fun
                                  //$(this).css('border-color', 'red');

                                }
                                
                              });
                            },
                            error: function(error){
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

     
      //Ajax Meses
      $( '#sala1' ).on('change', function(){
        var id = $(this).val();
        $.ajax({
          url: "{{ url('mgcalendar/calendar_sala') }}" + '/' +id,
          type: "GET",
          success: function( data ){
              /* initialize the external events
  -----------------------------------------------------------------*/

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
              console.log(m);


              var calendar = $('#calendar').fullCalendar({
                //isRTL: true,
                //firstDay: 1,// >> change first day of week 
                
                buttonHtml: {
                  prev: '<i class="ace-icon fa fa-chevron-left"></i>',
                  next: '<i class="ace-icon fa fa-chevron-right"></i>'
                },
              
                header: {
                  left: 'prev,next today',
                  center: 'title',
                  right: 'month,agendaWeek,agendaDay'
                },
                events: [
                  
                ]
                ,
                
                /**eventResize: function(event, delta, revertFunc) {

                  alert(event.title + " end is now " + event.end.format());

                  if (!confirm("is this okay?")) {
                    revertFunc();
                  }

                },*/
                
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
                  
                }
                ,
                selectable: true,
                selectHelper: true,
                select: function(start, end, allDay) {
                  
                  /*bootbox.prompt("Evento nuevo:", function(title) {
                    if (title !== null) {
                      calendar.fullCalendar('renderEvent',
                        {
                          title: title,
                          start: start,
                          end: end,
                          allDay: allDay,
                          className: 'label-info'
                        },
                        true // make the event "stick"
                      );
                    }
                  });*/

                  var modal = 
                  '<div class="modal fade">\
                    <div class="modal-dialog">\
                     <div class="modal-content">\
                     <div class="modal-body">\
                       <button type="button" class="close" data-dismiss="modal" style="margin-top:-10px;">&times;</button>\
                       <h2>Crear Llamado</h2>\
                       <form class="no-margin">\
                        <label> Actor: &nbsp;</label>\
                        <select class="form-control">\
                        <option value="">Selecccionar</option>\
                        </select>\
                        <label> Director: &nbsp;</label>\
                        <select class="form-control">\
                        <option value="">Selecccionar</option>\
                        </select>\
                        <hr>\
                        Hora de Entrada:\
                        <label> Hora: &nbsp;</label>\
                        <input type="number" min="1" value="1">\
                        <label> Minutos: &nbsp;</label>\
                        <input type="number" min="1" value="05">\
                        <hr>\
                        Hora de Salida:\
                        <label> Hora: &nbsp;</label>\
                        <input type="number" min="1" value="1">\
                        <label> Minutos: &nbsp;</label>\
                        <input type="number" min="1" value="05">\
                       <br><br><button type="submit" class="btn btn-sm btn-success"><i class="ace-icon fa fa-check"></i> Guardar</button>\
                       </form>\
                     </div>\
                     <div class="modal-footer">\
                      <button type="button" class="btn btn-sm btn-danger" data-action="delete"><i class="ace-icon fa fa-trash-o"></i> Eliminar Evento</button>\
                      <button type="button" class="btn btn-sm" data-dismiss="modal"><i class="ace-icon fa fa-times"></i> Cancelar</button>\
                     </div>\
                    </div>\
                   </div>\
                  </div>';
                  
                  var modal = $(modal).appendTo('body');
                  modal.find('form').on('submit', function(ev){
                    ev.preventDefault();

                    start.title = $(this).find("input[type=text]").val();
                    calendar.fullCalendar('updateEvent', start);
                    modal.modal("hide");
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
                }
                ,
                eventClick: function(calEvent, jsEvent, view) {

                  //display a modal
                  var modal = 
                  '<div class="modal fade">\
                    <div class="modal-dialog">\
                     <div class="modal-content">\
                     <div class="modal-body">\
                       <button type="button" class="close" data-dismiss="modal" style="margin-top:-10px;">&times;</button>\
                       <form class="no-margin">\
                        <label>Modificar Evento &nbsp;</label>\
                        <input class="middle" autocomplete="off" type="text" value="' + calEvent.title + '" />\
                       <button type="submit" class="btn btn-sm btn-success"><i class="ace-icon fa fa-check"></i> Guardar</button>\
                       </form>\
                     </div>\
                     <div class="modal-footer">\
                      <button type="button" class="btn btn-sm btn-danger" data-action="delete"><i class="ace-icon fa fa-trash-o"></i> Eliminar Evento</button>\
                      <button type="button" class="btn btn-sm" data-dismiss="modal"><i class="ace-icon fa fa-times"></i> Cancelar</button>\
                     </div>\
                    </div>\
                   </div>\
                  </div>';
                
                
                  var modal = $(modal).appendTo('body');
                  modal.find('form').on('submit', function(ev){
                    ev.preventDefault();

                    calEvent.title = $(this).find("input[type=text]").val();
                    calendar.fullCalendar('updateEvent', calEvent);
                    modal.modal("hide");
                  });
                  modal.find('button[data-action=delete]').on('click', function() {
                    calendar.fullCalendar('removeEvents' , function(ev){
                      return (ev._id == calEvent._id);
                    })
                    modal.modal("hide");
                  });
                  
                  modal.modal('show').on('hidden', function(){
                    modal.remove();
                  });


                  //console.log(calEvent.id);
                  //console.log(jsEvent);
                  //console.log(view);

                  // change the border color just for fun
                  //$(this).css('border-color', 'red');

                }
                
              });

          },
          error: function(error){
          }
        });
      });
  });

    </script>
@stop