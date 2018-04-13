@extends('layouts.app')

@section('guia')
    <li>
        <i class="ace-icon fa fa-film"></i>
        <a href="{{ url('mgproyectostraductor') }}">Traductor</a>
    </li>
@stop

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <!-- PAGE CONTENT BEGINS -->
            
            <div class="row">
                <div class="col-xs-12">
                    <h3 class="header smaller lighter blue center">Episodios de Macias Group</h3>

                    <div class="clearfix">
                        <div class="pull-right tableTools-container"></div>
                    </div>

                    <!-- div.table-responsive -->

                    <!-- div.dataTables_borderWrap -->
                    <div> <br><br>
                        <table id="table_episodios" class="stripe row-border">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Título Original Episodio</th>
                                    <th>Episodios</th>
                                    <th>Rayado</th>
                                    <th>script</th>
                                    <th>Fecha de entrega</th>
                                    <th></th>
                                </tr>
                            </thead>

                            <tbody>

                                @foreach($episodios as $episodio)
                                    <tr>
                                        <td> {{ $episodio->id }} </td>
                                        <td> {{ $episodio->titulo_original }}  </td>
                                        <td> {{ $episodio->num_episodio }} </td>
                                        <td class="center">
                                            @if($episodio->rayado == true)  
                                                <img src="{{ url('assets/mg/icon/true.svg') }}" width="20px">
                                            @else
                                                <img src="{{ url('assets/mg/icon/false.svg') }}" width="20px">
                                            @endif
                                        </td>
                                        <td class="center">
                                            @if($episodio->sin_script == true)  
                                                <img src="{{ url('assets/mg/icon/false.svg') }}" width="20px">
                                            @else
                                                <img src="{{ url('assets/mg/icon/true.svg') }}" width="20px">
                                            @endif
                                        </td>
                                        <td> {{ $episodio->fecha_entrega_traductor }} </td>
                                        <td>
                                            <a data-toggle="modal" data-target="#modal_update_configuracion" data-id="{{ $episodio->id }}" class="btn btn-xs btn-warning " title="Configuracion"><i class="ace-icon fa fa-tv bigger-120"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>      

            <!-- PAGE CONTENT ENDS -->
        </div><!-- /.col -->
    </div><!-- /.row -->
@stop

@section('modales')
   <!-- Modal Configuración Update Eliminar Modal-->
    <div class="col-md-12">
        <div class="modal fade" id="modal_update_configuracion" tabindex="-1" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="myModalLabel">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
                  <div class="modal-header">
                        <!--<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>-->
                        <h4 class="modal-title" id="t_header">Modificar Configuración</h4>
                        <div id="error_update_episodios"></div>
                  </div>
                  <form role="form" id="form_update_configuracion">
                      <div class="modal-body">
                        {{ csrf_field() }}
                        <table class="table table-striped ">
                            <tr>
                                <td>
                                    <input type="checkbox"  id="bw_update" name="bw"> BW
                                </td>
                                <td>
                                    <input type="checkbox"  id="netcut_update" name="netcut"> NetCut
                                </td>
                                <td>
                                    <input type="checkbox"  id="lockcut_update" name="lockcut"> LockCut
                                </td>
                                <td>
                                    <input type="checkbox"  id="final_update" name="final"> Final
                                </td>
                            </tr>
                        </table>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal" >Cerrar</button>
                      </div>
                  </form>
            </div>
          </div>
        </div>
    </div>
@stop

@section('script')
    <script>
        $(document).on('ready', function(){

            $('#table_episodios').DataTable({
                language: {
                    search:   "Buscar: ",
                    lengthMenu: "Mostrar _MENU_ registros por página",
                    zeroRecords: "No se encontraron registros",
                    info: "Página _PAGE_ de _PAGES_",
                    infoEmpty: "Se buscó en",
                    infoFiltered: "(_MAX_ registros)",
                    paginate: {
                        first:      "Primero",
                        previous:   "Previo",
                        next:       "Siguiente",
                        last:       "Anterior"
                    },
                }
            });

            /*
            * Modal para actualizar la configuración
            * BW, NetCut, LockCut y Final
            */
            $('#modal_update_configuracion').on('shown.bs.modal', function(e){
                var id = $(e.relatedTarget).data().id;

                $('#id_configuracion').val(id);
                $(".loader").fadeIn();
                $.ajax({
                    url: "{{ url('mgepisodios/edit') }}" + "/" + id,
                    type: "GET",
                    success: function( data ){
                        console.log(data);
                        $(".loader").fadeOut("slow");
                        //BW
                        if(data.bw == true){
                            $('#bw_update').prop( "checked", true ).attr( "disabled", true ).removeAttr('name');
                        } else {
                            $('#bw_update').prop( "checked", false ).attr( "disabled", true ).attr('name', 'bw');
                        }

                        //LOCKOUT
                        if(data.lockcut == true){
                            $('#lockcut_update').prop( "checked", true ).attr( "disabled", true ).removeAttr('name');
                        } else {
                            $('#lockcut_update').prop( "checked", false ).attr( "disabled", true ).attr('name', 'lockcut');
                        }

                        //NETCUT
                        if(data.netcut == true){
                            $('#netcut_update').prop( "checked", true ).attr( "disabled", true ).removeAttr('name');
                        } else {
                            $('#netcut_update').prop( "checked", false ).attr( "disabled", true ).attr('name', 'netcut');
                        }

                        //FINAL
                        if(data.final == true){
                            $('#final_update').prop( "checked", true ).attr( "disabled", true ).removeAttr('name');
                        } else {
                            $('#final_update').prop( "checked", false ).attr( "disabled", true ).attr('name', 'FINAL');
                        }
                    }, 
                    error: function(e){
                        console.log(e);
                    }
                });
            });

         });
           
    </script>
@stop