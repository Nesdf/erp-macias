<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title></title>
	<style type="text/css">
		h1 {
			text-align: center;
		}
		table{
			width: 1100px;
		}
		table, th, td {
		   border: 1px solid black;
		}
		tr{
			background-color: #666;
		}
		th {
			padding: 10px;
			color: #FFF;
		}
		td{
			background-color: #FFF;
			color: #000;
		}
	</style>
</head>
<body>
	<h1>MACIAS-GROUP</h1>
	<p>
		<table>
			<thead>
				<tr >
					<th>PERSONAJE</th>
					<th>PROYECTO</th>
					<th>EPISODIO</th>
					<th>LOOPS</th>
					<th>FECHA</th>
					<th>IMPORTE</th>
				</tr>
			</thead>
			<tbody>
				@foreach( $data as $key =>$value )
					<tr>
						<td>{{ $value['personaje'] }}</td>
						<td>{{ $value['proyecto'] }}</td>
						<td>{{ $value['episodio'] }}</td>
						<td>{{ $value['loops'] }}</td>
						<td>{{ $value['fecha'] }}</td>
						<td>${{ number_format($value['importe'], 2) }}</td>	
					</tr>
				@endforeach
				<tr>
					<td colspan="5"></td>
					<td>{{ $pago}}</td>
				</tr>
				
			</tbody>
		</table>
	</p>
</body>
</html>