<div class="modal-body">

	<alert ng-repeat="alert in alerts" type="danger" close="closeAlert($index)"><% alert %></alert>
	@include('tipo_fase.partials._form')

</div>

<div class="modal-footer">
    <button class="btn btn-primary" ng-click="ok()">OK</button>
    <button class="btn btn-warning" ng-click="cancel()">Cancel</button>
</div>