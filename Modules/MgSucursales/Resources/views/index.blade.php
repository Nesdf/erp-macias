@extends('layouts.app')

@section('guia')
	<li>
		<i class="ace-icon fa fa-list"></i>
		<i>Elementos</i>
	</li>
	<li>
		<i class="ace-icon fa fa-tasks"></i>
		<a href="{{ url('mgsucursales') }}">Sucursales</a>
	</li>
@stop

@section('content')
    <div class="row">
		<div class="col-xs-12">
			<!-- PAGE CONTENT BEGINS -->
			
			<div class="row">
				<div class="col-xs-12">
					<h3 class="header smaller lighter blue">Sucursales de Macias Group</h3>

					<div class="clearfix">
						<div class="pull-right tableTools-container"></div>
					</div>
					<div class="table-header">
						<!--Results for "Latest Registered Domains"-->
						<a data-toggle="modal" data-target="#modal_add_pais" class="btn btn-success">
							País Nuevo
						</a>
						<a data-toggle="modal" data-target="#modal_add_estado" class="btn btn-success">
							Estado Nuevo
						</a>
					</div>
					<br><br><br>
					<!-- div.table-responsive -->
						<table id="table_sucursales" class="stripe row-border">
							<thead>
								<tr>
									<th>Estado</th>
									<th>País</th>
									<th></th>
								</tr>
							</thead>

							<tbody>
								@foreach($sucursales as $sucursal)
									<tr>
										<td>
											{{ $sucursal->pais }}
										</td>
										<td>
											{{ $sucursal->estado }}
										</td>
										<td>
											<a data-toggle="modal" data-target="#modal_delete_ciudad" data-id="{{ $sucursal->id }}" class="btn btn-xs btn-danger delete_id" title="Eliminar">
												<i class="ace-icon fa fa-trash-o bigger-120"></i>
											</a>
										</td>
								@endforeach
							</tbody>
						</table>
					<!-- div.dataTables_borderWrap -->
					<div><br><br>

					</div>
				</div>
			</div>		

			<!-- PAGE CONTENT ENDS -->
		</div><!-- /.col -->
	</div><!-- /.row -->
@stop

@section('modales')
	<!-- Modal Crear Pais-->
	<div class="col-md-12">
		<div class="modal fade" id="modal_add_pais" data-name="modal" tabindex="-1" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="myModalLabel">
		  <div class="modal-dialog" role="document">
			<div class="modal-content">
			  <div class="modal-header">
				<!--<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>-->
				<h4 class="modal-title" id="t_header">País Nuevo</h4>
				<div id="error_create_personal"></div>
			  </div>
			  <form role="form" action="{{url('/mgsucursales/save_sucursal')}}" method="POST">
			  <div class="modal-body">
					{{ csrf_field() }}
					<div class="form-group">
						<label for="pais">País</label>
						<input type="text" class="form-control" id="pais" name="pais" placeholder="País" required="">
					</div>			
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
	<!-- Modal Crear Estado-->
	<div class="col-md-12">
		<div class="modal fade" id="modal_add_estado" data-name="modal" tabindex="-1" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="myModalLabel">
		  <div class="modal-dialog" role="document">
			<div class="modal-content">
			  <div class="modal-header">
				<!--<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>-->
				<h4 class="modal-title" id="t_header">País Nuevo</h4>
				<div id="error_create_personal"></div>
			  </div>
			  <form role="form" method="POST" action="{{url('mgsucursales/add_ciudad')}}">
			  <div class="modal-body">
					{{ csrf_field() }}
					<div class="form-group">
						<label>Ciudad</label>
						<select class="form-control" name="paisId">
							<option>Selecciona ...</option>
							@foreach($paises as $pais)
								<option value="{{$pais->id}}">{{$pais->pais}}</option>
							@endforeach
						</select>
					</div>
					<div class="form-group">
						<label for="exampleInputEmail1">Estado</label>
						<input type="text" class="form-control" id="estado" name="estado" placeholder="Ciudad" required="">
					</div>			
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
	<!-- Modal Delete Ciudad-->
	<div class="col-md-12">
		<div class="modal fade" id="modal_delete_ciudad" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		  <div class="modal-dialog" role="document">
			<div class="modal-content">
			  <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title " id="myModalLabel">Eliminar Ciudad</h4>
			  </div>
			  <form id="form_delete_ciudad" method="GET" action="{{ url('mgpersonal/form_delete') }}">
			  <img src="{{ asset('assets/dashboard/images/error/peligro.png') }}">
			  {{ csrf_field() }}
			  <div id="inputs"></div>
			  <label>¿Realmente deseas eliminarla?</label>
			  <div class="modal-footer">
				<button type="submit" class="btn btn-danger">Eliminar</button>
			  </div>
			  </form>
			</div>
		  </div>
		</div>
	</div>
@stop

@section('script')
	<script type="text/javascript">
		$('#table_sucursales').DataTable({
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

		$('#modal_delete_ciudad').on('show.bs.modal', function(e) {    
		    var id = $(e.relatedTarget).data().id;
		    $('#form_delete_ciudad').attr('action', '{{ url("mgsucursales/delete_ciudad") }}/' + id);
		});
	</script>
@stop