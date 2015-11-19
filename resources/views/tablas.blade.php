<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Dataprensa: Tabla de posiciones</title>

	<link href="{!! asset('/assets/css/admin.css') !!}" rel="stylesheet">

	<script src="{!! asset('/js/libs/jquery/dist/jquery.min.js') !!}"></script>
	<script src="{!! asset('/js/libs//bootstrap/dist/js/bootstrap.min.js') !!}"></script>

</head>
<body>

	<div class="container">
		@yield('content')
	</div>

	<!--AngularJS-->
	<script src="{!! asset('/js/libs/angular/angular.min.js') !!}"></script>
	<script src="{!! asset('/js/libs/angular-resource/angular-resource.min.js') !!}"></script>
	<script src="{!! asset('/js/libs/angular-animate/angular-animate.min.js') !!}"></script>
	<script src="{!! asset('/js/libs/angular-bootstrap/ui-bootstrap-tpls.min.js') !!}"></script>

</body>
</html>