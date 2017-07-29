var elixir = require('laravel-elixir');

require('laravel-elixir-sass-compass');


// funciones principales de elixir
elixir(function(mix) {
  mix.copy(
    './bower_components/bootstrap-sass/assets/fonts/bootstrap',
    'public/assets/fonts/bootstrap'
  );
  mix.copy(
    './bower_components/selectize/dist/css/selectize.css',
    'public/assets/css/vendor/selectize.css'
  );

  mix.copy(
    './bower_components/angular-dragdrop/src/angular-dragdrop.min.js',
    'public/assets/js/vendor/'
  );
  mix.copy(
    './bower_components/jquery-ui/jquery-ui.min.js',
    'public/assets/js/vendor/'
  );


    /**
   * **************** copiar scripts ****************
   */
  mix.scripts(
    [
      './bower_components/jquery/dist/jquery.js',
      './bower_components/bootstrap-sass/assets/javascripts/bootstrap.js'
    ],
    'public/assets/js/principal.js'
  )

  mix.scripts(
    [
      './bower_components/angular/angular.js',
      './bower_components/angular-resource/angular-resource.js',
      './bower_components/angular-animate/angular-animate.js',
      './bower_components/angular-spinner/angular-spinner.js',
      './bower_components/angular-bootstrap/ui-bootstrap-tpls.js',
      './bower_components/angular-dragdrop/src/angular-dragdrop.js',
      './bower_components/spin.js/spin.js',
      './bower_components/AngularJS-Toaster/toaster.js'
    ],
    'public/assets/js/angular-scripts.js'
  )


  mix.scripts(
    [
      './bower_components/jquery/dist/jquery.js',
      './bower_components/angular/angular.js',
      './bower_components/angular-dragdrop/src/angular-dragdrop.js',
      './bower_components/angular-resource/angular-resource.js',
      './bower_components/AngularJS-Toaster/toaster.js'
    ],
    'public/assets/js/tablas.js'
  );

  mix.scripts(
    [
      './bower_components/jquery/dist/jquery.js',
      './bower_components/angular/angular.js',
      './bower_components/angular-resource/angular-resource.js',
      './bower_components/AngularJS-Toaster/toaster.js',
      'resultados/app.js',
      'resultados/controller.js',
      'resultados/exception.js',
      'resultados/factory.js'
    ],
    'public/assets/js/resultados.js'
  );

  /**
   * **************** combinar sass ****************
   */
  mix.sass('principal.scss', 'public/assets/css/principal.css');
  mix.sass('resultados/resultados.scss', 'public/assets/css/resultados/resultados.css');
  mix.sass('tablas/style.scss', 'public/assets/css/tablas/style.css');
  mix.sass('cancheros/resultados/resultados.scss', 'public/assets/css/cancheros/resultados/resultados.css');
  mix.sass('cancheros/tablas/style.scss', 'public/assets/css/cancheros/tablas/style.css');
})
