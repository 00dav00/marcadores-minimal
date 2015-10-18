<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Marcador en vivo</title>

	<link href="{!! asset('/css/app.css') !!}" rel="stylesheet">

	<link rel="stylesheet" href="{!! asset('/js/libs//bootstrap/dist/css/bootstrap.css') !!}">
	<link rel="stylesheet" href="{!! asset('/js/libs//bootstrap/dist/css/bootstrap-theme.min.css') !!}">

	<!-- Fonts -->
	<link href='//fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>

	<link href="{!! asset('/css/vendor/selectize.css') !!}" rel="stylesheet">

	<script src="{!! asset('/js/libs/jquery/dist/jquery.min.js') !!}"></script>
	<script src="{!! asset('/js/libs//bootstrap/dist/js/bootstrap.min.js') !!}"></script>
	<script src="{!! asset('/js/libs/jqueryui/jquery-ui.min.js') !!}"></script>
	<script src="{!! asset('/js/vendor/selectize.min.js') !!}"></script>
	<script src="{!! asset('/js/libs/underscore/underscore-min.js') !!}"></script>

</head>
<body>

	@include('partials.navbar')

	<div class="container">
		@yield('content')
	</div>

	<!--AngularJS-->
	<script src="{!! asset('/js/libs/angular/angular.min.js') !!}"></script>
	<script src="{!! asset('/js/libs/angular-resource/angular-resource.min.js') !!}"></script>
	<script src="{!! asset('/js/libs/angular-animate/angular-animate.min.js') !!}"></script>

	<script src="{!! asset('/js/libs/angular-dragdrop/src/angular-dragdrop.min.js') !!}"></script>

	<script src="{!! asset('/js/libs/angular-ui-router/release/angular-ui-router.min.js') !!}"></script>

	<script src="{!! asset('/js/libs/angular-bootstrap/ui-bootstrap-tpls.min.js') !!}"></script>

	<script src="{!! asset('/js/app.js') !!}"></script>
	<script src="{!! asset('/js/services.js') !!}"></script>
	<script src="{!! asset('/js/controllers.js') !!}"></script>

	@yield('scripts')

</body>
</html>