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

	Route::get('partidos/wizard', 'PartidoController@wizard');

	Route::get('torneos/wizard', 'TorneosController@wizard');
	Route::get('torneos/config', 'TorneosController@config');
	Route::resource('torneos', 'TorneosController');

	Route::resource('equipos', 'EquiposController');
	
	Route::resource('lugares', 'LugaresController');

	Route::resource('tipo_torneo', 'TipoTorneoController');

	Route::get('tipo_fase/nuevo', 'TipoFaseController@fastCreate');
	Route::resource('tipo_fase', 'TipoFaseController');

	Route::resource('fases', 'FaseController');

	Route::resource('estadios', 'EstadiosController');
	
	Route::resource('jugadores', 'JugadoresController');

	Route::get('clientes/wizard', 'ClientesController@wizard');
	Route::resource('clientes', 'ClientesController');

	Route::resource('auspiciantes', 'AuspiciantesController');

	Route::get('fechas/list', 'FechasController@listado');
	Route::resource('fechas', 'FechasController');

	Route::get('plantillas/config', 'PlantillasTorneoController@config');

	Route::resource('auspiciantes', 'AuspiciantesController');

	// Route::get('fechas/list', 'FechasController@listado');
	// Route::resource('fechas', 'FechasController');

	Route::get('plantillas/config', 'PlantillasTorneoController@config');

	Route::resource('fechas/{fechas}/partidos','PartidoController');

	Route::get('auth/register', 'Auth\AuthController@getRegister');
	Route::post('auth/register', 'Auth\AuthController@postRegister');
	Route::get('auth/logout', 'Auth\AuthController@getLogout');

	Route::get('tablas', 'TablasController@index');
	Route::get('tablas/list', 'TablasController@listado');

});

// Rutas para consultar datos REST con autenticacion
Route::group(['prefix' => 'api', 'middleware' => 'auth'], function () {

	Route::get('lugares/consulta/{busqueda}', 'ApiLugaresController@consulta');

	Route::get('equipos/consulta', 'ApiEquiposController@consulta');
	Route::get('equipos', 'ApiEquiposController@index');

	Route::get('torneos/consulta', 'ApiTorneosController@consulta');
	Route::get('torneos', 'ApiTorneosController@index');

	Route::get('tipo_torneo/consulta', 'ApiTipoTorneoController@consulta');

	Route::get('jugadores/consulta', 'ApiJugadoresController@consulta');

	Route::get('tipo_fase/consulta', 'ApiTipoFaseController@consulta');
	Route::get('tipo_fase', 'ApiTipoFaseController@index');
	Route::post('tipo_fase', 'ApiTipoFaseController@store');

	Route::get('fases/consulta', 'ApiFaseController@consulta');
	Route::post('fases', 'ApiFaseController@store');
	Route::delete('fases/{fases}', 'ApiFaseController@destroy');

	Route::get('estadios/consulta', 'ApiEstadiosController@consulta');
	Route::get('estadios', 'ApiEstadiosController@index');

	Route::get('torneos/consulta', 'ApiTorneosController@consulta');
	Route::get('torneos/{torneos}/penalizaciones', 'ApiTorneosController@penalizaciones');
	Route::get('torneos/{torneos}/equipos', 'ApiTorneosController@equiposParticipantes');
	Route::post('equipos_participantes', 'ApiEquiposParticipantesController@store');
	Route::delete('torneos/{torneos}/equipos/{equipos}', 'ApiEquiposParticipantesController@destroy');


	Route::get('fases/{fases}/fechas', 'ApiFaseController@fechasRegistradas');
	Route::post('fechas', 'ApiFechasController@Store');
	Route::put('fechas/{fechas}', 'ApiFechasController@Update');
	Route::delete('fechas/{fechas}', 'ApiFechasController@Destroy');

	Route::get('fechas/{fechas}/partidos','ApiFechasController@fechaPartidosRegistrados');
	Route::post('partidos','ApiPartidosController@store');
	Route::delete('partidos/{partido}','ApiPartidosController@destroy');
	Route::put('partidos/{partido}','ApiPartidosController@update');

	Route::resource('plantillas', 'ApiPlantillasTorneoController');

	Route::post('penalizaciones', 'ApiPenalizacionesTorneoController@store');
	Route::put('penalizaciones/{penalizacion}', 'ApiPenalizacionesTorneoController@update');
	Route::delete('penalizaciones/{penalizacion}', 'ApiPenalizacionesTorneoController@destroy');
	
	Route::get('torneos/{torneos}/equipos/{equipos}/jugadores', 'ApiTorneosController@jugadoresEquipoParticipante');

	Route::get('partidos/{partidos}/equipos/{equipos}/titulares', 'ApiPartidoJugadoresController@obtenerJugadoresTitulares');
	Route::post('partidos/{partidos}/equipos/{equipos}/titulares', 'ApiPartidoJugadoresController@ingresarJugadoresTitulares');
	Route::get('partidos/{partidos}/jugadores/estado', 'ApiPartidoJugadoresController@obtenerJugadoresDisponibilidad');

	// Route::get('partidos/{partidos}/sustituciones', 'ApiPartidoJugadoresController@obtenerSustituciones');
	Route::post('sustituciones/', 'ApiPartidoJugadoresController@ingresarSustitucion');
	Route::put('sustituciones/{sustitucion}', 'ApiPartidoJugadoresController@actualizarSustitucion');
	Route::delete('sustituciones/{sustitucion}', 'ApiPartidoJugadoresController@eliminarSustitucion');

	Route::get('partidos/{partidos}/goles', 'ApiPartidoGolesController@obtenerGolesPartido');
	Route::get('goles/{goles}', 'ApiPartidoGolesController@show');
	Route::post('goles/', 'ApiPartidoGolesController@store');
	Route::put('goles/{goles}', 'ApiPartidoGolesController@update');
	Route::delete('goles/{goles}', 'ApiPartidoGolesController@destroy');

	Route::resource('clientes', 'ApiClientesController');
	Route::resource('productos', 'ApiProductosController');
	
	Route::get('personalizacion_campos', 'ApiPersonalizacionValoresController@getCampos');
	Route::post('personalizacion_campos', 'ApiPersonalizacionValoresController@savePersonalizacionValores');

});

// Rutas para consultar los datos REST sin autenticacion
Route::group(['prefix' => 'api'], function () {

	// tablas
	Route::get('tablas/{cliente_id}/{torneo_id}', 'ApiTablasController@showTorneoTablas');
	Route::get('goleadores/{cliente_id}/{torneo_id}', 'ApiTablasController@tablaGoleadores');

	Route::get('resultados/{cliente_id}/{torneo_id}', 'ApiTablaResultadosController@mostrarUltimaFecha');
	Route::get('resultados/{cliente_id}/{torneo_id}/{fase_id}/{fecha_id}', 'ApiTablaResultadosController@mostrarInformacionFecha');

});

// Rutas para consultar los datos REST sin autenticacion
Route::group(['prefix' => 'visual'], function () {

	// tablas
	Route::get('tablas/{cliente}/{torneo}', 'TablasController@show');
	Route::get('goleadores/{cliente}/{torneo}', 'TablasController@goleadores');

	Route::get('resultados/tabla/{cliente}/{torneo}', 'ResultadosController@tablaShow');

	// personalizado
	// cancheros
	Route::get('/personalizado/tablas/cancheros/{torneo}', 'TablasController@cancherosShow');

	Route::get('/personalizado/resultados/tabla/cancheros/{torneo}', 'ResultadosController@cancherosTablaShow');

});

Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');

// Route::get('/visual/torneo/{torneo}/tablas', 'TablasController@preview');
// Route::get('/visual/fechas/{fechas}/partidos', 'FechasController@preview');
// Route::get('/visual/fases/{fases}/fecha_actual/partidos', 'FechasController@previewFechaActual');
// Route::get('/visual/widget/fechas/{fechas}/partidos', 'FechasController@widget');
// Route::get('/visual/widget/fases/{fases}/fecha_actual/partidos', 'FechasController@widgetFechaActual');

Route::get('api/torneos/{torneos}', 'ApiTorneosController@show');
Route::get('api/torneos/{torneos}/fases', 'ApiTorneosController@fasesRegistradas');
// Route::get('api/torneos/{torneos}/tablas', 'ApiTablasController@show');
// Route::get('api/torneos/{torneos}/tablas/fases/{fases}', 'ApiTablasController@show');

Route::get('api/fechas/{fechas}', 'ApiFechasController@show');
Route::get('api/fases/{fases}', 'ApiFaseController@show');
Route::get('api/fases/{fases}/fecha_actual', 'ApiFechasController@showFechaActual');
Route::get('api/fechas/{fechas}/partidos', 'ApiFechasController@fechaPartidosRegistrados');

Route::get('api/partidos/{fecha}','ApiPartidosController@showPartidosFecha');

Route::get('tablas/{torneo_id}', 'TablasController@show');
Route::get('tablas/{torneo_id}/{fase_id}', 'TablasController@show');


