<!DOCTYPE html>
<html>
<head>
	<title></title>
	<style type="text/css">
		.text-center {
			text-align: center;
		}
		.warning {
			background-color: #FE9A2E;
		}
		.danger {
			background-color: #FA5858;
		}
		.panel {
			width: 100%;
			padding: 1%;
			padding-left: 2%;
			padding-right: 2%
		}
		.panel-body, .panel-footer {
			background-color: #FFF;
		}
	</style>
</head>
<body>
	<h2 class="text-center">Macias - Group</h2>
	<div>
		<div class="panel panel-title {{$status}}">
			<h2>Fecha de entrega: </h2>
		</div>
		<div class="panel panel-body">
		    Proyecto: {{$pro_titulo}} <br>
		  	Episodio: {{$epi_titulo}}<br>
		  	Asignado a: ( PENDIENTE ... )<br>
		</div>
		<div class="panel panel-footer">
		  	<h4 class="text-center">2017 Macias-Group</h4>
		  	<h5 class="text-center"><a href="">macias-group.com</a></h5>
		</div>
	</div>
</body>
</html>