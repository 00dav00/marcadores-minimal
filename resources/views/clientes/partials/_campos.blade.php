<div class="col-xs-4">
	<div class="panel panel-default">
		<div class="panel-body">

			<h4 class="text-center">Personalizar Colores</h4>

			<br>

			<form ng-submit="main.saveColores()" name="personalizacionForm">
				
				<div class="form-group">
					<div ng-repeat="campo in main.campos">
						<label><%campo.descripcion%></label>
						<input type="color" class="form-control" ng-model="campo.valor_default">
					</div>
				</div>

				<input type="submit" class="btn btn-success" value="Guardar">

			</form>

		</div>
	</div>
</div>