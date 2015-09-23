<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
// use Illuminate\Http\Response;

use DB;
use App\Quotation;

class TablasController extends Controller {

	public function index()
	{
		return view ('tablas.index');
	}

	public function create()
	{

	}

	public function store()
	{
	}

	public function show($id)
	{

	}

	public function edit($id)
	{
	}

	public function update($id)
	{
	}

	public function destroy($id)
	{
	}

	public function listado()
	{
		return view('tablas.list');
	}

	public function preview($torneo_id)
	{
		return view('tablas.preview', compact('torneo_id'));
	}

	// public function apiShow($torneo_id, $fase_id = -1){

	// 	$resultados = DB::select(
	// 		'SELECT
	// 			deq_equipo_nombre									nombre
	// 			,deq_equipo_nombre_corto							nombre_corto
	// 			,deq_equipo_abreviatura								abreviatura
	// 			,deq_equipo_escudo 									escudo
	// 			,sum(puntos-penalizacion) 							puntos
	// 			,count(*)											partidos_jugados
	// 			,count(case when puntos = 3 then 1 else NULL end)	partidos_ganados
	// 			,count(case when puntos = 1 then 1 else NULL end)	partidos_empatados
	// 			,count(case when puntos = 0 then 1 else NULL end)	partidos_perdidos
	// 			,sum(goles_favor) 									goles_favor
	// 			,sum(goles_contra) 									goles_contra
	// 			,sum(goles_favor)-sum(goles_contra)					goles_diferencia
	// 		from fact_resultados
	// 			join dim_fechas on dfe_id = fecha_fk
	// 			join dim_equipos on deq_id = equipo_fk
	// 		where
	// 			dfe_torneo_id = ?
	// 			and (
	// 				(? = -1 and dfe_fase_acumulada = 1)
	// 				or (? = dfe_fase_id)
	// 			)
	// 		group by deq_equipo_nombre, deq_equipo_nombre_corto, deq_equipo_abreviatura, deq_equipo_escudo
	// 		order by puntos desc, goles_diferencia desc', 
	// 		[$torneo_id, $fase_id, $fase_id]
	// 	);

	// 	return \Response::json($resultados);
	// 	// return response()->json(['data' => $resultados]);
	// }
}
