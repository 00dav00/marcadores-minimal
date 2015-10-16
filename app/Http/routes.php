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

	Route::get('torneos/wizard', 'TorneosController@wizard');
	Route::get('torneos/config', 'TorneosController@config');
	Route::resource('torneos', 'TorneosController');
	// Route::get('torneos/config/{config}', 'TorneosController@config');

	Route::resource('equipos', 'EquiposController');
	
	Route::resource('lugares', 'LugaresController');

	Route::resource('tipo_torneo', 'TipoTorneoController');

	Route::get('tipo_fase/nuevo', 'TipoFaseController@fastCreate');
	Route::resource('tipo_fase', 'TipoFaseController');

	Route::resource('fases', 'FaseController');

	Route::resource('estadios', 'EstadiosController');
	
	Route::resource('equipos_participantes', 'EquiposParticipantesController');

	Route::resource('jugadores', 'JugadoresController');

	Route::get('fechas/list', 'FechasController@listado');
	Route::resource('fechas', 'FechasController');


	//Route::get('api/fechas/{fechas}/partidos', 'FechasController@apiFechaPartidos');

	Route::resource('fechas/{fechas}/partidos','PartidoController');

	//Route::get('api/partidos/{fecha}','PartidoController@apiShowPartidosFecha');


	Route::get('auth/register', 'Auth\AuthController@getRegister');
	Route::post('auth/register', 'Auth\AuthController@postRegister');
	Route::get('auth/logout', 'Auth\AuthController@getLogout');

	Route::get('tablas', 'TablasController@index');
	Route::get('tablas/list', 'TablasController@listado');

});

// Rutas para consultar datos REST
Route::group(['prefix' => 'api', 'middleware' => 'auth'], function () {

	Route::get('lugares/consulta/{busqueda}', 'ApiLugaresController@consulta');

	Route::get('equipos/consulta', 'ApiEquiposController@consulta');
	Route::get('equipos', 'ApiEquiposController@index');

	Route::get('torneos/consulta', 'ApiTorneosController@consulta');
	Route::get('torneos', 'ApiTorneosController@index');

	Route::get('tipo_torneo/consulta', 'ApiTipoTorneoController@consulta');

	Route::get('tipo_fase/consulta', 'ApiTipoFaseController@consulta');
	Route::get('tipo_fase', 'ApiTipoFaseController@index');
	Route::post('tipo_fase', 'ApiTipoFaseController@store');

	Route::get('fases/consulta', 'ApiFaseController@consulta');
	Route::post('fases', 'ApiFaseController@store');
	Route::delete('fases/{fases}', 'ApiFaseController@destroy');

	Route::get('estadios/consulta', 'ApiEstadiosController@consulta');
	Route::get('estadios', 'ApiEstadiosController@index');

	Route::get('torneos/consulta', 'ApiTorneosController@consulta');
	Route::get('torneos/{torneos}/equipos', 'ApiTorneosController@equiposParticipantes');
	Route::post('equipos_participantes/', 'ApiEquiposParticipantesController@store');
	Route::delete('torneos/{torneos}/equipos/{equipos}', 'ApiEquiposParticipantesController@destroy');

	Route::get('fases/{fases}/fechas', 'ApiFaseController@fechasRegistradas');
	Route::post('fechas', 'ApiFechasController@Store');
	Route::put('fechas/{fechas}', 'ApiFechasController@Update');
	Route::delete('fechas/{fechas}', 'ApiFechasController@Destroy');

	Route::get('fechas/{fechas}/partidos','ApiFechasController@fechaPartidosRegistrados');
	Route::post('partidos','ApiPartidosController@store');
	Route::delete('partidos/{partido}','ApiPartidosController@destroy');
	Route::put('partidos/{partido}','ApiPartidosController@update');

	Route::resource('plantillasTorneo', 'ApiPlantillasTorneoController');

	Route::get('penalizaciones/{torneo}', 'ApiPenalizacionesTorneoController@show');
	Route::post('penalizaciones', 'ApiPenalizacionesTorneoController@store');
	Route::put('penalizaciones/{torneo}/{fase}/{equipo}', 'ApiPenalizacionesTorneoController@update');
	Route::delete('penalizaciones/{torneo}/{fase}/{equipo}', 'ApiPenalizacionesTorneoController@destroy');
	
	// Route::get('jugadores/consulta', 'JugadoresController@consulta');
	// Route::get('torneos/{torneos}/equipos/{equipos}/jugadores', 'TorneosController@jugadoresEquipoParticipante');

});

Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');

Route::get('/visual/torneo/{torneo}/tablas', 'TablasController@preview');
Route::get('/visual/fechas/{fechas}/partidos', 'FechasController@preview');
Route::get('/visual/fases/{fases}/fecha_actual/partidos', 'FechasController@previewFechaActual');
Route::get('/visual/widget/fechas/{fechas}/partidos', 'FechasController@widget');
Route::get('/visual/widget/fases/{fases}/fecha_actual/partidos', 'FechasController@widgetFechaActual');

Route::get('api/torneos/{torneos}', 'ApiTorneosController@show');
Route::get('api/torneos/{torneos}/fases', 'ApiTorneosController@fasesRegistradas');
Route::get('api/torneos/{torneos}/tablas', 'ApiTablasController@show');
Route::get('api/torneos/{torneos}/tablas/fases/{fases}', 'ApiTablasController@show');

Route::get('api/fechas/{fechas}', 'ApiFechasController@show');
Route::get('api/fases/{fases}', 'ApiFaseController@show');
Route::get('api/fases/{fases}/fecha_actual', 'ApiFechasController@showFechaActual');
Route::get('api/fechas/{fechas}/partidos', 'ApiFechasController@fechaPartidosRegistrados');

Route::get('api/partidos/{fecha}','ApiPartidosController@showPartidosFecha');
