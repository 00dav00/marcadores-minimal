<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Marcador en Vivo</title>

	<link href="{!! asset('/css/app.css') !!}" rel="stylesheet">

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap-theme.min.css">

	<!-- Fonts -->
	<link href='//fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>

	<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.3/themes/smoothness/jquery-ui.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.3/jquery-ui.min.js"></script>

	<link href="{!! asset('/css/vendor/selectize.css') !!}" rel="stylesheet">
	<script src="{!! asset('/js/vendor/selectize.min.js') !!}"></script>

	<link href="{!! asset('/css/vendor/jquery-ui-timepicker-addon.css') !!}" rel="stylesheet">
	<script src="{!! asset('/js/vendor/jquery-ui-timepicker-addon.js') !!}"></script>
	

</head>
<body>

	@include('partials.navbar')

	@yield('content')

</body>
</html>
