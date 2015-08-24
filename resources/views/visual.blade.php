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
	
	<link href="{!! asset('/css/fechas_widget.css') !!}" rel="stylesheet">

	<script src="{!! asset('/js/libs/jquery/dist/jquery.min.js') !!}"></script>
	<script src="{!! asset('/js/libs//bootstrap/dist/js/bootstrap.min.js') !!}"></script>
	<script src="{!! asset('/js/libs/jqueryui/jquery-ui.min.js') !!}"></script>
	<script src="{!! asset('/js/vendor/selectize.min.js') !!}"></script>
	<script src="{!! asset('/js/libs/underscore/underscore-min.js') !!}"></script>


	<style type="text/css">
		@media (max-width: 360px) {
		    body{font-size: 12px;}
		}
	</style>

</head>
<body>
	<div class="widget">
		<div class="container-fluid">
			<div class="row">

      			<div class="col-sm-12">
	  	@yield('widget')
          			<!-- <p>Nunc congue, enim nec faucibus rutrum, orci magna bibendum odio, nec euismod lectus neque at felis. Vestibulum lectus arcu, aliquet vel vulputate sed, aliquet convallis massa. Aenean urna ante, pretium in pellentesque at, posuere vitae urna. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Donec in ipsum urna, id aliquet erat. Aliquam id nisi eu nunc pulvinar faucibus quis quis erat. Aliquam placerat auctor lectus, sit amet consectetur ipsum lacinia sit amet.</p> -->
      			</div>
			</div>
		</div>

	<div class="container">
		@yield('content')
	</div>

	<!-- <div class="container">
	  	@yield('widget')
	</div> -->

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

</body>
</html>