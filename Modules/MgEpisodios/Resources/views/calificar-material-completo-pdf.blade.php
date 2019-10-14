<!DOCTYPE html>
<html>
<body>
	<style type="text/css">

		table{
			width: 100%;
		}
		.dg-table tr:nth-child(even) {
	    	background-color: #EEE;
		}
		.dg-table{
	    	background-color: #AAA;
		}
		.head{
			background-color: #EEE;
		}
		.center{
			text-align: center;
		}
		.fondo{
			background-color: #CCC; 
		}
		.text-color-blue {
			color: blue;
		}
        .resultado{
            color:#5f6a6a;
        }
	</style>
	<h2 class="center">Material Calificado</h2>
	<p>
		<table>
			<thead>
				<tr>
					<th>Fecha entrega: </th>
					<th><ins>{{ \Jenssegers\Date\Date::parse($allProyect[0]->fecha_entrega)->format('l j \\d\\e F Y') }}</ins></th>
				</tr>
				<tr>
					<th>Nombre del Proyecto: </th>
					<th><ins>{{$allProyect[0]->titulo_proyecto}}</ins></th>
				</tr>
				<tr>
					<th>Nombre del Episodio: </th>
					<th><ins>{{$allProyect[0]->titulo_episodio}}</ins></th>
				</tr>
			</thead>
		</table> 
		<br><hr><br>
		<table>
			<thead>
				<tr>
					<th>Fecha de doblaje: 
						<span class="resultado"><ins>{{ \Jenssegers\Date\Date::parse($allProyect[0]->fecha_doblaje)->format('l j \\d\\e F Y') }} &nbsp;</ins></span>
					</th>
					<th>Estudio: 
						<span class="resultado"><ins>{{$allProyect[0]->estudio}}</ins></span>
					</th>
					<th>Sala: 
						<span class="resultado"><ins>{{$allProyect[0]->sala}}</ins></span>
					</th>
                </tr>
                <tr>
                    <th>Título en español de la serie: 
                        <span class="resultado"><ins>{{$allProyect[0]->titulo_aprobado}} &nbsp;</ins></span>
                    </th>
                    <th>Ingeniero de audio: 
                        <span class="resultado"><ins>{{$allProyect[0]->ingeniero_audio_name}}</ins></span>
                    </th>
                    <th>Director: 
                        <span class="resultado"><ins>{{$allProyect[0]->director}}</ins></span>
                    </th>
                </tr>
                <tr>
                    <th>Título original de la serie: 
                        <span class="resultado"><ins>{{$allProyect[0]->titulo_proyecto}} &nbsp;</ins></span>
                    </th>
                    <th>Título español Episodio(tal como se grabó): 
                        <span class="resultado"><ins>{{$allProyect[0]->ingeniero_audio_name}}</ins></span>
                    </th>
                    <th>Nuevo capítulo completo del video: 
                        <span class="resultado"><ins>{{$allProyect[0]->titulo_espanol}}</ins></span>
                    </th>
                </tr>
                <tr>
                    <th>Compañía 
                        <span class="resultado"><ins>{{$allProyect[0]->razon_social}} &nbsp;</ins></span>
                    </th>
                    <th>Fecha QC ADR / Edicion: 
                        <span class="resultado"><ins>{{$allProyect[0]->fecha_edicion}}</ins></span>
                    </th>
                    <th>Editor: 
                        <span class="resultado"><ins>{{$allProyect[0]->nombre_editor}}</ins></span>
                    </th>
                </tr>
                <tr>
                    <th>Sincronía:
                        <span class="resultado"><ins>{{$allProyect[0]->sincronia}} </ins></span>
                    </th>
                    <th>Fecha de Regrabador: 
                        <span class="resultado"><ins>{{$allProyect[0]->fecha_regrabacion}}</ins></span>
                    </th>
                    <th>Regrabador: 
                        <span class="resultado"><ins>{{$allProyect[0]->nombre_regrabador}}</ins></span>
                    </th>
                </tr>
                <tr>
                    <th>Mezcla:
                        <span class="resultado"><ins>{{$allProyect[0]->mezcla}} </ins></span>
                    </th>
                    <th>Hum/Hiss si ó no: 
                        <span class="resultado"><ins>{{$allProyect[0]->hiss}}</ins></span>
                    </th>
                    <th>Compresión: 
                        <span class="resultado"><ins>{{$allProyect[0]->compresion}}</ins></span>
                    </th>
                </tr>
				<tr>
					<th>Duración: 
						<span class="resultado"><ins>{{$allProyect[0]->duracion}} &nbsp;</ins></span>
					</th>
					<th>TCR: 
						<span class="resultado"><ins>{{$allProyect[0]->tcr2}}</ins></span>
					</th>
					<!--comentario-->
					<th>Comentarios y observaciones del editor: 
						<span class="resultado"><ins>{{$allProyect[0]->observaciones_editor}}</ins></span>
					</th>
				</tr>
				<tr>				
					<th>Comentarios y observaciones del Ingeniero de audio: 
						<span class="resultado"><ins>{{$allProyect[0]->mezcla}}</ins></span><!--Falta -->
					</th>
					<th>Comentarios y observaciones del regrabador: 
						<span class="resultado"><ins>{{$allProyect[0]->observaciones_regrabador}}</ins></span>
					</th>
					<th>Tipo de reporte: 
                        <span class="resultado"><ins>{{$allProyect[0]->tipo_reporte}}</ins></span>
                    </th>
                </tr>
                <tr>				
                    <th>Comentarios transfer: 
                        <span class="resultado"><ins>{{$allProyect[0]->descripcion}}</ins></span>
                    </th>
                    <th></th>
                    <th></th>
                </tr>
			</thead>
		</table> 
		<br><hr><br>
		<table id="table-cm">
		 	<thead>
	 			<tr class="head">
	 				<th style="width: 150px;">Fecha</th>
	 				<th style="width: 200px;">Timecode</th>
	 				<th>Observaciones</th>
	 			</tr>
		 	</thead>
		 	<tbody>
		 		@foreach($timecodes as $timecode)

		 			@php
	 					$num = 0;
	 				@endphp
		 			@foreach($timecodes as $timecode2)						 				
		 				@if($timecode2->timecode == $timecode->timecode)
		 					@php
		 						$num++;
		 					@endphp
		 				@endif
		 			@endforeach
						@if($num > 1)
	 					<tr style="background: rgba(255, 117, 020, 0.3);">
			 				<td>{{$timecode->fecha}}</td>
			 				<td>{{$timecode->timecode}}</td>
			 				<td>{{$timecode->observaciones}}</td>
			 			</tr>
			 		@else
			 			<tr>
			 				<td>{{$timecode->fecha}}</td>
			 				<td>{{$timecode->timecode}}</td>
			 				<td>{{$timecode->observaciones}}</td>
			 			</tr>
			 		@endif
		 			
		 		@endforeach
		 	</tbody>
		 </table>
	</p>
</body>
</html>

