<!DOCTYPE html>
<html lang="es">
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<meta charset="utf-8" />
		<title>Macias Group</title>

		<meta name="description" content="" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

		<!-- bootstrap & fontawesome -->
		<link rel="stylesheet" href="{{ asset('assets/dashboard/css/bootstrap.min.css') }}" />
		<link rel="stylesheet" href="{{ asset('assets/dashboard/font-awesome/4.5.0/css/font-awesome.min.css') }}" />

		<!-- page specific plugin styles -->
		<link rel="stylesheet" href="{{ asset('assets/dashboard/css/fullcalendar.min.css') }}" />

		<!-- text fonts -->
		<link rel="stylesheet" href="{{ asset('assets/dashboard/css/fonts.googleapis.com.css') }}" />

		<!-- ace styles -->
		<link rel="stylesheet" href="{{ asset('assets/dashboard/css/ace.min.css') }}" class="ace-main-stylesheet" id="main-ace-style" />

		<!--[if lte IE 9]>
			<link rel="stylesheet" href="{{ asset('assets/dashboard/css/ace-part2.min.css') }}" class="ace-main-stylesheet" />
		<![endif]-->
		<link rel="stylesheet" href="{{ asset('assets/dashboard/css/ace-skins.min.css') }}" />
		<link rel="stylesheet" href="{{ asset('assets/dashboard/css/ace-rtl.min.css') }}" />
		<link rel="stylesheet" href="{{ asset('assets/calendario/jquery-ui.min.css') }}" />
		<link rel="stylesheet" href="{{ asset('assets/datatable/media/css/jquery.dataTables.min.css') }}" />
		<link rel="stylesheet" href="{{ asset('assets/multiselect/bootstrap-multiselect.css') }}" />

		<!--[if lte IE 9]>
		  <link rel="stylesheet" href="assets/css/ace-ie.min.css" />
		<![endif]-->

		<!-- inline styles related to this page -->

		<!-- ace settings handler -->
		<script src="{{ asset('assets/dashboard/js/ace-extra.min.js') }}"></script>

		<!-- HTML5shiv and Respond.js for IE8 to support HTML5 elements and media queries -->

		<!--[if lte IE 8]>
		<script src="{{ asset('assets/dashboard/dashboard/js/html5shiv.min.js') }}"></script>
		<script src="{{ asset('assets/dashboard/js/respond.min.js') }}"></script>
		<![endif]-->
		<style type="text/css">
			.img-mg{
				background-image: url("{{url('assets/mg/img/mg.jpg')}}") ;
			}
		</style>
	</head>

	<body class="no-skin">
		<div id="navbar" class="navbar navbar-default          ace-save-state">
			<div class="navbar-container ace-save-state" id="navbar-container">
				<button type="button" class="navbar-toggle menu-toggler pull-left" id="menu-toggler" data-target="#sidebar">
					<span class="sr-only">Toggle sidebar</span>

					<span class="icon-bar"></span>

					<span class="icon-bar"></span>

					<span class="icon-bar"></span>
				</button>

				<div class="navbar-header pull-left">
					<a href="index.html" class="navbar-brand">
						<small>
							Macias Group
						</small>
					</a>
				</div>

				<div class="navbar-buttons navbar-header pull-right" role="navigation">
					<ul class="nav ace-nav">
						
						<li class="light-blue dropdown-modal">
							<a data-toggle="dropdown" href="#" class="dropdown-toggle">
								<img class="nav-user-photo" src="{{ asset('assets/dashboard/images/avatars/user_1.png') }}" alt="Jason's Photo" />
								<span class="user-info">
									<small>{{\Auth::user()->name}} {{\Auth::user()->ap_paterno}}, </small>
									<small>{{\Session::get('admin_puesto')}} </small>
									{{-- Auth::user()->name --}}
								</span>

								<i class="ace-icon fa fa-caret-down"></i>
							</a>

							<ul class="user-menu dropdown-menu-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
								<!--<li>
									<a href="#">
										<i class="ace-icon fa fa-cog"></i>
										Settings
									</a>
								</li>

								<li>
									<a href="profile.html">
										<i class="ace-icon fa fa-user"></i>
										Profile
									</a>
								</li> -->
								<li>
									<a href="#">
										<i class="ace-icon fa fa-user"></i>
										{{\Session::get('admin_puesto')}} 
									</a>
								</li>

								<li class="divider"></li>

								<li>
									<a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
												 document.getElementById('logout-form').submit();">
												 <i class="ace-icon fa fa-power-off"></i>
										Salir
									</a>

									<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
										{{ csrf_field() }}
									</form>
								</li>
							</ul>
						</li>
					</ul>
				</div>
			</div><!-- /.navbar-container -->
		</div>

		<div class="main-container ace-save-state" id="main-container">
			<script type="text/javascript">
				try{ace.settings.loadState('main-container')}catch(e){}
			</script>

			<div id="sidebar" class="sidebar                  responsive                    ace-save-state">
				<script type="text/javascript">
					try{ace.settings.loadState('sidebar')}catch(e){}
				</script>

				<div class="sidebar-shortcuts" id="sidebar-shortcuts">
					<!-- <div class="sidebar-shortcuts-large" id="sidebar-shortcuts-large">
						<button class="btn btn-success">
							<i class="ace-icon fa fa-signal"></i>
						</button>

						<button class="btn btn-info">
							<i class="ace-icon fa fa-pencil"></i>
						</button>

						<button class="btn btn-warning">
							<i class="ace-icon fa fa-users"></i>
						</button>

						<button class="btn btn-danger">
							<i class="ace-icon fa fa-cogs"></i>
						</button>
					</div> -->

					<!-- <div class="sidebar-shortcuts-mini" id="sidebar-shortcuts-mini">
						<span class="btn btn-success"></span>

						<span class="btn btn-info"></span>

						<span class="btn btn-warning"></span>

						<span class="btn btn-danger"></span>
					</div> -->
				</div><!-- /.sidebar-shortcuts -->			

				<ul class="nav nav-list">
					<li class="">
						@if( \Request::session()->has('mgpuestos') || \Request::session()->has('mgsalas') || Request::session()->has('mgvias') )
							<a href="#" class="dropdown-toggle">
								<i class="menu-icon fa fa-list"></i>
								<span class="menu-text"> Elementos </span>

								<b class="arrow fa fa-angle-down"></b>
							</a>

							<b class="arrow"></b>

							<ul class="submenu">
								@if(\Request::session()->has('mgpuestos'))
									<li class="">
										<a href="{{ url('mgpuestos') }}">
											<i class="menu-icon fa fa-caret-right"></i>
											Puestos de trabajo
										</a>
										<b class="arrow"></b>
									</li>
								@endif
								<li class="">
									@if(\Request::session()->has('mgsucursales'))
										<a href="{{ url('mgsucursales') }}">
											<i class="menu-icon fa fa-caret-right"></i>
											Paises y Ciudades
										</a>
										<b class="arrow"></b>
									@endif
								</li>
								<li class="">
									@if(\Request::session()->has('mgsalas'))
										<a href="{{ url('mgsalas') }}">
											<i class="menu-icon fa fa-caret-right"></i>
											Salas
										</a>
										<b class="arrow"></b>
									@endif
								</li>
								<li class="">
									@if(\Request::session()->has('mgvias'))
										<a href="{{ url('mgvias') }}">
											<i class="menu-icon fa fa-caret-right"></i>
											Vías
										</a>
										<b class="arrow"></b>
									@endif
								</li>
								<li class="">
									@if(\Request::session()->has('mgtcr'))
										<a href="{{ url('mgtcr') }}">
											<i class="menu-icon fa fa-caret-right"></i>
											TCR
										</a>
										<b class="arrow"></b>
									@endif
								</li>
								<li class="">
									@if(\Request::session()->has('mgtiporeporte'))
										<a href="{{ url('mgtiporeporte') }}">
											<i class="menu-icon fa fa-caret-right"></i>
											Tipo de Reporte
										</a>
										<b class="arrow"></b>
									@endif
								</li>
							</ul>
						@endif
					</li>
					<li class="">
						@if(\Request::session()->has('mgpersonal'))
							<a href="{{ url('mgpersonal') }}">
								<i class="menu-icon fa fa-child"></i>
								<span class="menu-text"> Personal </span>
							</a>
							<b class="arrow"></b>
						@endif
					</li>
					<li class="">
						@if(\Request::session()->has('mgclientes'))
							<a href="{{ url('mgclientes') }}">
								<i class="menu-icon fa fa-users"></i>
								<span class="menu-text"> Clientes </span>
							</a>
							<b class="arrow"></b>
						@endif
					</li>
					<li class="">
						@if(\Request::session()->has('mgproyectos'))
							<a href="{{ url('mgproyectos') }}">
								<i class="menu-icon fa fa-tasks"></i>
								<span class="menu-text"> Proyectos </span>
							</a>
							<b class="arrow"></b>
						@endif
					</li>
					<li>
						<a href="#" class="dropdown-toggle">
								<i class="menu-icon fa fa-list"></i>
								<span class="menu-text"> Llamados </span>

								<b class="arrow fa fa-angle-down"></b>
							</a>

							<b class="arrow"></b>

							<ul class="submenu">
								<li>
									<a href="{{ url('mgactores') }}">
											<i class="menu-icon fa fa-caret-right"></i>
											Actores
										</a>
										<b class="arrow"></b>
								</li>
								<li>
									<a href="{{ url('mgcalendar') }}">
											<i class="menu-icon fa fa-caret-right"></i>
											Llamado
										</a>
										<b class="arrow"></b>
								</li>
							</ul>
					</li>
				</ul><!-- /.nav-list -->

				<div class="sidebar-toggle sidebar-collapse" id="sidebar-collapse">
					<i id="sidebar-toggle-icon" class="ace-icon fa fa-angle-double-left ace-save-state" data-icon1="ace-icon fa fa-angle-double-left" data-icon2="ace-icon fa fa-angle-double-right"></i>
				</div>
			</div>

			<div class="main-content ">
				<div class="main-content-inner ">
					<div class="breadcrumbs ace-save-state" id="breadcrumbs">
						<ul class="breadcrumb">
							<li>
								<i class="ace-icon fa fa-home home-icon"></i>
								<a href="{{ url('home') }}">Home</a>
							</li>
							
							@yield('guia')
						</ul><!-- /.breadcrumb -->
					</div>

					<div class="page-content img-mg">
						<div class="ace-settings-container" id="ace-settings-container">
							<div class="ace-settings-box clearfix" id="ace-settings-box">
								<div class="pull-left width-50">
									<div class="ace-settings-item">
										<div class="pull-left">
											<select id="skin-colorpicker" class="hide">
												<option data-skin="no-skin" value="#438EB9">#438EB9</option>
												<option data-skin="skin-1" value="#222A2D">#222A2D</option>
												<option data-skin="skin-2" value="#C6487E">#C6487E</option>
												<option data-skin="skin-3" value="#D0D0D0">#D0D0D0</option>
											</select>
										</div>
										<span>&nbsp; Choose Skin</span>
									</div>

									<div class="ace-settings-item">
										<input type="checkbox" class="ace ace-checkbox-2 ace-save-state" id="ace-settings-navbar" autocomplete="off" />
										<label class="lbl" for="ace-settings-navbar"> Fixed Navbar</label>
									</div>

									<div class="ace-settings-item">
										<input type="checkbox" class="ace ace-checkbox-2 ace-save-state" id="ace-settings-sidebar" autocomplete="off" />
										<label class="lbl" for="ace-settings-sidebar"> Fixed Sidebar</label>
									</div>

									<div class="ace-settings-item">
										<input type="checkbox" class="ace ace-checkbox-2 ace-save-state" id="ace-settings-breadcrumbs" autocomplete="off" />
										<label class="lbl" for="ace-settings-breadcrumbs"> Fixed Breadcrumbs</label>
									</div>

									<div class="ace-settings-item">
										<input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-rtl" autocomplete="off" />
										<label class="lbl" for="ace-settings-rtl"> Right To Left (rtl)</label>
									</div>

									<div class="ace-settings-item">
										<input type="checkbox" class="ace ace-checkbox-2 ace-save-state" id="ace-settings-add-container" autocomplete="off" />
										<label class="lbl" for="ace-settings-add-container">
											Inside
											<b>.container</b>
										</label>
									</div>
								</div><!-- /.pull-left -->

								<div class="pull-left width-50">
									<div class="ace-settings-item">
										<input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-hover" autocomplete="off" />
										<label class="lbl" for="ace-settings-hover"> Submenu on Hover</label>
									</div>

									<div class="ace-settings-item">
										<input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-compact" autocomplete="off" />
										<label class="lbl" for="ace-settings-compact"> Compact Sidebar</label>
									</div>

									<div class="ace-settings-item">
										<input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-highlight" autocomplete="off" />
										<label class="lbl" for="ace-settings-highlight"> Alt. Active Item</label>
									</div>
								</div><!-- /.pull-left -->
							</div><!-- /.ace-settings-box -->
						</div><!-- /.ace-settings-container -->

						<div class="row">
							<div class="col-xs-12">
								<!-- PAGE CONTENT BEGINS -->
									@yield('content')
								<!-- PAGE CONTENT ENDS -->
							</div><!-- /.col -->
						</div><!-- /.row -->
					</div><!-- /.page-content -->
				</div>
			</div><!-- /.main-content -->

			<div class="footer">
				<div class="footer-inner">
					<div class="footer-content">
						<span class="bigger-120">
							Macias Group 2017
						</span>
					</div>
				</div>
			</div>

			
		</div><!-- /.main-container -->
		
		@yield('modales')

		<!-- basic scripts -->

		<!--[if !IE]> -->
		<script src="{{ asset('assets/dashboard/js/jquery-2.1.4.min.js') }}"></script>

		<!-- <![endif]-->

		<!--[if IE]>
<script src="assets/js/jquery-1.11.3.min.js"></script>
<![endif]-->
		<script type="text/javascript">
			if('ontouchstart' in document.documentElement) document.write("<script src='assets/dasboard/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
		</script>
		<script src="{{ asset('assets/dashboard/js/bootstrap.min.js') }}"></script>

		<!-- page specific plugin scripts -->

		<!-- ace scripts -->
		<script src="{{ asset('assets/dashboard/js/ace-elements.min.js') }}"></script>
		<script src="{{ asset('assets/dashboard/js/ace.min.js') }}"></script>
		<script src="{{ asset('assets/calendario/jquery-ui.min.js') }}"></script>
		<script src="{{ asset('assets/datatable/media/js/jquery.dataTables.min.js') }}"></script>
		<script src="{{ asset('assets/mask/dist/jquery.mask.js')}}"></script>
		<script src="{{ asset('assets/dashboard/js/moment.min.js')}}"></script>
	    <script src="{{ asset('assets/dashboard/js/fullcalendar.min.js')}}"></script>
	    <script src="{{ asset('assets/dashboard/js/bootbox.js')}}"></script>
	    <script src="{{ asset('assets/multiselect/bootstrap-multiselect.js')}}"></script>

		<!-- inline scripts related to this page -->
		@yield('script')
	</body>
</html>
