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
			<form method="POST"  action="{{route('save_pdf_actores')}}" >
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
						
					</select><br><br>
				</div>
					<br><br>
				<div class="col-md-12">
					<textarea class="ckeditor"  name="datos" id="data" rows="10" cols="120"></textarea>
					<br><br>
					<button type="submit">Enviar</button>
				</div>
				 
				
			</form>
		</div><!-- /.col -->
	</div><!-- /.row -->
@stop

@section('modales')
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
					});
				});

				/*$('form').on('submit', function(event){
					event.preventDefault();
					$.ajax({
						url: "{{url('mgreadpdf/save-pdf-actores')}}",
						type: "POST",
						data: $( this ).serialize()
					}).done(function( data ){

						console.log(data);
						if( data['type'] == 200 ){
							alert("Se almacenron exitosamente");
						}
						
					});
				});*/
				
			} );
		</script>
@stop