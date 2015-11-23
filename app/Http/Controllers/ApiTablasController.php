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

class ApiTablasController extends Controller
{

    protected $_torneo;
    protected $_fase;
    protected $_cliente;

    public function __construct(Torneo $torneo, Fase $fase, Cliente $cliente)
    {
        $this->_torneo = $torneo;
        $this->_fase = $fase;
        $this->_cliente = $cliente;
    }

    protected function _chainResults($torneo, $fases, $posiciones, $cliente)
    {
        return [
            'torneo' => $torneo,
            'fases' => $fases,
            'posiciones' => $posiciones,
            'cliente' => $cliente
        ];
    }

    public function getTorneoInfo($torneo_id)
    {
        return $this->_torneo->findOrFail($torneo_id);
    }

    public function getFaseInfo($torneo_id)
    {
        return $this->_fase->where('tor_id', '=', $torneo_id)->get();
    }

    public function getTablaPosiciones($torneo_id, $fase_id)
    {
        $sql = 
            'SELECT 
            deq_equipo_nombre                                   nombre
            ,deq_equipo_nombre_corto                            nombre_corto
            ,deq_equipo_abreviatura                             abreviatura
            ,deq_equipo_escudo                                  escudo
            ,sum(puntos-penalizacion)                           puntos
            ,count(*)                                           partidos_jugados
            ,count(case when puntos = 3 then 1 else NULL end)   partidos_ganados
            ,count(case when puntos = 1 then 1 else NULL end)   partidos_empatados
            ,count(case when puntos = 0 then 1 else NULL end)   partidos_perdidos
            ,sum(goles_favor)                                   goles_favor
            ,sum(goles_contra)                                  goles_contra
            ,sum(goles_favor)-sum(goles_contra)                 goles_diferencia
            FROM fact_resultados
                join dim_fechas ON dfe_id = fecha_fk
                join dim_equipos ON deq_id = equipo_fk
            WHERE
                dfe_torneo_id = ?
                AND (
                    (? = -1 AND dfe_fase_acumulada = 1)
                    OR (? = dfe_fase_id)
                )
            GROUP BY deq_equipo_nombre, deq_equipo_nombre_corto, deq_equipo_abreviatura, deq_equipo_escudo
            ORDER BY puntos DESC, goles_diferencia DESC';

        return DB::select($sql, [$torneo_id, $fase_id, $fase_id]);
    }

    public function getClienteInfo($cliente_id)
    {
        return $this->_cliente->with('personalizacion')->find($cliente_id);
    }

    public function showTorneoTablas($cliente_id, $torneo_id)
    {
        // verificar que el torneo existe
        $torneo = $this->getTorneoInfo($torneo_id);

        // obtener las fases
        $fases = $this->getFaseInfo($torneo_id);

        // obtener la informacion del cliente
        $cliente = $this->getClienteInfo($cliente_id);
        
        $posiciones = [];
        $acumulada = 0;
        
        foreach ($fases as $fase) {
            $posiciones[$fase->fas_id] = $this->getTablaPosiciones($torneo_id, $fase->fas_id);
            if ($fase->fas_acumulada) {
                $acumulada++;
            }
        }

        // tabla acumulada
        if ($acumulada > 1) {
            $posiciones['acumulada'] = $this->getTablaPosiciones($torneo_id, -1);
        }

        // unir los resultados
        $response = $this->_chainResults($torneo, $fases, $posiciones, $cliente);

        return response()->json($response);
    }

}