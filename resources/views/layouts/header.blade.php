<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- CSRF Token -->
	<meta name="csrf-token" content="{{ csrf_token() }}">

	<title>{{ config('app.name', 'Laravel') }}</title>

	<!-- Scripts -->
	{{-- <script src="{{ asset('js/app.js') }}" defer></script> --}}
	<link rel="shortcut icon" href="{{ asset('images/front-logo.png') }}">
	<!-- Fonts -->
	<link rel="dns-prefetch" href="https://fonts.gstatic.com">
	<link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">
	<!-- Styles -->
	<link href="{{ asset('bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
	<link href="{{ asset('bootstrap/font-awesome/css/font-awesome.css') }}" rel="stylesheet">
	<!-- FooTable -->
	<link href="{{ asset('bootstrap/css/plugins/sweetalert/sweetalert.css') }}" rel="stylesheet">
	<link href="{{ asset('bootstrap/css/plugins/footable/footable.core.css') }}" rel="stylesheet">

	<link href="{{ asset('bootstrap/css/plugins/iCheck/custom.css') }}" rel="stylesheet">
	<link href="{{ asset('bootstrap/css/plugins/blueimp/css/blueimp-gallery.min.css') }}" rel="stylesheet">
	<link href="{{ asset('bootstrap/css/plugins/chosen/bootstrap-chosen.css') }}" rel="stylesheet">
	{{-- <link href="{{ asset('bootstrap/css/plugins/summernote/summernote-bs4.css') }}" rel="stylesheet"> --}}
	<link href="{{ asset('bootstrap/css/plugins/switchery/switchery.css') }}" rel="stylesheet">
	<link href="{{ asset('bootstrap/css/plugins/datapicker/datepicker3.css') }}" rel="stylesheet">

	<link href="{{ asset('bootstrap/css/plugins/jasny/jasny-bootstrap.min.css') }}" rel="stylesheet">
	<link href="{{ asset('bootstrap/css/plugins/dropzone/basic.css') }}" rel="stylesheet">
	<link href="{{ asset('bootstrap/css/plugins/dropzone/dropzone.css') }}" rel="stylesheet">

	<link href="{{ asset('bootstrap/css/plugins/daterangepicker/daterangepicker-bs3.css') }}" rel="stylesheet">
	<link rel="stylesheet" href="{{ asset('bootstrap/css/plugins/dataTables/datatables.min.css') }}">
	<link href="{{ asset('bootstrap/css/animate.css') }}" rel="stylesheet">
	<link href="{{ asset('bootstrap/css/style.css') }}" rel="stylesheet">
	<link href="{{ asset('bootstrap/css/plugins/select2/select2.min.css') }}" rel="stylesheet">
	<link rel="stylesheet" href="{{ asset('vendor/sweetalert2/sweetalert2.css') }}" />

	<style>
		input::-webkit-outer-spin-button,
		input::-webkit-inner-spin-button {
			-webkit-appearance: none;
			margin: 0;
		}

		.pointer {
			cursor: pointer;
		}

		/* Firefox */
		input[type=number] {
			-moz-appearance: textfield;
		}

		.loader {
			position: fixed;
			left: 0px;
			top: 0px;
			width: 100%;
			height: 100%;
			z-index: 9999;
			background: url("{{ asset('/images/3.gif') }}") 50% 50% no-repeat rgb(249, 249, 249);
			opacity: .8;
			background-size: 200px 120px;
		}

		@media (min-width: 768px) {
			.modal-xl {
				width: 100%;
				max-width: 1300px;
			}
		}

		body {
			/* font-weight: bold; */
			color: black;
		}

		.dataTables_filter,
		.paging_simple_numbers {
			display: flex !important;
			justify-content: flex-end !important;
		}
	</style>
</head>

<body>

	<div id="myDiv" style="display:none;" class="loader">
	</div>
	<div id="wrapper">
		<nav class="navbar-default navbar-static-side" role="navigation">
			<div class="sidebar-collapse">
				<ul class="nav metismenu" id="side-menu">
					<li class="nav-header">
						<div class="dropdown profile-element">
							<img alt="image" class="rounded-circle bg-light" style='width:54px  ;height:54px;'
								src="{{ 'images/no_image.png' }}" />
							<a data-toggle="dropdown" class="dropdown-toggle" href="#">
								<span class="block m-t-xs font-bold">{{ auth()->user()->name }}</span>
								<span class="text-muted text-xs block"><b class="caret"></b></span>
							</a>
							<ul class="dropdown-menu animated fadeInRight m-t-xs">
								{{-- <li><a class="dropdown-item" href="profile.html">Profile</a></li> --}}
								{{-- <li class="dropdown-divider"></li> --}}
								<li><a class="dropdown-item" href="{{ route('logout') }}" onclick="logout(); show();">Logout</a></li>
							</ul>
						</div>
						<div class="logo-element">
							SPF
						</div>
					</li>
					@if (auth()->user()->role_id == 1)
						<li @if ($header == 'Dashboard') class='active' @endif>
							<a href="{{ url('/home') }}" class='active' onclick='show()'><i class="fa fa-th-large"></i> <span
									class="nav-label">Dashboards</span> </a>
						</li>
					@endif
					@if (auth()->user()->role_id == 2 || auth()->user()->role_id == 3)
						<li @if ($header == 'Requests') class='active' @endif>
							<a href="{{ url('/requests') }}" class='active' onclick='show()'><i class="fa fa-clipboard"></i> <span
									class="nav-label">Requests</span> </a>
						</li>
					@endif
					@if (auth()->user()->role_id == 4)
						<li @if ($header == 'For Review') class='active' @endif>
							<a href="{{ url('/for-review') }}" class='active' onclick='show()'><i class="fa fa-list-alt"></i> <span
									class="nav-label">For Review</span> </a>
						</li>
					@endif
					@if (auth()->user()->role_id == 5)
						<li @if ($header == 'For Verification') class='active' @endif>
							<a href="{{ url('/for-verification') }}" class='active' onclick='show()'><i class="fa fa-paste"></i> <span
									class="nav-label">For Verification</span> </a>
						</li>
					@endif
					@if (auth()->user()->role_id == 3)
						<li @if ($header == 'For Payment') class='active' @endif>
							<a href="{{ url('/for-payment') }}" class='active' onclick='show()'><i class="fa fa-money"></i> <span
									class="nav-label">For Payment</span> </a>
						</li>
					@endif
					@if (auth()->user()->role_id == 1)
						<li @if ($header == 'Projects') class='active' @endif>
							<a href="{{ url('/projects') }}" class='active' onclick='show()'><i class="fa fa-list-ol"></i> <span
									class="nav-label">Projects</span> </a>
						</li>
						<li @if ($header == 'Settings') class='active' @endif>
							<a href="#"><i class="fa fa-wrench"></i> <span class="nav-label">Settings</span><span
									class="fa arrow"></span></a>
							<ul class="nav nav-second-level">
								<li @if ($subheader == 'Users') class='active' @endif> <a href="{{ url('/users') }}" class='active'
										onclick='show()'><i class="fa fa-user"></i> <span class="nav-label">Users</span> </a></li>
								<li @if ($subheader == 'Companies') class='active' @endif> <a href="{{ url('/companies') }}"
										class='active' onclick='show()'><i class="fa fa-gears"></i> <span class="nav-label">Companies</span> </a>
								</li>
							</ul>
						</li>
					@endif


				</ul>
			</div>
		</nav>
		<div id="page-wrapper" class="gray-bg">
			<div class="row border-bottom">
				<nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
					<div class="navbar-header">
						<a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i></a>
					</div>
					<ul class="nav navbar-top-links navbar-right">
						<li>

							<span class="m-r-sm text-muted welcome-message">Welcome to {{ config('app.name', 'Laravel') }}.</span>
						</li>

						<li>
							<a href="{{ route('logout') }}" onclick="logout(); show();">
								<i class="fa fa-sign-out"></i> Log out
							</a>
						</li>
					</ul>
				</nav>
			</div>
			<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
				{{ csrf_field() }}
			</form>
			{{-- <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>{{$header}}</h2>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="#">{{$header}}</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <strong>{{$subheader}}</strong>
                        </li>
                    </ol>
                </div>
                <div class="col-lg-2">
                </div>
            </div>
             --}}
			@yield('content')
		</div>
		{{-- <script> --}}
		<script type='text/javascript'>
			function show() {
				document.getElementById("myDiv").style.display = "block";
			}

			function logout() {
				event.preventDefault();
				document.getElementById('logout-form').submit();
			}
		</script>

		<script src="{{ asset('bootstrap/js/jquery-3.1.1.min.js') }}"></script>
		<script src="{{ asset('bootstrap/js/popper.min.js') }}"></script>
		{{-- <script src="{{ asset('bootstrap/js/bootstrap.min.js') }}"></script> --}}
		<script src="{{ asset('bootstrap/js/bootstrap.js') }}"></script>
		<script src="{{ asset('bootstrap/js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
		<script src="{{ asset('bootstrap/js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

		<!-- Peity -->
		<script src="{{ asset('bootstrap/js/plugins/peity/jquery.peity.min.js') }}"></script>

		<!-- Custom and plugin javascript -->


		<!-- iCheck -->
		<script src="{{ asset('bootstrap/js/plugins/iCheck/icheck.min.js') }}"></script>

		<script src="{{ asset('bootstrap/js/plugins/touchspin/jquery.bootstrap-touchspin.min.js') }}"></script>
		<!-- Peity -->
		<script src="{{ asset('bootstrap/js/demo/peity-demo.js') }}"></script>
		<!-- Chosen -->
		<script src="{{ asset('bootstrap/js/plugins/chosen/chosen.jquery.js') }}"></script>
		<!-- Flot -->
		<script src="{{ asset('bootstrap/js/plugins/flot/jquery.flot.js') }}"></script>
		<script src="{{ asset('bootstrap/js/plugins/flot/jquery.flot.tooltip.min.js') }}"></script>
		<script src="{{ asset('bootstrap/js/plugins/flot/jquery.flot.spline.js') }}"></script>
		<script src="{{ asset('bootstrap/js/plugins/flot/jquery.flot.resize.js') }}"></script>
		<script src="{{ asset('bootstrap/js/plugins/flot/jquery.flot.pie.js') }}"></script>
		<script src="{{ asset('bootstrap/js/plugins/flot/jquery.flot.symbol.js') }}"></script>
		<script src="{{ asset('bootstrap/js/plugins/flot/jquery.flot.time.js') }}"></script>
		<link href="{{ asset('bootstrap/css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css') }}"
			rel="stylesheet">
		<!-- Select2 -->
		<script src="{{ asset('bootstrap/js/plugins/select2/select2.full.min.js') }}"></script>
		<!-- Custom and plugin javascript -->
		<script src="{{ asset('bootstrap/js/inspinia.js') }}"></script>
		<script src="{{ asset('bootstrap/js/plugins/pace/pace.min.js') }}"></script>


		<!-- jQuery UI -->
		<script src="{{ asset('bootstrap/js/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
		{{-- <script src="{{ asset('bootstrap/js/plugins/touchpunch/jquery.ui.touch-punch.min.js') }}"></script> --}}

		<script src="{{ asset('bootstrap/js/plugins/dataTables/datatables.min.js') }}"></script>
		<script src="{{ asset('bootstrap/js/plugins/dataTables/dataTables.bootstrap4.min.js') }}"></script>

		<script src="{{ asset('bootstrap/js/plugins/blueimp/jquery.blueimp-gallery.min.js') }}"></script>


		<script src="{{ asset('bootstrap/js/plugins/daterangepicker/daterangepicker.js') }}"></script>

		<!-- Data picker -->
		<script src="{{ asset('bootstrap/js/plugins/datapicker/bootstrap-datepicker.js') }}"></script>

		<!-- EayPIE -->
		<script src="{{ asset('bootstrap/js/plugins/easypiechart/jquery.easypiechart.js') }}"></script>

		<script src="{{ asset('bootstrap/js/plugins/easypiechart/jquery.easypiechart.js') }}"></script>
		<script src="{{ asset('bootstrap/js/plugins/chartJs/Chart.min.js') }}"></script>
		<!-- Jasny -->
		<script src="{{ asset('bootstrap/js/plugins/jasny/jasny-bootstrap.min.js') }}"></script>
		<!-- DROPZONE -->
		<script src="{{ asset('bootstrap/js/plugins/dropzone/dropzone.js') }}"></script>

		<!-- Sparkline -->
		{{-- <script src="js/plugins/sparkline/jquery.sparkline.min.js"></script> --}}

		<script src="{{ asset('vendor/sweetalert2/sweetalert2.min.js') }}" type="text/javascript"></script>
		@include('sweetalert::alert')
		@yield('dashboard_script')
		@yield('payment_script')

		<script>
			$(document).ready(function() {

				$('.category').chosen({
					width: "100%"
				});

				$('.for-review-tbl').DataTable({
					lengthMenu: [
						[10, 25, 50, -1],
						[10, 25, 50, "All"]
					],
					pageLength: -1,
					pagging: true,
					scrollY: true,
					responsive: true,
					searching: true,
					sorting:false,
					// ordering: true,
					// lengthChange: true,
					// info: false,
					// dom: "lfrti"


				});
				$('.for-verif-tbl').DataTable({
					lengthMenu: [
						[10, 25, 50, -1],
						[10, 25, 50, "All"]
					],
					pageLength: -1,
					pagging: true,
					scrollY: true,
					responsive: true,
					searching: true,
					sorting:false,
					// ordering: true,
					// lengthChange: true,
					// info: false,
					// dom: "lfrti"


				});
				$('.approved-list-tbl').DataTable({
					lengthMenu: [
						[10, 25, 50, -1],
						[10, 25, 50, "All"]
					],
					// pageLength: -1,
					// pagging: true,
					// scrollY: true,
					// responsive: true,
					// searching: true,
					// sorting:false,
					// ordering: true,
					// lengthChange: true,
					// info: false,
					// dom: "lfrti"
				});
				
				$('#pendingReqTbl').DataTable({
					pageLength: 10,
					"displayLength": 10,
					lengthMenu: [
						[10, 25, 50, -1],
						[10, 25, 50, "All"],
					],
					pagging: true,
					scrollY: true,
					responsive: true,
					searching: true,
					ordering: true,
					sorting:false,

				});
				$('#approvedReqTbl').DataTable({
					pageLength: 10,
					"displayLength": 10,
					lengthMenu: [
						[10, 25, 50, -1],
						[10, 25, 50, "All"],
					],
					pagging: true,
					scrollY: true,
					responsive: true,
					searching: true,
					ordering: true,
					sorting:false,

				});

			});
		</script>

		@include('sweetalert::alert')

</body>

</html>
