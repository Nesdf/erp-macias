<!DOCTYPE html>
<html lang="es">
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<meta charset="utf-8" />
		<title>GPS by MG</title>

		<meta name="description" content="" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

		<!-- bootstrap & fontawesome √ -->
		<link rel="stylesheet" href="{{ asset('assets/dashboard/css/bootstrap.min.css') }}"/>
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
		<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.1/css/buttons.bootstrap.min.css" />
		<link rel="stylesheet" href="{{ asset('assets/multiselect/bootstrap-multiselect.css') }}" />
		<link rel="stylesheet" href="{{ asset('assets/timepicker/css/timepicker.css') }}" />
		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/css/bootstrap-select.min.css">
		@yield('url_css')
		<style type="text/css">
			.loader {
			    position: fixed;
			    left: 0px;
			    top: 0px;
			    width: 100%;
			    height: 100%;
			    z-index: 9999;
			    background: url("{{asset('loader.gif')}}") 50% 50% no-repeat rgb(249,249,249);
			    opacity: .8;
			}
			.loader h1 {
				position: absolute;
				bottom: 25%;
				left: 36%;
				color: #000;
			}
			.loader h1 span{
				text-align: center;
			}
			
		</style>

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
		<div class="loader"><h1>GPS by MG  Cargando...</h1></div>
		<div id="navbar" class="navbar navbar-default ace-save-state">
			<div class="navbar-container ace-save-state" id="navbar-container">
				<button type="button" class="navbar-toggle menu-toggler pull-left" id="menu-toggler" data-target="#sidebar">
					<span class="sr-only">Toggle sidebar</span>

					<span class="icon-bar"></span>

					<span class="icon-bar"></span>

					<span class="icon-bar"></span>
				</button>

				<div class="navbar-header pull-left">
				<a href="{{url('/home')}}" class="navbar-brand">
						<small> GPS by MG</small>
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

			<div id="sidebar" class="sidebar responsive ace-save-state">
				<script type="text/javascript">
					try{ace.settings.loadState('sidebar')}catch(e){}
				</script>

				<div class="sidebar-shortcuts" id="sidebar-shortcuts">
				</div><!-- /.sidebar-shortcuts -->

				<ul class="nav nav-list">
					<li @if(\Request::is('mgpuestos') || \Request::is('mgsucursales') || \Request::is('mgsalas') || \Request::is('mgvias') || \Request::is('mgtcr') || \Request::is('mgtimecode') || \Request::is('mgtiporeporte') || Request::url() == route('departamento_responsable') || \Request::is('mgcatalogos/tipo-error') || Request::url() == route('mgentregables') || Request::url() == route('mgmetodoenvio') || Request::url() == route('mgdestino') || \Request::is('mgcatalogos/configuracion') || \Request::is('mgcatalogotipotrabajo'))  class="open" @endif>
						{{-- Permite --}}
						@if(\Request::session()->has('mgpuestos') || \Request::session()->has('mgsucursales') || \Request::session()->has('mgsalas') || \Request::session()->has('mgvias') || \Request::session()->has('mgtcr') || \Request::session()->has('mgtimecode') || \Request::session()->has('mgtiporeporte') || \Request::session()->has('mgcatalogos/tipo-error') || \Request::session()->has('mgcatalogotipotrabajo') )
							<a href="#" class="dropdown-toggle">
								<i class="menu-icon fa fa-list"></i>
								<span class="menu-text"> Catálogos </span>
								<b class="arrow fa fa-angle-down"></b>
							</a>
							<b class="arrow"></b>
							<ul class="submenu " >
								@if(\Request::session()->has('mgpuestos'))
									<li @if(\Request::is('mgpuestos')) class="active" @endif>
										<a href="{{ url('mgpuestos') }}">
											<i class="menu-icon fa fa-caret-right"></i>
											Puestos de trabajo
										</a>
										<b class="arrow"></b>
									</li>
								@endif
								<li @if(\Request::is('mgsucursales')) class="active" @endif>
									@if(\Request::session()->has('mgsucursales'))
										<a href="{{ url('mgsucursales') }}">
											<i class="menu-icon fa fa-caret-right"></i>
											Paises y Ciudades
										</a>
										<b class="arrow"></b>
									@endif
								</li>
								<li @if(\Request::is('mgsalas')) class="active" @endif>
									@if(\Request::session()->has('mgsalas'))
										<a href="{{ url('mgsalas') }}">
											<i class="menu-icon fa fa-caret-right"></i>
											Salas
										</a>
										<b class="arrow"></b>
									@endif
								</li>
								<li @if(\Request::is('mgvias')) class="active" @endif>
									@if(\Request::session()->has('mgvias'))
										<a href="{{ url('mgvias') }}">
											<i class="menu-icon fa fa-caret-right"></i>
											Vías
										</a>
										<b class="arrow"></b>
									@endif
								</li>
								<li @if(\Request::is('mgtcr')) class="active" @endif>
									@if(\Request::session()->has('mgtcr'))
										<a href="{{ url('mgtcr') }}"> TCR </a>
										<b class="arrow"></b>
									@endif
								</li>
								<li @if(\Request::is('mgcatalogos/configuracion')) class="active" @endif>
									@if(\Request::session()->has('catalogo_configuracion'))
										<a href="{{ url('mgcatalogos/configuracion') }}">
											<i class="menu-icon fa fa-caret-right"></i>
											Configuraciones {{--\Request::path()--}}
										</a>
										<b class="arrow"></b>
									@endif
								</li>
								<li @if(\Request::is('mgtiporeporte')) class="active" @endif>
									@if(\Request::session()->has('mgtiporeporte'))
										<a href="{{ url('mgtiporeporte') }}"> Tipo de reporte </a>
										<b class="arrow"></b>
									@endif
								</li>
								<li @if(\Request::getPathInfo() == '/mgcatalogos/tipo-error') class="active" @endif>
									@if(\Request::session()->has('tipo_error'))
										<a href="{{ route('tipo_error') }}"> Tipo de error </a> 
										<b class="arrow"></b>
									@endif
								</li>
								<li @if(Request::getPathInfo() == '/mgcatalogos/departamento-responsable') class="active" @endif>
									@if(\Request::session()->has('departamento_responsable')) 
										<a href="{{ route('departamento_responsable') }}"> Departamento responsable </a>
										<b class="arrow"></b>
									@endif
								</li>
								<li @if(Request::is('mgdestino')) class="active" @endif>
									@if(\Request::session()->has('mgvias'))
										<a href="{{ route('mgdestino') }}"> Destino </a>
										<b class="arrow"></b>
									@endif
								</li>
								<li @if(Request::is('mgmetodoenvio')) class="active" @endif>
									@if(Request::session()->has('mgmetodoenvio'))
										<a href="{{ route('mgmetodoenvio') }}"> Método envío </a>
										<b class="arrow"></b>
									@endif
								</li>
								<li @if(Request::is('mgentregables')) class="active" @endif>
									@if(Request::session()->has('mgentregables'))
										<a href="{{ route('mgentregables') }}"> Entregables </a>
										<b class="arrow"></b>
									@endif
								</li>
								<li @if(Request::is('mgcatalogotipotrabajo')) class="active" @endif>
									@if(Request::session()->has('mgcatalogotipotrabajo')) 
										<a href="{{ route('mgcatalogotipotrabajo') }}"> Tipo de trabajo </a>
										<b class="arrow"></b>
									@endif
								</li>
							</ul>
						@endif
					</li>
					<li @if(\Request::is('mgpersonal')) class="active" @endif>
						@if(\Request::session()->has('mgpersonal'))
							<a href="{{ url('mgpersonal') }}">
								<i class="menu-icon fa fa-child"></i>
								<span class="menu-text"> Personal </span>
							</a>
							<b class="arrow"></b>
						@endif
					</li>
					<li @if(\Request::is('mgprogramacionavances')) class="active" @endif>
						@if(\Request::session()->has('mgprogramacionavances'))
							<a href="{{ url('mgprogramacionavances') }}">
								<i class="menu-icon fa fa-history"></i>
								<span class="menu-text"> Programación </span>
							</a>
							<b class="arrow"></b>
						@endif
					</li>
					<li @if(\Request::is('mgclientes')) class="active" @endif>
						@if(\Request::session()->has('mgclientes'))
							<a href="{{ url('mgclientes') }}">
								<i class="menu-icon fa fa-users"></i>
								<span class="menu-text"> Clientes </span>
							</a>
							<b class="arrow"></b>
						@endif
					</li>
					<li @if(\Request::is('mgproyectos') || \Request::is('mgepisodios/*')) class="active" @endif>
						@if(\Request::session()->has('mgproyectos'))
							<a href="{{ url('mgproyectos') }}">
								<i class="menu-icon fa fa-cubes"></i>
								<span class="menu-text"> Proyectos </span>
							</a>
							<b class="arrow"></b>
						@endif
					</li>
					<li @if(\Request::is('mgactores') || \Request::is('mgcalendar') || \Request::is('mgcalendar/*') || \Request::is('mgreadpdf')  || \Request::is('mgreadpdf/*') ) class="open" @endif>
						@if(\Request::session()->has('mgactores') || \Request::session()->has('mgcalendar') || \Request::session()->has('list_llamado') || \Request::session()->has('reagendar_llamado')  || \Request::session()->has('mgreadpdf')   || \Request::session()->has('modificar_personajes'))
							<a href="#" class="dropdown-toggle">
									<i class="menu-icon fa fa-calendar"></i>
									<span class="menu-text"> Llamados </span>

									<b class="arrow fa fa-angle-down"></b>
								</a>

								<b class="arrow"></b>
								<ul class="submenu">
									<li @if(\Request::is('mgactores')) class="active" @endif>
										@if(\Request::session()->has('mgactores'))
											<a href="{{ url('mgactores') }}">
												<i class="menu-icon fa fa-caret-right"></i> Actores
											</a>
											<b class="arrow"></b>
										@endif
									</li>
									<li @if(\Request::is('mgcalendar')) class="active" @endif>
										@if(\Request::session()->has('mgcalendar'))
											<a href="{{ url('mgcalendar') }}">
												<i class="menu-icon fa fa-caret-right"></i> Calendario
											</a>
											<b class="arrow"></b>
										@endif
									</li>
									<li @if(\Request::is('mgcalendar/reagendar-llamado')) class="active" @endif>
										@if(\Request::session()->has('reagendar_llamado'))
											<a href="{{ url('mgcalendar/reagendar-llamado') }}">
												<i class="menu-icon fa fa-caret-right"></i> Re-Agendar Llamado
											</a>
											<b class="arrow"></b>
											@endif
									</li>
									<li @if(\Request::is('mgcalendar/list-llamados')) class="active" @endif>
										@if(\Request::session()->has('list_llamado'))
											<a href="{{ url('mgcalendar/list-llamados') }}">
												<i class="menu-icon fa fa-caret-right"></i> Lista de llamados
											</a>
											<b class="arrow"></b>
										@endif
									</li>
									<li @if(\Request::is('mgcalendar/view-crear-llamado')) class="active" @endif>
										
											<a href="{{ url('mgcalendar/view-crear-llamado') }}">
												<i class="menu-icon fa fa-caret-right"></i> Generar llamado
											</a>
											<b class="arrow"></b>
									</li>
									<li @if(\Request::is('mgreadpdf')) class="active" @endif>
										
											<a href="{{ url('mgreadpdf') }}">
												<i class="menu-icon fa fa-caret-right"></i> Agregar Personajes
											</a>
											<b class="arrow"></b>
									</li>
									<li @if(\Request::is('mgreadpdf/modificar-personajes')) class="active" @endif>
										
											<a href="{{ url('mgreadpdf/modificar-personajes') }}">
												<i class="menu-icon fa fa-caret-right"></i> Modificar Personajes
											</a>
											<b class="arrow"></b>
									</li>
								</ul>
							@endif
					</li>
					@if(\Session::get('admin_puesto') == "Traductor")
						<li class="">
							<a href="{{ url('mgproyectostraductor') }}">
								<i class="menu-icon fa fa-tasks"></i>
								<span class="menu-text"> Proyectos Traductor </span>
							</a>
							<b class="arrow"></b>
						</li>
					@endif
					@if(\Session::get('admin_puesto') == "Productor")
						<li class="">
							<a href="{{ url('mgproyectosproductor') }}">
								<i class="menu-icon fa fa-tasks"></i>
								<span class="menu-text"> Proyectos Productor </span>
							</a>
							<b class="arrow"></b>
						</li>
					@endif
					<li @if(\Request::is('mgcontabilidad/*') ) class="open" @endif>
						@if(\Request::session()->has('mgcontabilidad') )
						<a href="#" class="dropdown-toggle">
							<i class="menu-icon fa fa-bank"></i>
							<span class="menu-text"> Contabilidad </span>

							<b class="arrow fa fa-angle-down"></b>
						</a>

						<b class="arrow"></b>
						<ul class="submenu">
							<li @if(\Request::is('mgcontabilidad/reporte-llamado-actores')) class="active" @endif>
								@if(\Request::session()->has('reporte_llamado_actores'))
								<a href="{{ url('mgcontabilidad/reporte-llamado-actores') }}">
									<i class="menu-icon fa fa-caret-right"></i> Reporte de llamado por sala
								</a>
								<b class="arrow"></b>
								@endif
							</li>
							<li @if(\Request::is('mgcontabilidad/reporte-nomina-actores')) class="active" @endif>
								<a href="{{ url('mgcontabilidad/reporte-nomina-actores') }}">
									<i class="menu-icon fa fa-caret-right"></i> Nómina de Actores
								</a>
								<b class="arrow"></b>
							</li>
							<li @if(\Request::is('mgcontabilidad/reporte-proyectos')) class="active" @endif>
								<a href="{{ url('mgcontabilidad/reporte-proyectos') }}">
									<i class="menu-icon fa fa-caret-right"></i> Reporte por proyecto
								</a>
								<b class="arrow"></b>
							</li>
							<li @if(\Request::is('mgcontabilidad/detalle-trabajo-actor')) class="active" @endif>
								<a href="{{ url('mgcontabilidad/detalle-trabajo-actor') }}">
									<i class="menu-icon fa fa-caret-right"></i> Detalle por Actor
								</a>
								<b class="arrow"></b>
							</li>
							<li @if(\Request::is('mgcontabilidad/get-all-actores-pagos')) class="active" @endif>
								<a href="{{ url('mgcontabilidad/get-all-actores-pagos') }}">
									<i class="menu-icon fa fa-caret-right"></i> Pago Actor
								</a>
								<b class="arrow"></b>
							</li>
							<li @if(\Request::is('mgcontabilidad/show-pagos-actores')) class="active" @endif>
								<a href="{{ url('mgcontabilidad/show-pagos-actores') }}">
									<i class="menu-icon fa fa-caret-right"></i> Pago Realizados Actor
								</a>
								<b class="arrow"></b>
							</li>
							<li @if(\Request::is('mgcontabilidad/show-status-actores')) class="active" @endif>
								<a href="{{ url('mgcontabilidad/show-status-actores') }}">
									<i class="menu-icon fa fa-caret-right"></i> Consulta por Estatus
								</a>
								<b class="arrow"></b>
							</li>
						</ul>
					</li>
					@endif
					<li @if(\Request::is('mgrechazos')) class="active" @endif>
						@if(\Request::session()->has('mgrechazos'))
						<a href="{{ route('mgrechazos') }}">
							<i class="menu-icon fa fa-warning"></i>
							<span class="menu-text"> Rechazos </span>
						</a>
						<b class="arrow"></b>
						@endif
					</li>
					<li @if(\Request::is('mgtrafico'))  class="active" @endif>
						@if(\Request::session()->has('mgtrafico'))
						<a href="{{ route('mgtrafico') }}">
							<i class="menu-icon fa fa-video-camera"></i>
							<span class="menu-text"> Tráfico </span>
						</a>
						<b class="arrow"></b>
						@endif
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
							GPS by MG 2017
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
		<script src="{{ asset('assets/dashboard/js/moment.min.js')}}"></script>
		<script src="{{ asset('assets/calendario/jquery-ui.min.js') }}"></script>
		<script src="{{ asset('assets/datatable/media/js/jquery.dataTables.min.js') }}"></script>
		<script src="{{ asset('assets/mask/dist/jquery.mask.js')}}"></script>
	    <script src="{{ asset('assets/dashboard/js/fullcalendar.min.js')}}"></script>
	    <script src="{{ asset('assets/dashboard/js/bootbox.js')}}"></script>
	    <script src="{{ asset('assets/multiselect/bootstrap-multiselect.js')}}"></script>
	    <script src="{{ asset('assets/timepicker/js/timepicker.js')}}"></script>

			<script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap.min.js"></script>

			<script src="https://cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.min.js"></script>
			<script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.bootstrap.min.js"></script>
			<script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.flash.min.js"></script>
			<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
			<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
			<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
			<script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.html5.min.js"></script>
			<script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.print.min.js"></script>
			<script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.colVis.min.js"></script>




		<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/js/bootstrap-select.min.js"></script>

		<!-- inline scripts related to this page -->
		@yield('script')
		<script type="text/javascript">
			$(window).load(function() {
			    $(".loader").fadeOut("slow");
			});
		</script>
	</body>
</html>
