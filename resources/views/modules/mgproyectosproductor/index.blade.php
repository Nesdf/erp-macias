@extends('layouts.app')

@section('guia')
    <li>
        <i class="ace-icon fa fa-film"></i>
        <a href="{{ url('mgproyectostraductor') }}">Episodios</a>
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
                                    <th>Sala</th>
                                    <th>Fecha de doblaje</th>
                                </tr>
                            </thead>

                            <tbody>

                                @foreach($episodios as $episodio)
                                    <tr>
                                        <td> {{ $episodio->id }} </td>
                                        <td> {{ $episodio->titulo_original }}  </td>
                                        <td> {{ $episodio->num_episodio }} </td>
                                        <td> {{ $episodio->salaId }} </td>
                                        <td> {{ $episodio->fecha_doblaje }} </td>
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

         });
           
    </script>
@stop