<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Marcador en vivo</title>

	<link href="{!! asset('/assets/css/principal.css') !!}" rel="stylesheet">
	<link href="{!! asset('/assets/css/vendor/toaster.min.css') !!}" rel="stylesheet">

	@yield('stylesheet')

	<link rel="stylesheet" href="{!! asset('/js/libs/toaster/toaster.min.css') !!}">

	<script src="{!! asset('/assets/js/vendor/selectize.min.js') !!}"></script>

</head>
<body>

	<div class="container">
		@yield('content')
	</div>

	<script src="{!! asset('/assets/js/principal.js') !!}"></script>
	<script src="{!! asset('/assets/js/angular-scripts.js') !!}"></script>

	<script src="{!! asset('/js/app.js') !!}"></script>
	<script src="{!! asset('/js/services.js') !!}"></script>
	<script src="{!! asset('/js/controllers.js') !!}"></script>

	@yield('scripts')

</body>
</html>
