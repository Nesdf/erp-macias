<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>

<div class="links">
    <form method="post" action="{{url('mgactores/import-excel')}}" enctype="multipart/form-data">
        {{csrf_field()}}
        <input type="file" name="excel">
        <br><br>
        <input type="submit" value="Enviar" style="padding: 10px 20px;">
    </form>
</div>
</body>
</html>