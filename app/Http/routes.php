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

// Route::group(['middleware' => 'auth'], function()
// {

	Route::get('/', 'TorneosController@index');

	Route::get('lugares/consulta/{busqueda}', 'LugaresController@consulta');
	Route::resource('lugares', 'LugaresController');

	Route::get('jugadores/consulta', 'JugadoresController@consulta');
	Route::resource('jugadores', 'JugadoresController');

	Route::get('equipos/consulta', 'EquiposController@consulta');
	Route::resource('equipos', 'EquiposController');

	Route::get('torneos/consulta', 'TorneosController@consulta');
	Route::get('torneos/{torneos}/equipos', 'TorneosController@equiposParticipantes');
	Route::get('torneos/{torneos}/equipos/{equipos}', 'TorneosController@jugadoresEquipoParticipante');
	Route::resource('torneos', 'TorneosController');

	Route::get('tipo_fase/consulta', 'TipoFaseController@consulta');
	Route::resource('tipo_fase', 'TipoFaseController');

	Route::get('tipo_torneo/consulta', 'TipoTorneoController@consulta');
	Route::resource('tipo_torneo', 'TipoTorneoController');

	Route::get('torneos/consulta', 'TorneosController@consulta');
	Route::resource('torneos', 'TorneosController');

	Route::get('tipo_fase/consulta', 'TipoFaseController@consulta');
	Route::resource('tipo_fase', 'TipoFaseController');

	Route::get('fases/consulta', 'FaseController@consulta');
	Route::resource('fases', 'FaseController');

	Route::resource('fechas', 'FechasController');

	Route::get('estadios/consulta', 'EstadiosController@consulta');
	Route::resource('estadios', 'EstadiosController');

	Route::get('tipos_evento/consulta', 'TiposEventoController@consulta');
	Route::resource('tipos_evento', 'TiposEventoController');

	Route::resource('fechas/{fechas}/partidos','PartidoController');

	Route::resource('plantillas', 'PlantillasTorneoController');


	Route::resource('equipos_participantes', 'EquiposParticipantesController');

	Route::resource('fechas', 'FechasController');

	Route::get('auth/register', 'Auth\AuthController@getRegister');
	Route::post('auth/register', 'Auth\AuthController@postRegister');
	Route::get('auth/logout', 'Auth\AuthController@getLogout');

// });

Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
