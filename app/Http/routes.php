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

Route::group(['middleware' => 'auth'], function()
{

	Route::get('/', 'TorneosController@index');

	Route::resource('lugares', 'LugaresController');
	Route::get('lugares/consulta/{busqueda}', 'LugaresController@consulta');

	// Route::get('jugadores/consulta', 'JugadoresController@consulta');
	// Route::resource('jugadores', 'JugadoresController');

	Route::get('equipos/consulta', 'EquiposController@consulta');
	Route::get('api/equipos', 'EquiposController@apiAll');
	Route::resource('equipos', 'EquiposController');

	Route::get('torneos/wizard', 'TorneosController@wizard');
	Route::get('torneos/config', 'TorneosController@config');
	Route::get('torneos/config/{config}', 'TorneosController@config');
	Route::get('torneos/consulta', 'TorneosController@consulta');
	// Route::get('torneos/{torneos}/equipos/{equipos}/jugadores', 'TorneosController@jugadoresEquipoParticipante');
	Route::resource('torneos', 'TorneosController');
	

	//Route::get('api/torneos/{torneos}', 'TorneosController@apiShow');
	Route::get('api/torneos/{torneos}/equipos', 'TorneosController@equiposParticipantes');
	//Route::get('api/torneos/{torneos}/fases', 'TorneosController@fasesRegistradas');
	Route::get('api/torneos', 'TorneosController@apiIndex');


	Route::get('tipo_fase/nuevo', 'TipoFaseController@fastCreate');
	// Route::get('tipo_fase/consulta', 'TipoFaseController@consulta');
	Route::resource('tipo_fase', 'TipoFaseController');
	Route::get('api/tipo_fase', 'TipoFaseController@apiIndex');
	Route::post('api/tipo_fase', 'TipoFaseController@apiStore');

	Route::resource('tipo_torneo', 'TipoTorneoController');
	Route::get('tipo_torneo/consulta', 'TipoTorneoController@consulta');

	// Route::get('fases/consulta', 'FaseController@consulta');
	Route::resource('fases', 'FaseController');
	//Route::get('api/fases/{fases}', 'FaseController@apiShow');
	Route::post('api/fases', 'FaseController@apiStore');
	Route::delete('api/fases/{fases}', 'FaseController@apiDestroy');
	Route::get('api/fases/{fases}/fechas', 'FaseController@apiFechasRegistradas');

	Route::get('estadios/consulta', 'EstadiosController@consulta');
	Route::resource('estadios', 'EstadiosController');
	Route::get('api/estadios', 'EstadiosController@apiIndex');

	Route::resource('equipos_participantes', 'EquiposParticipantesController');
	Route::post('api/equipos_participantes/', 'EquiposParticipantesController@apiStore');
	Route::delete('api/torneos/{torneos}/equipos/{equipos}', 'EquiposParticipantesController@apiDestroy');

	Route::get('fechas/list', 'FechasController@listado');
	Route::resource('fechas', 'FechasController');
	//Route::get('api/fechas/{fechas}', 'FechasController@apiShow');
	Route::post('api/fechas', 'FechasController@apiStore');
	Route::put('api/fechas/{fechas}', 'FechasController@apiUpdate');
	Route::delete('api/fechas/{fechas}', 'FechasController@apiDestroy');

	//Route::get('api/fechas/{fechas}/partidos', 'FechasController@apiFechaPartidos');

	Route::resource('fechas/{fechas}/partidos','PartidoController');

	//Route::get('api/partidos/{fecha}','PartidoController@apiShowPartidosFecha');
	Route::post('api/partidos','PartidoController@apiStore');
	Route::delete('api/partidos/{partido}','PartidoController@apiDestroy');
	Route::put('api/partidos/{partido}','PartidoController@apiUpdate');

	Route::get('api/fechas/{fechas}/partidos','PartidoController@apiIndex');

	Route::get('auth/register', 'Auth\AuthController@getRegister');
	Route::post('auth/register', 'Auth\AuthController@postRegister');
	Route::get('auth/logout', 'Auth\AuthController@getLogout');

	Route::get('tablas', 'TablasController@index');
	Route::get('tablas/list', 'TablasController@listado');

});

// Rutas para consultar datos REST
Route::group(['prefix' => 'api', 'middleware' => 'auth'], function () {

	Route::post('penalizaciones', 'ApiPenalizacionesTorneoController@store');
	Route::put('penalizaciones/{torneo}/{fase}/{equipo}', 'ApiPenalizacionesTorneoController@update');
	Route::delete('penalizaciones/{torneo}/{fase}/{equipo}', 'ApiPenalizacionesTorneoController@destroy');

});

Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');

Route::get('/visual/torneo/{torneo}/tablas', 'TablasController@preview');
Route::get('/visual/fechas/{fechas}/partidos', 'FechasController@preview');
Route::get('/visual/fases/{fases}/fecha_actual/partidos', 'FechasController@previewFechaActual');
Route::get('/visual/widget/fechas/{fechas}/partidos', 'FechasController@widget');
Route::get('/visual/widget/fases/{fases}/fecha_actual/partidos', 'FechasController@widgetFechaActual');

Route::get('api/torneos/{torneos}', 'TorneosController@apiShow');
Route::get('api/torneos/{torneos}/fases', 'TorneosController@fasesRegistradas');
Route::get('api/torneos/{torneos}/tablas', 'TablasController@apiShow');
Route::get('api/torneos/{torneos}/tablas/fases/{fases}', 'TablasController@apiShow');

Route::get('api/fechas/{fechas}', 'FechasController@apiShow');
Route::get('api/fases/{fases}', 'FaseController@apiShow');
Route::get('api/fases/{fases}/fecha_actual', 'FechasController@apiShowFechaActual');
Route::get('api/fechas/{fechas}/partidos', 'FechasController@apiFechaPartidos');

Route::get('api/partidos/{fecha}','PartidoController@apiShowPartidosFecha');

Route::group(['prefix' => 'api'], function () {

	Route::get('penalizaciones/{torneo}', 'ApiPenalizacionesTorneoController@show');

});