@extends('layouts.app')

@section('guia')
	<li>
		<i class="ace-icon fa fa-child"></i>
		<a href="{{route('pdf')}}">Agregar personajes</a>
	</li>
@stop

@section('content')
    <div class="row">
		<div class="col-xs-12">
			@if (session('status'))
			    <div class="alert alert-success">
			        {{ session('status') }}
			    </div>
			@endif
			<!-- PAGE CONTENT BEGINS -->
			<form id="modificarPersonajes" >
				 {{ csrf_field() }}
				<div class="col-md-4">
					<label>Proyecto</label>
					<select class="form-control selectpicker" name="allproyectos" data-style="btn-primary" data-show-subtext="true" data-live-search="true" title="Seleccionar..." required>
						@foreach($proyectos as $proyecto)
	                        <option value="{{$proyecto->id}}">{{$proyecto->titulo_original}}</option>
	                    @endforeach
					</select><br><br>
				</div>
				<div class="col-md-4">
				<label>Episodios</label>
					<select class="form-control selectpicker" name="episodios" data-style="btn-primary" data-show-subtext="true" data-live-search="true" title="Seleccionar..." required>
					</select>
				</div>
			</form>
		</div>
	</div><!-- /.row -->

	<div class="row">
		<div class="col-md-12">
			  <div id="table-personajes"></div>
		</div>
	</div>
@stop

@section('modales')

	<!-- Modal Update-->
	<div class="col-md-12">
			<div class="modal fade" id="modal_actualizar_personaje" tabindex="-1" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="myModalLabel">
			  <div class="modal-dialog" role="document">
				<div class="modal-content">
				  <div class="modal-header">
					<!--<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>-->
					<h4 class="modal-title" id="t_header">Modificar Personaje</h4>
					<div id="error_update_personal"></div>
				  </div>
				  <form role="form" id="form_update_personaje">
				  <div class="modal-body">
						<input type="hidden"  name="id">
						<div class="form-group">
							<label for="personaje">Personaje</label>
							<input type="text" class="form-control"  name="personaje" placeholder="Personaje">
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

@stop

@section('script')
	
		<script src="{{ asset('assets/ckeditor/ckeditor.js') }}"></script>

		<script type="text/javascript">

			$(document).ready( function() {

				$('select[name=allproyectos]').on('change', function(event){
					event.preventDefault();
					var id = $(this).val();
					console.log(id);
					$.ajax({
						url: "{{url('mgreadpdf/get-episodios-personajes')}}"+ "/" + id,
						type: 'GET'
					}).done(function( data ){
						$("select[name=episodios]").empty();
			            for(var i=0;  i < data.length; i++ ){
			              $("select[name=episodios]").append('<option value='+ data[i].folio + '>' + data[i].titulo_original + " - " + data[i].num_episodio  +'</option>');
			            }
			            $('select[name=episodios]').selectpicker('refresh');
						//Listado de todos los personajes
						$('form[id=modificarPersonajes]').on('change', function(e){
							e.preventDefault();
							$folio = $('select[name=episodios]').val();
							$.ajax({
								url: "{{url('mgreadpdf/lista-perosnajes')}}"+ "/" + $folio,
								type: 'GET'
							}).done(function( data ){
								$('#table-personajes').html('<br><br><div class="col-sm-12 col-md-12"><table style="width:100%;" class=" table table-condensed ">\
								</table></div>\
								<table id="list-personajes" \
								class="table table-striped table-bordered table-hover">\
								<thead>\
									<tr>\
									<th>ID</th>\
									<th>Personaje</th>\
									<th>Acciones</th>\
									</tr>\
								</thead>\
								<tbody>'+listaPersonajes(data)+'\
								</tbody>\
								</table>');

								$('#list-personajes').DataTable({
								"pageLength": 200,
								aLengthMenu: [
								[50, 100, 200, -1],
								[50, 100, 200, "All"]
								],
								dom: 'lBfrtip',
								buttons: [
										{"extend": 'excel', "text":'Excel',"className": 'btn btn-success btn-xs'}
								],
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
									}
								});

								function listaPersonajes(data){
								console.log("funcion", data);
								console.log(data);
								if(data.length <= 0){
									return "";
								}
								var listPersonaje = '';
								var date = '';
								for(var i=0; i<data.length; i++){
									listPersonaje += "<tr>";
									listPersonaje += "<td>"+data[i]['id']+"</td>";
									listPersonaje += "<td>"+data[i]['personaje']+"</td>";
									listPersonaje += "<td><a data-toggle='modal' data-target='#modal_actualizar_personaje' data-personaje='"+data[i]['personaje']+"' data-id='"+data[i]['id']+"' class='btn btn-xs btn-info ' title='Editar'> <i class='ace-icon fa fa-pencil bigger-120'></i> </a></td>";
									listPersonaje += "</tr>";
								}

									return listPersonaje;
								}
							});
						})
					});
				});
				
				$('#modal_actualizar_personaje').on('shown.bs.modal', function (e) {
					//Se limpian los input
					$('input[name=personaje]').val('');
					$('input[name=id]').val('');
					var id = $(e.relatedTarget).data().id;
					var personaje = $(e.relatedTarget).data().personaje;
					$('input[name=id]').val(id);
					$('input[name=personaje]').val(personaje);
				});


				$('#form_update_personaje').on('submit', function(event){
						event.preventDefault();
						var id = $('input[name=id]').val();
						var personaje = $('input[name=personaje]').val();
						$.ajax({
							url: "{{ route('update-personaje') }}",
							type: "POST",
							data: {id: id, personaje: personaje, _token: "{{ csrf_token() }}"},
							success: function( data ){
								if(data['msg'] == 'success'){
									window.location.reload(true);
								}
							}
						});
					});
				
			} );
		</script>
@stop