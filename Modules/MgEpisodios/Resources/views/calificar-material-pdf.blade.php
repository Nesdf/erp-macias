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
		.text-color-blue{
			color: blue;
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
					<th>Duración: 
						<span class="text-color-blue"><ins>{{$allProyect[0]->duracion}} &nbsp;</ins></span>
					</th>
					<th>Tipo de reporte: 
						<span class="text-color-blue"><ins>{{$allProyect[0]->tipo_reporte}}</ins></span>
					</th>
					<th>TCR: 
						<span class="text-color-blue"><ins>{{$allProyect[0]->tcr2}}</ins></span>
					</th>
				</tr>
				<tr>				
					<th>Mezcla: 
						<span class="text-color-blue"><ins>{{$allProyect[0]->mezcla}}</ins></span>
					</th>
					<th>Comentarios transfer: 
						<span class="text-color-blue"><ins>{{$allProyect[0]->descripcion}}</ins></span>
					</th>
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

