var gulp = require('gulp');

var rename = require('gulp-rename');

var elixir = require('laravel-elixir');

require('laravel-elixir-sass-compass');

/**
 * Directorio por defecto en donde se instalan los paquetes de bowe
 */
var path = "vendor/bower_dl/";

gulp.task("copyfiles", function() {

	/**
 	 * **************** jquery ****************
 	 */
	gulp.src(path + "jquery/dist/jquery.min.js")
 		.pipe(gulp.dest("resources/assets/js/vendor"));
 	
 	/**
 	 * **************** bootstrap ****************
 	 */
 	gulp.src(path + "bootstrap-sass/assets/stylesheets/**")
 		.pipe(gulp.dest("resources/assets/sass/bootstrap"));
 	
 	gulp.src(path + "bootstrap-sass/assets/javascripts/bootstrap.min.js")
 		.pipe(gulp.dest("resources/assets/js/vendor"));
 	
 	gulp.src(path + "bootstrap-sass/assets/fonts/bootstrap/**")
 		.pipe(gulp.dest("public/assets/fonts/bootstrap"));

 	gulp.src(path + "bootstrap-sass/assets/fonts/bootstrap/**")
 		.pipe(gulp.dest("public/assets/css/fonts/bootstrap"));

 	/**
 	 * **************** font-awesome ****************
 	 */
 	gulp.src(path + "font-awesome/scss/**")
		.pipe(gulp.dest("resources/assets/sass/font-awesome"));
	
	gulp.src(path + "font-awesome/fonts/**")
		.pipe(gulp.dest("public/assets/fonts/fontawesome"));

	/**
 	 * **************** selectize ****************
 	 */
	gulp.src(path + "selectize/dist/js/standalone/selectize.min.js")
 		.pipe(gulp.dest("public/assets/js/vendor"));

 	gulp.src(path + "selectize/dist/css/selectize.css")
 		.pipe(gulp.dest("public/assets/css/vendor"));

 	/**
 	 * **************** jquery-ui ****************
 	 */
 	gulp.src(path + "jquery-ui/jquery-ui.min.js")
 		.pipe(gulp.dest("public/assets/js/vendor"));

 	gulp.src(path + "jquery-ui/themes/base/**")
 		.pipe(gulp.dest("public/assets/css/vendor/jquery-ui"));

 	/**
 	 * **************** jquery-ui datepicker ****************
 	 */
 	gulp.src(path + "jqueryui-timepicker-addon/dist/jquery-ui-timepicker-addon.min.js")
 		.pipe(gulp.dest("public/assets/js/vendor"));

 	gulp.src(path + "jqueryui-timepicker-addon/dist/jquery-ui-timepicker-addon.min.css")
 		.pipe(gulp.dest("public/assets/css/vendor"));

 	/**
 	 * **************** angular ****************
 	 */
 	gulp.src(path + "angular/angular.js")
 		.pipe(gulp.dest("resources/assets/js/vendor/angular"));

 	/**
 	 * **************** angular resource ****************
 	 */
 	gulp.src(path + "angular-resource/angular-resource.min.js")
 		.pipe(gulp.dest("resources/assets/js/vendor/angular"));

 	/**
 	 * **************** angular animate ****************
 	 */
 	gulp.src(path + "angular-animate/angular-animate.min.js")
 		.pipe(gulp.dest("resources/assets/js/vendor/angular"));

 	/**
 	 * **************** angular bootstrap ****************
 	 */
 	gulp.src(path + "angular-bootstrap/ui-bootstrap-tpls.min.js")
 		.pipe(gulp.dest("resources/assets/js/vendor/angular"));

 	/**
 	 * **************** angular spinner ****************
 	 */
 	gulp.src(path + "spin.js/spin.min.js")
 		.pipe(gulp.dest("resources/assets/js/vendor/angular"));

 	gulp.src(path + "angular-spinner/angular-spinner.min.js")
 		.pipe(gulp.dest("resources/assets/js/vendor/angular"));

 	/**
 	 * **************** angular toaster ****************
 	 */
 	gulp.src(path + "AngularJS-Toaster/toaster.min.js")
 		.pipe(gulp.dest("resources/assets/js/vendor/angular"));

 	gulp.src(path + "AngularJS-Toaster/toaster.min.css")
 		.pipe(gulp.dest("public/assets/css/vendor"));

 	/**
 	 * **************** angular dragdrop ****************
 	 */
 	gulp.src(path + "angular-dragdrop/src/angular-dragdrop.min.js")
 		.pipe(gulp.dest("public/assets/js/vendor"));

 	/**
 	 * **************** bootstrap para tablas ****************
 	 */
 	// gulp.src(path + "bootstrap-sass/assets/stylesheets/**")
 	// 	.pipe(gulp.dest("resources/assets/sass/tablas/bootstrap"));

 	// gulp.src(path + "bootstrap-sass/assets/fonts/bootstrap/**")
 	// 	.pipe(gulp.dest("public/assets/fonts/tablas/bootstrap"));

 	/**
 	 * **************** bootstrap para resultados ****************
 	 */
 	// gulp.src(path + "bootstrap-sass/assets/stylesheets/**")
 	// 	.pipe(gulp.dest("resources/assets/sass/resultados/bootstrap"));

 	// gulp.src(path + "bootstrap-sass/assets/fonts/bootstrap/**")
 	// 	.pipe(gulp.dest("public/assets/fonts/resultados/bootstrap"));

});

// funciones principales de elixir
elixir(function(mix) {

	/**
 	 * **************** combinar scripts base ****************
 	 */
	mix.scripts([
		'js/vendor/jquery.min.js',
		'js/vendor/bootstrap.min.js'
	],
		'public/assets/js/principal.js',
		'resources/assets'
	);

	/**
 	 * **************** combinar scripts angular ****************
 	 */
	mix.scripts([
		'js/vendor/angular/angular.js',
		'js/vendor/angular/angular-resource.min.js',
		'js/vendor/angular/angular-animate.min.js',
		'js/vendor/angular/ui-bootstrap-tpls.min.js',
		'js/vendor/angular/spin.min.js',
		'js/vendor/angular/angular-spinner.min.js',
		'js/vendor/angular/toaster.min.js'
	],
		'public/assets/js/angular-scripts.js',
		'resources/assets'
	);

	mix.scripts([
		'js/vendor/jquery.min.js',
		'js/vendor/angular/angular.js',
		'js/vendor/angular/angular-resource.min.js',
		'js/vendor/angular/toaster.min.js'
	],
		'public/assets/js/tablas.js',
		'resources/assets'
	);

	mix.scripts([
		'js/vendor/jquery.min.js',
		'js/vendor/angular/angular.js',
		'js/vendor/angular/angular-resource.min.js',
		'js/vendor/angular/toaster.min.js',
		'js/resultados/app.js',
		'js/resultados/controller.js',
		'js/resultados/exception.js',
		'js/resultados/factory.js'
	],
		'public/assets/js/resultados.js',
		'resources/assets'
	);

	/**
 	 * **************** combinar sass ****************
 	 */
	mix.sass('principal.scss', 'public/assets/css/principal.css');

	/**
 	 * **************** combinar compass ****************
 	 */
	// mix.compass("*", "foo/bar/baz", {
	//     require: ['susy'],
	//     config_file: "path/to/config.rb",
	//     style: "nested"
	//     sass: "resources/assets/scss",
	//     font: "public/fonts",
	//     image: "public/images",
	//     javascript: "public/js",
	//     sourcemap: true,
	//     comments: true,
	//     relative: true,
	//     http_path: false,
	//     generated_images_path: false
	// });
	// 
	mix.compass('tablas/style.scss', 'public/assets/css/', {
		require: ['susy'],
	    style: "compact",
	    sass: "resources/assets/sass"
	});

	mix.compass('resultados/resultados.scss', 'public/assets/css/', {
		require: ['susy'],
	    style: "compact",
	    sass: "resources/assets/sass"
	});

})