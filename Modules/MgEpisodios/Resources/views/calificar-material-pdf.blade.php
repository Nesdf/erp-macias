<!DOCTYPE html>
<html>
<head>
	<title></title>

<style type="text/css">

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

</head>
<body>
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
				<th>Minutos: </th>
				<th class="text-color-blue"><ins>{{$allProyect[0]->duracion}} &nbsp;</ins></th>
				<th>TCR: </th>
				<th class="text-color-blue"><ins>{{$allProyect[0]->tcr}}</ins></th>
				<th>Comentarios <br>transfer: </th>
				<th class="text-color-blue"><ins>{{$allProyect[0]->descripcion}}</ins></th>
			</tr>
			<tr>
				<th>Tipo de reporte: </th>
				<th class="text-color-blue"><ins>{{$allProyect[0]->tipo_reporte}}</ins></th>
				<th>Mezcla: </th>
				<th class="text-color-blue"><ins>{{$allProyect[0]->mezcla}}</ins></th>
			</tr>
		</thead>
	</table> 
	<br><hr><br>
	<table id="table-cm" class="dg-table">
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
 					<tr style="background: rgba(255, 0, 0, 0.2);">
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

