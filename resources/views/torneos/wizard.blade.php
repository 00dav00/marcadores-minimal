@extends('angular')

@section('content')

<div ng-app="configurarTorneo" ng-controller="mainController as main">

	<div class="col-xs-10 col-xs-offset-1"></div>


</div>

@endsection

@section('scripts')

	<script src="{!! asset('/js/torneos/configurar/configurar.js') !!}"></script>
	<script src="{!! asset('/js/torneos/configurar/controllers/mainController.js') !!}"></script>

@endsection