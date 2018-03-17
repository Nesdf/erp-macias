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
					@if(Session::has('success'))
						<p class="alert alert-success">{{ Session::get('success') }}</p>
					@endif
					@if(Session::has('error'))
						<p class="alert alert-danger">{{ Session::get('error') }}</p>
					@endif
					<div class="clearfix">
						<div class="pull-right tableTools-container"></div>
					</div>
					<div class="table-header">
						<!--Results for "Latest Registered Domains"-->
						@if( \Request::session()->has('add_sucursal'))
							<a data-toggle="modal" data-target="#modal_add_pais" class="btn btn-success">
								País Nuevo
							</a>
						@endif
					</div>
					<br><br><br>
					<!-- div.table-responsive -->
						@foreach($paises as $pais)						
							
							<div class="col-md-3">
								<div class="card">
								  <img class="card-img-top" width="40%;" src="{{ asset('assets/iconos') }}/{{ $pais->surname .'.svg' }}" alt="{{$pais->pais}}">
								  <div class="card-block">
								    <h4 class="card-title">{{$pais->pais}}
										<a href="javascript:void(0)" data-id="{{ $pais->id }}" data-pais="{{ $pais->pais }}" data-toggle="modal" data-target="#modal_edit_pais" ><i class="fa fa-edit"></i></a>
										<a href="javascript:void(0)" data-id="{{ $pais->id }}" data-pais="{{ $pais->pais }}" data-toggle="modal" data-target="#modal_delete_pais" ><i class="fa fa-trash" style="color:red;"></i></a>
								    </h4>
								    <div>
								    	<a href="javascript:void(0)" data-id="{{ $pais->id }}" data-pais="{{ $pais->pais }}" data-toggle="modal" data-target="#modal_add_estado">Agregar Ciudad</a>
								    </div>
								    <p class="card-text">
										@php
											$sucursales = \Modules\MgSucursales\Entities\Paises::sucursal($pais->id);
										@endphp

										@if(count($sucursales) == 0)
											<span style="color:red;">No exiten ciuddades</span>
											<br><br>
										@endif
										@foreach($sucursales as $sucursal)
											<li><span style="font-size: 16px;">{{$sucursal->estado}}</span> &nbsp;&nbsp;&nbsp;&nbsp;
												@if( \Request::session()->has('delete_ciudad'))
													<a href="javascript:void(0)" data-id="{{ $sucursal->id }}" data-estado="{{ $sucursal->estado }}" data-toggle="modal" data-target="#modal_edit_estado" title="Editar">
														<i class="ace-icon fa fa-edit bigger-120"></i>
													</a>
													<a data-id="{{ $sucursal->id }}" href="{{url('/mgsucursales/delete_ciudad'. '/'.$sucursal->id)}}"  title="Eliminar">
														<i class="ace-icon fa fa-trash bigger-120" style="color:red;"></i>
													</a>
												@endif
											</li>
										@endforeach
								    </p>
								    <!--<a href="#" class="btn btn-primary">Go somewhere</a>-->
								  </div>
								</div>
							</div>					

						@endforeach
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
	<!-- Modal Modificar Estado-->
	<div class="col-md-12">
		<div class="modal fade" id="modal_edit_estado" data-name="modal" tabindex="-1" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="myModalLabel">
		  <div class="modal-dialog" role="document">
			<div class="modal-content">
			  <div class="modal-header">
				<!--<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>-->
				<h4 class="modal-title">Editar Estado <span id="nameEstado"></span></h4>
				<div id="error_edit_estado"></div>
			  </div>
			  <form role="form" id="form_edit_estado" >
				  <div class="modal-body">
						{{ csrf_field() }}
						<input type="hidden" name="id" >
						<div class="form-group">
							<label for="pais">Estado</label>
							<input type="text" class="form-control"  name="estado" placeholder="Estado" required>
						</div>			
				  </div>
				  <div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal" >Cerrar</button>
					<button type="submit" class="submit btn btn-primary">Guardar</button>
				  </div>
			  </form>
			</div>
		  </div>
		</div>
	</div>
	<!-- Modal Modificar Pais-->
	<div class="col-md-12">
		<div class="modal fade" id="modal_edit_pais" data-name="modal" tabindex="-1" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="myModalLabel">
		  <div class="modal-dialog" role="document">
			<div class="modal-content">
			  <div class="modal-header">
				<!--<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>-->
				<h4 class="modal-title" id="t_header">Editar País <span id="namePais"></span></h4>
				<div id="error_create_personal"></div>
			  </div>
			  <form role="form" id="form_edit_pais" >
				  <div class="modal-body">
						{{ csrf_field() }}
						<input type="hidden" name="id" >
						<div class="form-group">
							<label for="pais">País</label>
							<input type="text" class="form-control" id="pais" name="pais" placeholder="País" required="">
						</div>			
				  </div>
				  <div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal" >Cerrar</button>
					<button type="submit" class="submit btn btn-primary">Guardar</button>
				  </div>
			  </form>
			</div>
		  </div>
		</div>
	</div>
	<!-- Modal Delete País-->
	<div class="col-md-12">
		<div class="modal fade" id="modal_delete_pais" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		  <div class="modal-dialog" role="document">
			<div class="modal-content">
			  <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title " id="myModalLabel">Eliminar País</h4>
			  </div>
			  <form id="form_delete_pais" method="get">
			  <img src="{{ asset('assets/dashboard/images/error/peligro.png') }}">
			  {{ csrf_field() }}
			  <div id="inputs"></div>
			  <label>¿Realmente deseas eliminarlo?</label>
			  <div class="modal-footer">
				<button type="submit" class="btn btn-danger">Eliminar</button>
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
				<div id="error_add_estado"></div>
			  </div>
			  <form role="form" id="form_add_estado" >
			  <div class="modal-body">
					{{ csrf_field() }}
					<div id="pais"></div>
					<input type="hidden" id="id" name="paisId" >
					<div class="form-group">
						<label for="estado">Estado</label>
						<input type="text" class="form-control" id="estado" name="estado" placeholder="Estado" required="">
					</div>			
			  </div>
			  <div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal" >Cerrar</button>
				<button type="submit" class=" submit btn btn-primary">Guardar</button>
			  </div>
			  </form>
			</div>
		  </div>
		</div>
	</div>
	<!-- Modal Delete Ciudad-->
	<div class="col-md-12">
		<div class="modal fade" id="modal_delete_ciudad" tabindex="-1" role="dialog" >
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

		$('#modal_delete_pais').on('show.bs.modal', function(e) {    
		    var id = $(e.relatedTarget).data().id;
		    $('#form_delete_pais').attr('action', '{{ url("mgsucursales/delete_pais") }}/' + id);
		});

		$('#modal_delete_ciudad').on('show.bs.modal', function(e) {    
		    var id = $(e.relatedTarget).data().id;
		    $('#form_delete_ciudad').attr('action', '{{ url("mgsucursales/delete_ciudad") }}/' + id);
		});

		$('#modal_edit_pais').on('show.bs.modal', function(e) {    
		     var id = $(e.relatedTarget).data().id;
		     var pais = $(e.relatedTarget).data().pais;
		      $(e.currentTarget).find('input[name=id]').val(id);
		      $(e.currentTarget).find('#namePais').html(pais);
		      $('input[name=pais]').val(pais);

		      $('#form_edit_pais').on('submit', function(event){
		      	event.preventDefault();
		      	$.ajax({
			      	url: "{{ url("mgsucursales/edit_sucursal") }}",
			      	type: "POST",
			      	data: $(this).serialize(),
			      	success: function(data){
			      		window.location.reload(true);
			      	},
			      	beforeSend: function(){
			      		$('.submit').attr('disabled', 'disabled');
			      	},
			      	error: function(error){

			      	}
			      });
		      });
		  });

		$('#modal_add_estado').on('show.bs.modal', function(e) {    
		     var id = $(e.relatedTarget).data().id;
		     var pais = $(e.relatedTarget).data().pais;
		      $(e.currentTarget).find('#id').val(id);
		      $(e.currentTarget).find('#pais').html('<h2>'+pais+'</h2>');

		      $('#form_add_estado').on('submit', function(event){
				event.preventDefault();
		      	$.ajax({
			      	url: "{{ url("mgsucursales/add_ciudad") }}",
			      	type: "POST",
			      	data: $(this).serialize(),
			      	success: function(data){
			      		window.location.reload(true);
			      	},
			      	beforeSend: function(){
			      		$('.submit').attr('disabled', 'disabled');
			      	},
			      	error: function(error){
			      		if( error.responseJSON.msg){
							$('#error_add_estado').html('<div class="alert alert-danger">Ya existe el estado.</div>');
			      		}
			      		$('input[name=estado]').on('keyup', function(){
				      		$('.submit').removeAttr('disabled');
				      });
			      	}
			      });
		      });

		      
		 });

		$('#modal_edit_estado').on('show.bs.modal', function(e) {    
		    var id = $(e.relatedTarget).data().id;
		    var estado = $(e.relatedTarget).data().estado;
		    $(e.currentTarget).find('input[name=id]').val(id);
		    $('input[name=estado]').val(estado);

		    $('#form_edit_estado').on('submit',function(event){
		    	event.preventDefault();
		    	$.ajax({
		    		url: "{{ url('mgsucursales/edit_ciudad') }}",
		    		type: "POST",
		    		data: $(this).serialize(),
		    		success: function(data){
		    			window.location.reload(true);
		    		}, 
		    		beforeSend: function(){
		    			$('.submit').attr('disabled', 'disabled');
		    		},
		    		error: function(error){
		    			var err = "";
						for(var i in error.responseJSON.msg){
							err += error.responseJSON.msg[i] + "<br>";														
						}
						$('#error_edit_estado').html('<div class="alert alert-danger">' + err + '</div>');
						$('.submit').removeAttr('disabled');
		    		}
		    	});
		    });
		  });

		$('.presentation').on('click', function(){
			var id = $(this).attr('id');
			$('.presentation a[href="#'+id+'"]').tab('show')
		});
	</script>
@stop