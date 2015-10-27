var gulp = require('gulp');

var elixir = require('laravel-elixir');

gulp.task("copyfiles", function() {

	gulp.src("public/js/libs/jquery/dist/jquery.min.js")
		.pipe(gulp.dest("resources/assets/js/"));

	gulp.src("public/js/libs/bootstrap/less/**")
		.pipe(gulp.dest("resources/assets/less/bootstrap"));

	gulp.src("public/js/libs/bootstrap/dist/js/bootstrap.min.js")
		.pipe(gulp.dest("resources/assets/js/"));

	gulp.src("public/js/libs/bootstrap/dist/fonts/**")
	.pipe(gulp.dest("public/assets/fonts"));

});
/**
* Default gulp is to run this elixir stuff
*/
elixir(function(mix) {
	// Combine scripts
	mix.scripts([
		'js/jquery.js',
		'js/bootstrap.js'
	],
		'public/assets/js/admin.js',
		'resources/assets'
	);
	// Compile Less
	mix.less('admin.less', 'public/assets/css/admin.css');
})