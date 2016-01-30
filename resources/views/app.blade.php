<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Dataprensa: Marcador en Vivo</title>

	<link href="{!! asset('/assets/css/principal.css') !!}" rel="stylesheet">

	@yield('stylesheets')

</head>
<body>

	@include('partials.navbar')

	<div class="container">
		@yield('content')
	</div>

	<script src="{!! asset('/assets/js/principal.js') !!}"></script>

	@yield('scripts')

</body>
</html>
