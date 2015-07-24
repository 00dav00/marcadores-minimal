var app = angular.module(
	'plantillaApp', 
	['torneoServices','plantillaControllers'], 
	function($interpolateProvider) {
		$interpolateProvider.startSymbol('<%');
		$interpolateProvider.endSymbol('%>');
	}
);

var app2 = angular.module(
	'torneoApp', 
	['torneoServices','torneoControllers','ui.bootstrap'], 
	function($interpolateProvider) {
		$interpolateProvider.startSymbol('<%');
		$interpolateProvider.endSymbol('%>');
	}
);