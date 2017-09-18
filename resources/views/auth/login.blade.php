<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Macias-Group</title>
  
  
  <link rel='stylesheet prefetch' href='http://netdna.bootstrapcdn.com/bootstrap/3.0.2/css/bootstrap.min.css'>

      <link rel="stylesheet" href=" {{ asset( 'assets/login/css/style.css' ) }} ">

  
</head>

<body>
    <div class="wrapper">		
		<form class="form-signin" role="form" method="POST" action="{{ route('login') }}"> 
			@if ($errors->has('email'))
				<div class="alert alert-danger">
					<strong>{{ $errors->first('email') }}</strong>
				</div>
			@endif	
		{{ csrf_field() }}
		  <h2 class="form-signin-heading">{{ trans('auth.label.macias_group') }}</h2>
		  <input type="text" class="form-control" name="email" placeholder="{{ trans('auth.input.email') }}" autofocus="" required/>
		  <input type="password" class="form-control" name="password" placeholder=" {{ trans('auth.input.password') }} " required />      
		  <button class="btn btn-lg btn-primary btn-block" type="submit">{{ trans('auth.input.submit_login') }}</button>   
		</form>
	</div>
  
  
</body>
</html>
