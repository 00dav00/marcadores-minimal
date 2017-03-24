var elixir = require('laravel-elixir');

require('laravel-elixir-sass-compass');


// funciones principales de elixir
elixir(function(mix) {
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
      './bower_components/spin.js/spin.js',
      './bower_components/AngularJS-Toaster/toaster.js'
    ],
    'public/assets/js/angular-scripts.js'
  )


  mix.scripts(
    [
      './bower_components/jquery/dist/jquery.js',
      './bower_components/angular/angular.js',
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

  mix.compass('cancheros/tablas/style.scss', 'public/assets/css/', {
    require: ['susy'],
      style: "compact",
      sass: "resources/assets/sass"
  });

  mix.compass('cancheros/resultados/resultados.scss', 'public/assets/css/', {
    require: ['susy'],
      style: "compact",
      sass: "resources/assets/sass"
  });
})
