<!DOCTYPE html>
<html>
<head>
	<title></title>
	<style type="text/css">
		.table {
		    border-collapse: collapse;
		    width: 100%;
		    margin-bottom: 40px;
		}
		.table th, tr, td{
			border: 1px solid black;
		}
		th, td{
			text-align: center;
		}
		th {
			background: #CCC;
		}
		h3{
			margin: 1px;
		}
		img{
			width: 150px;
			padding-bottom: 20px;
		}
		.listaTable tr td{
			border:1px solid #FFF;
  			border-collapse:collapse;
		}
		li {
			list-style: none;
		}

	</style>
</head>
<body>
<p>
	<h2 style="text-align: center">Reporte de Llamados</h2>
	<div class="logo"></div>
	<table class="listaTable">
		<tr>
			<td>
				<img src="http://vignette2.wikia.nocookie.net/doblaje/images/5/57/Macias_group_logo.jpg/revision/latest?cb=20121231084422&path-prefix=es" />
			</td>
			<td style="text-align: left">
				<h3>Fecha:{{ $fecha }}</h3>
				<h3>Director: {{ $director }} </h3>
				<h3>Estudio:{{ $estudio }} </h3>					
				<h3>Sala:{{ $sala }}</h3> 
			</td>
		</tr>	
	</table>
		<!--<h2 class="centrado">Fecha: {{-- $fecha --}}</h2>-->
	<table class="table">
		<tr>
			<th>PROYECTO</th>
			<th>NÚMERO DE EPISODIO</th>
		</tr>
		@foreach($proyectos as $proyecto)
			<tr>
				<td>
					{{ $proyecto->proyectos }}
				</td>
				<td>
					{{ $proyecto->capitulo }}
				</td>
			</tr>
		@endforeach
	</table>
	<h3>Lista de Llamados</h3>
	<table class="table">
		@php
			$array_data = explode(';', $explode_data);
			$d_array = explode(',', $array_data[0]);
			$newArray = [];
            foreach($d_array as $key =>$value){
            	foreach($array_multiselect as $data){
            		if($value == $data){
            			$newArray[$key] = [$value];
            		}
            	}
            }

            for($i=0; $i<count($array_data); $i++){
                $header = explode(',', $array_data[$i]);
                
                echo "<tr>";
                for($j=0; $j<count($header); $j++){
                	
                	if( array_key_exists($j, $newArray) ){
                		if($i == 0){
	                        echo '<th>'.$header[$j].'</th>';
	                    } else {
	                        echo '<td>'.$header[$j].'</td>';
	                    }
                	}
                } 
                echo "</tr>";

            }
		@endphp

	</table>
	<div style="padding: -49px; padding-left: 1px; padding-right: 1px;">
		<hr>
	</div>
</p>
</body>
</html>