<style>
.thumbnail { height: 60px !important; }
.btn-droppable { width: 210px; height: 20px; padding: 4px; margin: 4px;}
.btn-draggable { width: 200px; }
</style>


<div>
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="text-center">Equipo local</h3>
		</div>
		<div class="panel-body">

			<h3 class="panel-title">Jugadores disponibles</h3>
			<div class="btn btn-droppable" data-drop="true" data-jqyoui-options="{stack: true, accept:'.btn-draggable:not([ ng-model = plantillaLocal ])'}">
				<div class="btn btn-info btn-draggable" ng-repeat='jugador in plantillaLocal' data-drag="true" 
					data-jqyoui-options="{revert: 'invalid'}" jqyoui-draggable="{index: <%$index%>, animate:true}" >
					<% jugador.jug_nombre %> &nbsp; <% jugador.jug_apellido %>
				</div>
			</div>

			<h3 class="panel-title">Jugadores titulares</h3>
			<div class="thumbnail" data-drop="true" ng-model='jugadoresTitulares.local' 
				data-jqyoui-options="{accept:'.btn-draggable:not([ng-model = jugadoresTitulares.local])'}"  jqyoui-droppable="{multiple:true}">
              	<div class="caption">
                	<div class="btn btn-info btn-draggable" ng-repeat="jugador in jugadoresTitulares.local" data-drag="true" 
                		data-jqyoui-options="{revert: 'invalid'}" ng-model="jugadoresTitulares.local" jqyoui-draggable="{index: <% $index %>,animate:true}">
                		<% jugador.jug_nombre %> &nbsp; <% jugador.jug_apellido %>
                	</div>
              	</div>
            </div>

			

		</div>
	</div>
</div>

