<div class="form-inline">

	<div class="row">
		<div class="form-group">
			<label>Ancho</label>
			<input type="number" class="form-control" min="300" max="800" step="10" ng-model="main.iframeWidth">
		</div>

		<div class="form-group">
			<label>Largo</label>
			<input type="number" class="form-control" min="500" max="1000" step="10" ng-model="main.iframeHeight">
		</div>
	</div>

	<br>

	<div class="row">
		<div class="form-group">
			<input type="text" class="form-control" value="https://marcadores.dataprensa.com<%main.url%>" style="width:450px;">
			<button class="btn btn-default" onclick="refrescar()">Refrescar</button>
		</div>
	</div>

	<br>
	
	<div class="row">
		<iframe id="iframeTablas" src="<%main.url%>" sandbox="allow-same-origin allow-scripts" width="<%main.iframeWidth%>px" height="<%main.iframeHeight%>px"></iframe>
	</div>

	<script>
		function refrescar()
		{
			$('#iframeTablas')[0].contentWindow.location.reload(true);
		}
	</script>

</div>