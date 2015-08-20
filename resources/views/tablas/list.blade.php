@extends('angular')

@section('content')

<div class="row centered-form" ng-app="tablasApp" ng-controller="TablasCtrl" data-ng-init="initList()">
	<div class="col-xs-12 col-sm-10 col-md-8 col-sm-offset-1 col-md-offset-2">
		<div class="panel panel-default">

			<h3 class="text-center">Torneos disponibles</h3>
			<br/>

			<div class="form-group" >
				<table class="table table-striped table-hover">
					<thead>
						<td><b>Torneo</b></td>
						<td><b>Temporada</b></td>
					</thead>
					<tbody>
						<tr ng-repeat='torneo in torneos' ng-click="irTabla(torneo)">
							<td> <% torneo.tor_nombre %> </td>
							<td> <% torneo.tor_anio_referencia %> </td>
						</tr>
					</tbody>
				</table>
			</div>

		</div>
	</div>
</div>

@endsection