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

Route::get('jugadores/consulta', 'JugadoresController@consulta');
Route::resource('jugadores', 'JugadoresController');

Route::get('equipos/consulta', 'EquiposController@consulta');
Route::resource('equipos', 'EquiposController');

Route::get('tipo_torneo/consulta', 'TipoTorneoController@consulta');
Route::resource('tipo_torneo', 'TipoTorneoController');

Route::get('torneos/consulta', 'TorneosController@consulta');
Route::get('torneos/{torneos}/equipos', 'TorneosController@equiposParticipantes');
Route::get('torneos/{torneos}/equipos/{equipos}', 'TorneosController@jugadoresEquipoParticipante');
Route::resource('torneos', 'TorneosController');

Route::get('tipo_fase/consulta', 'TipoFaseController@consulta');
Route::resource('tipo_fase', 'TipoFaseController');

Route::resource('fases', 'FaseController');

Route::resource('plantillas', 'PlantillasTorneoController');

Route::resource('equipos_participantes', 'EquiposParticipantesController');

Route::resource('fechas', 'FechasController');

Route::get('estadios/consulta', 'EstadiosController@consulta');
Route::resource('estadios', 'EstadiosController');

Route::resource('tipos_evento', 'TiposEventoController');

Route::resource('fechas/{fechas}/partidos','PartidoController');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);
