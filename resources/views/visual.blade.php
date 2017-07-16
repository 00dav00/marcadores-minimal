<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Marcador en vivo</title>

	<link href="{!! asset('/assets/css/principal.css') !!}" rel="stylesheet">
	<link href="{!! asset('/assets/css/vendor/selectize.css') !!}" rel="stylesheet">

	@yield('stylesheet')

	
	<link href="{!! asset('/css/fechas_widget.css') !!}" rel="stylesheet">

	<script src="{!! asset('/js/libs/jquery/dist/jquery.min.js') !!}"></script>
	<script src="{!! asset('/js/libs//bootstrap/dist/js/bootstrap.min.js') !!}"></script>
	<script src="{!! asset('/js/libs/jqueryui/jquery-ui.min.js') !!}"></script>
	<script src="{!! asset('/js/vendor/selectize.min.js') !!}"></script>
	<script src="{!! asset('/js/libs/underscore/underscore-min.js') !!}"></script>

</head>
<body>

	<div class="container">
		@yield('content')
	</div>

	<!--AngularJS-->
	<script src="{!! asset('/js/libs/angular/angular.min.js') !!}"></script>
	<script src="{!! asset('/js/libs/angular-resource/angular-resource.min.js') !!}"></script>
	<script src="{!! asset('/js/libs/angular-animate/angular-animate.min.js') !!}"></script>
	<script src="{!! asset('/js/libs/angular-ui-router/release/angular-ui-router.min.js') !!}"></script>

	<script src="{!! asset('/js/libs/angular-bootstrap/ui-bootstrap-tpls.min.js') !!}"></script>

	<script src="{!! asset('/js/app.js') !!}"></script>
	<script src="{!! asset('/js/services.js') !!}"></script>
	<script src="{!! asset('/js/controllers.js') !!}"></script>

	<script src="{!! asset('/js/torneos/wizard/wizard.js') !!}"></script>
	<script src="{!! asset('/js/torneos/wizard/wizard.config.js') !!}"></script>
	<script src="{!! asset('/js/torneos/wizard/wizard.controller.js') !!}"></script>
	<script src="{!! asset('/js/torneos/wizard/wizard.factory.js') !!}"></script>
	<script src="{!! asset('/js/torneos/wizard/wizard.filter.js') !!}"></script>

	<script src="{!! asset('/assets/js/principal.js') !!}"></script>

	@yield('scripts')

</body>
</html>
