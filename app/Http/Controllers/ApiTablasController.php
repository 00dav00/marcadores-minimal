<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use DB;
use App\Quotation;

use App\Torneo;
use App\Fase;
use App\Cliente;
use App\PersonalizacionValor;
use App\Domain\DomTablas;

class ApiTablasController extends Controller
{

    protected $_torneo;
    protected $_fase;
    protected $_cliente;
    protected $_domain;

    public function __construct(Torneo $torneo, Fase $fase, Cliente $cliente)
    {
        $this->_torneo = $torneo;
        $this->_fase = $fase;
        $this->_cliente = $cliente;
    }

    /****************** WRAPPERS PARA CLASES **************************/
    private function torneoInstance() {
        if (!$this->_torneo) {
            $this->_torneo = new Torneo;
        }
        return $this->_torneo;
    }

    private function domainInstance() {
        if (!$this->_domain) {
            $this->_domain = new DomTablas;
        }
        return $this->_domain;
    }

    private function clientInstance() {
        if (!$this->_cliente) {
            $this->_cliente = new Cliente;
        }
        return $this->_cliente;
    }


    /****************** WRAPPERS PARA CLASES **************************/

    // protected function _chainResults($torneo, $fases, $posiciones, $cliente) {
    //     return [
    //         'torneo'        => $torneo,
    //         'fases'         => $fases,
    //         'posiciones'    => $posiciones,
    //         'cliente'       => $cliente
    //     ];
    // }

    public function getTorneoInfo($torneo_id)
    {
        return $this->_torneo->findOrFail($torneo_id);
    }

    public function getFasesInfo($torneo_id)
    {
        return $this->_fase->where('tor_id', '=', $torneo_id)->get();
    }

    // public function getTablaPosiciones($torneo_id, $fase_id)
    // {
    //     $sql = 
    //         'SELECT
    //         deq_id                                              id 
    //         ,deq_equipo_nombre                                  nombre
    //         ,deq_equipo_nombre_corto                            nombre_corto
    //         ,deq_equipo_abreviatura                             abreviatura
    //         ,deq_equipo_escudo                                  escudo
    //         ,sum(puntos-penalizacion)                           puntos
    //         ,count(*)                                           partidos_jugados
    //         ,count(case when puntos = 3 then 1 else NULL end)   partidos_ganados
    //         ,count(case when puntos = 1 then 1 else NULL end)   partidos_empatados
    //         ,count(case when puntos = 0 then 1 else NULL end)   partidos_perdidos
    //         ,sum(goles_favor)                                   goles_favor
    //         ,sum(goles_contra)                                  goles_contra
    //         ,sum(goles_favor)-sum(goles_contra)                 goles_diferencia
    //         FROM fact_resultados
    //             join dim_fechas ON dfe_id = fecha_fk
    //             join dim_equipos ON deq_id = equipo_fk
    //         WHERE
    //             dfe_torneo_id = ?
    //             AND (
    //                 (? = -1 AND dfe_fase_acumulada = 1)
    //                 OR (? = dfe_fase_id)
    //             )
    //         GROUP BY deq_equipo_nombre, deq_equipo_nombre_corto, deq_equipo_abreviatura, deq_equipo_escudo
    //         ORDER BY puntos DESC, goles_diferencia DESC';

    //     $posiciones = DB::select($sql, [$torneo_id, $fase_id, $fase_id]);

    //     $sql = "
    //         SELECT COUNT(*) AS total
    //         FROM equipos_participantes
    //         WHERE tor_id = ?";

    //     $result = DB::select($sql, [$torneo_id]);

    //     $numeroEquipos = $result[0]->total;

    //     if (is_array($posiciones) && count($posiciones) == $numeroEquipos) {
            
    //         return $posiciones;
        
    //     } else if (count($posiciones) < $numeroEquipos) { 
            
    //         $equipos = $this->_obtenerEquiposParticipantes($fase_id);

    //         // determinar cuales equipos ya tienen resultado
    //         foreach ($posiciones as $posicion) {
    //             $i = 0; 
    //             foreach ($equipos as $equipo) {
    //                 if ($posicion->id == $equipo->id) {
    //                     array_splice($equipos, $i, 1);
    //                     break;
    //                 }
    //                 $i++;
    //             }
    //         }

    //         // agregar 0 a los diferentes valores
    //         foreach ($equipos as $equipo) {
    //             $equipo->puntos = 0;
    //             $equipo->partidos_jugados = 0;
    //             $equipo->partidos_ganados = 0;
    //             $equipo->partidos_empatados = 0;
    //             $equipo->partidos_perdidos = 0;
    //             $equipo->goles_favor = 0;
    //             $equipo->goles_contra = 0;
    //             $equipo->goles_diferencia = 0;
    //         }

    //         // unir con las posiciones
    //         return array_merge($posiciones, $equipos);

    //     } else {

    //         $equipos = $this->_obtenerEquiposParticipantes($fase_id);

    //         foreach ($equipos as $equipo) {
    //             $equipo->puntos = 0;
    //             $equipo->partidos_jugados = 0;
    //             $equipo->partidos_ganados = 0;
    //             $equipo->partidos_empatados = 0;
    //             $equipo->partidos_perdidos = 0;
    //             $equipo->goles_favor = 0;
    //             $equipo->goles_contra = 0;
    //             $equipo->goles_diferencia = 0;
    //         }

    //         return $equipos;
    //     }
    // }

    // protected function _obtenerEquiposParticipantes($fase_id)
    // {
    //     // obtener la lista de equipos de la primera fecha
    //         // que actuan como local
    // 	$sql = "
	   //  	SELECT
	   //  	e.eqp_id                	AS id
	   //  	,e.eqp_nombre               AS nombre
	   //  	,e.eqp_nombre_corto         AS nombre_corto
	   //  	,e.eqp_abreviatura          AS abreviatura
	   //  	,e.eqp_escudo               AS escudo
	   //  	FROM partidos AS p
	   //  	INNER JOIN equipos AS e ON e.eqp_id = p.par_eqp_local
	   //  	WHERE fec_id = (SELECT fec_id FROM fechas WHERE fas_id = ? LIMIT 1)
	   //  	ORDER BY e.eqp_nombre_corto ASC
	   //  	";

    // 	$equiposLocales = DB::select($sql, [$fase_id]);

    //         // obtener la lista de equipos de la primera fecha
    //         // que actuan como visitante
    // 	$sql = "
	   //  	SELECT
	   //  	e.eqp_id                	AS id
	   //  	,e.eqp_nombre               AS nombre
	   //  	,e.eqp_nombre_corto         AS nombre_corto 
	   //  	,e.eqp_abreviatura          AS abreviatura
	   //  	,e.eqp_escudo               AS escudo
	   //  	FROM partidos AS p
	   //  	INNER JOIN equipos AS e ON e.eqp_id = p.par_eqp_visitante
	   //  	WHERE fec_id = (SELECT fec_id FROM fechas WHERE fas_id = ? LIMIT 1)
	   //  	ORDER BY e.eqp_nombre_corto ASC
	   //  	";

    // 	$equiposVisitantes = DB::select($sql, [$fase_id]);

    // 	return array_merge($equiposLocales, $equiposVisitantes);
    // }

    // public function getClienteInfo($cliente_id) {
    //     return $this->_cliente->with('personalizacion')->find($cliente_id);
    // }

    public function goleadores($cliente_id, $torneo_id) {
        // obtener torneo
        $torneo = $this->torneoInstance()->findOrFail($torneo_id);
        // obtener tabla de goleadores
        $posiciones = $this->domainInstance()->obtenerTablaGoleadores($torneo_id);
        // obtener cliente
        $cliente = $this->clientInstance()->with('personalizacion')->find($cliente_id);

        return [
            'torneo'        => $torneo,
            'posiciones'    => $posiciones,
            'cliente'       => $cliente
        ];
    }

    public function showTorneoTablas($cliente_id, $torneo_id) {
        // obtener torneo
        $torneo = $this->torneoInstance()->findOrFail($torneo_id);
        // obtener las fases
        $fases = $torneo->obtenerArraySimplificadoFases();
        // obtener cliente
        $cliente = $this->clientInstance()->with('personalizacion')->find($cliente_id);
        // obtener las tablas
        $posiciones = $this->domainInstance()->obtenerTablasTorneo($torneo_id);

        return [
            'torneo'        => $torneo,
            'fases'         => $fases,
            'posiciones'    => $posiciones,
            'cliente'       => $cliente
        ];
        // // verificar que el torneo existe
        // $torneo = $this->getTorneoInfo($torneo_id);

        // // obtener las fases
        // $fasesObj = $this->getFasesInfo($torneo_id);

        // // obtener la informacion del cliente
        // $cliente = $this->getClienteInfo($cliente_id);
        
        // $fases = [];
        // $posiciones = [];
        // $acumulada = 0;
        
        // foreach ($fasesObj as $fase) {
        //     $posiciones[$fase->fas_id] = $this->getTablaPosiciones($torneo_id, $fase->fas_id);
        //     if ($fase->fas_acumulada) {
        //         $acumulada++;
        //     }
        //     $fases[$fase->fas_id] = [
        //         'fas_id' => $fase->fas_id,
        //         'fas_descripcion' => $fase->fas_descripcion
        //         ];
        // }

        // // tabla acumulada
        // if ($acumulada > 1) {
        //     $posiciones['acumulada'] = $this->getTablaPosiciones($torneo_id, -1);
        //     $fases['acumulada'] = [
        //         'fas_id' => 'acumulada',
        //         'fas_descripcion' => 'Acumulada'
        //         ];
        // }

        // // unir los resultados
        // $response = $this->_chainResults($torneo, $fases, $posiciones, $cliente);

        // return response()->json($response);
    }


}
