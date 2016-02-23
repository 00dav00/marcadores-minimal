var app = angular.module(
	'plantillaApp', 
	['torneoServices','plantillaControllers','ui.bootstrap'], 
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

var app3 = angular.module(
	'tablasApp', 
	['torneoServices','tablasControllers','ui.bootstrap'], 
	function($interpolateProvider) {
		$interpolateProvider.startSymbol('<%');
		$interpolateProvider.endSymbol('%>');
	}
);


var app4 = angular.module(
	'fechasApp', 
	['torneoServices','fechasControllers','ui.bootstrap'], 
	function($interpolateProvider) {
		$interpolateProvider.startSymbol('<%');
		$interpolateProvider.endSymbol('%>');
	}
);


var app5 = angular.module(
	'partidosApp', 
	['torneoServices','partidosControllers','ui.bootstrap'], 
	function($interpolateProvider) {
		$interpolateProvider.startSymbol('<%');
		$interpolateProvider.endSymbol('%>');
	}
);
