@extends('tablas')

@section('content')

<div class="row">
	<div class="col-xs-12 col-sm-8 col-md-8">
		
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Torneo</h3>
			</div>
			<div class="panel-body row">
				<table class="table text-center">
					<thead >
						<tr class="row">
							<td class="col-xs-1 col-sm-1">&nbsp;</td>
							<td class="col-xs-1 col-sm-1">&nbsp;</td>
							<td class="col-xs-2 col-sm-2 hidden-sm hidden-xs">Equipo</td>
							<td class="col-xs-4 col-sm-4 hidden-xs hidden-md hidden-lg">Equipo</td>
							<td class="col-xs-2 col-sm-2 hidden-sm hidden-md hidden-lg">EQP</td>
							<td class="col-xs-1 col-sm-1">PJ</td>
							<td class="col-xs-1 col-sm-1 hidden-xs hidden-sm">PG</td>
							<td class="col-xs-1 col-sm-1 hidden-xs hidden-sm">PE</td>
							<td class="col-xs-1 col-sm-1 hidden-xs hidden-sm">PP</td>
							<td class="col-xs-1 col-sm-1 hidden-xs hidden-sm">GF</td>
							<td class="col-xs-1 col-sm-1 hidden-xs hidden-sm">GC</td>
							<td class="col-xs-1 col-sm-1">GD</td>
							<td class="col-xs-1 col-sm-1">Pts</td>
						</tr>
					</thead>
					<tbody>
						<tr class="row">
							<td>1</td>
							<td>&nbsp;</td>
							<td class="hidden-xs">Liga Deportiva Universitaria</td>
							<td class="hidden-sm hidden-md hidden-lg">LDU</td>
							<td>PJ</td>
							<td class="hidden-xs hidden-sm">PG</td>
							<td class="hidden-xs hidden-sm">PE</td>
							<td class="hidden-xs hidden-sm">PP</td>
							<td class="hidden-xs hidden-sm">GF</td>
							<td class="hidden-xs hidden-sm">GC</td>
							<td>GD</td>
							<td>Pts</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>

	</div>
</div>

@endsection