var app = angular.module(
	'plantillaApp', 
	['torneoServices','plantillaControllers'], 
	function($interpolateProvider) {
		$interpolateProvider.startSymbol('<%');
		$interpolateProvider.endSymbol('%>');
	}
);

