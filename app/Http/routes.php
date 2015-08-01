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

	Route::resource('lugares', 'LugaresController');
	Route::get('lugares/consulta/{busqueda}', 'LugaresController@consulta');

	// Route::get('jugadores/consulta', 'JugadoresController@consulta');
	// Route::resource('jugadores', 'JugadoresController');

	Route::get('equipos/consulta', 'EquiposController@consulta');
	Route::resource('equipos', 'EquiposController');

	Route::get('torneos/wizard', 'TorneosController@wizard');
	Route::get('torneos/consulta', 'TorneosController@consulta');
	// Route::get('torneos/{torneos}/equipos/{equipos}/jugadores', 'TorneosController@jugadoresEquipoParticipante');
	Route::resource('torneos', 'TorneosController');
	

	Route::get('api/torneos/{torneos}', 'TorneosController@apiShow');
	Route::get('api/torneos/{torneos}/equipos', 'TorneosController@equiposParticipantes');
	Route::get('api/torneos/{torneos}/fases', 'TorneosController@fasesRegistradas');


	Route::get('tipo_fase/nuevo', 'TipoFaseController@fastCreate');
	// Route::get('tipo_fase/consulta', 'TipoFaseController@consulta');
	Route::resource('tipo_fase', 'TipoFaseController');
	Route::get('api/tipo_fase', 'TipoFaseController@apiIndex');
	Route::post('api/tipo_fase', 'TipoFaseController@apiStore');

	Route::resource('tipo_torneo', 'TipoTorneoController');
	Route::get('tipo_torneo/consulta', 'TipoTorneoController@consulta');

	// Route::get('fases/consulta', 'FaseController@consulta');
	Route::resource('fases', 'FaseController');
	Route::post('api/fases', 'FaseController@apiStore');
	Route::delete('api/fases/{fases}', 'FaseController@apiDestroy');
	Route::get('api/fases/{fases}/fechas', 'FaseController@apiFechasRegistradas');

	Route::get('estadios/consulta', 'EstadiosController@consulta');
	Route::resource('estadios', 'EstadiosController');

	// Route::get('tipos_evento/consulta', 'TiposEventoController@consulta');
	// Route::resource('tipos_evento', 'TiposEventoController');


	// Route::get('plantillas/config', 'PlantillasTorneoController@config');
	// Route::resource('plantillas', 'PlantillasTorneoController');
	// Route::get('api/plantillas/{plantillas}', 'PlantillasTorneoController@apiShow');
	// Route::post('api/plantillas/', 'PlantillasTorneoController@apiStore');
	// Route::put('api/plantillas/{plantillas}', 'PlantillasTorneoController@apiUpdate');
	// Route::delete('api/plantillas/{plantillas}', 'PlantillasTorneoController@apiDestroy');


	Route::resource('equipos_participantes', 'EquiposParticipantesController');
	Route::post('api/equipos_participantes/', 'EquiposParticipantesController@apiStore');
	Route::delete('api/torneos/{torneos}/equipos/{equipos}', 'EquiposParticipantesController@apiDestroy');

	Route::resource('fechas', 'FechasController');
	Route::post('api/fechas', 'FechasController@apiStore');
	Route::put('api/fechas/{fechas}', 'FechasController@apiUpdate');
	Route::delete('api/fechas/{fechas}', 'FechasController@apiDestroy');

	Route::resource('fechas/{fechas}/partidos','PartidoController');

	// Route::get('auth/register', 'Auth\AuthController@getRegister');
	// Route::post('auth/register', 'Auth\AuthController@postRegister');
	// Route::get('auth/logout', 'Auth\AuthController@getLogout');

// });

Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');


