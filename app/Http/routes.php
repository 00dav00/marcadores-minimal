<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'WelcomeController@index');

Route::get('lugares/consulta/{busqueda}', 'LugaresController@consulta');
Route::resource('lugares', 'LugaresController');

Route::resource('jugadores', 'JugadoresController');

Route::resource('equipos', 'EquiposController');

Route::get('tipo_torneo/consulta', 'TipoTorneoController@consulta');
Route::resource('tipo_torneo', 'TipoTorneoController');

Route::resource('torneos', 'TorneosController');

Route::resource('estadios', 'EstadiosController');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);
