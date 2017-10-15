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
					</div>
					<br><br><br>
					<!-- div.table-responsive -->
					<ul>
						@foreach($paises as $pais)
							<li>
								<span style="font-size: 22px;">{{$pais->pais}}
									<a hreff="#" style="font-size: 10px;" data-toggle="modal" data-target="#modal_add_estado" >
										Estado Nuevo
									</a>
								</span>
								<ul>
									@php
										$sucursales = \Modules\MgSucursales\Entities\Paises::sucursal($pais->id);
									@endphp
									@foreach($sucursales as $sucursal)
										<li><span style="font-size: 16px;">{{$sucursal->estado}}</span> &nbsp;&nbsp;&nbsp;&nbsp;
											<a data-id="{{ $sucursal->id }}" href="{{url('/mgsucursales/delete_ciudad'. '/'.$sucursal->id)}}" class="btn btn-xs btn-danger" title="Eliminar">
												<i class="ace-icon fa fa-trash bigger-120"></i>
											</a>	
										</li>
									@endforeach
									@if(count($sucursales) == 0)
										<li style="color:red;">No hay estados</li>
									@endif
								</ul> 
							</li>
						@endforeach
					</ul>
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
						<label>País</label>
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

		$('.presentation').on('click', function(){
			var id = $(this).attr('id');
			$('.presentation a[href="#'+id+'"]').tab('show')
		});
	</script>
@stop