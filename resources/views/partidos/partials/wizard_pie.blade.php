<div class="row text-center">
	<div style="width: 50%; float:left">
		<button class="btn btn-info" ng-click="volverPaso()" ng-disabled="!botonAnteriorActivado">
			<span class="glyphicon glyphicon-menu-left" aria-hidden="true"></span> Anterior
		</button>
	</div>
	<div style="width: 50%; float:right">
	   <button class="btn btn-info" ng-click="avanzarPaso()" ng-disabled="!botonSiguienteActivado">
			Siguiente <span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span>
		</button>
	</div>
</div>