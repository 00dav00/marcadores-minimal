<?php

namespace App\Domain;

use DB;
use App\Quotation;
use App\Torneo;
use App\Fase;


class DomTablas {

    protected $_torneo;
    protected $_fase;
    protected $_cliente;


 /****************** WRAPPERS PARA CLASES **************************/
    private function torneoInstance() {
        if (!$this->_torneo) {
            $this->_torneo = new Torneo;
        }
        return $this->_torneo;
    }

    private function faseInstance() {
        if (!$this->_fase) {
            $this->_fase = new Fase;
        }
        return $this->_fase;
    }

/****************** WRAPPERS PARA CLASES **************************/

    public function obtenerTablaPosicionesPorFase($torneo_id, $fase_id) {
        $parametros = [$torneo_id, $fase_id, $fase_id, $torneo_id];
        $equiposBuscados = "SELECT eqp_id FROM equipos_participantes WHERE tor_id = ?";

        if ($fase_id != -1) {
            $fase = $this->faseInstance()->find($fase_id);

            if ( !$fase->fas_acumulada ) {
                $parametros = [$torneo_id, $fase_id, $fase_id, $fase_id, $fase_id];
                $equiposBuscados = 'SELECT par_eqp_local FROM  partidos p JOIN fechas f ON p.fec_id = f.fec_id where fas_id = ?
                                    union
                                    SELECT par_eqp_visitante FROM partidos p JOIN fechas f ON p.fec_id = f.fec_id where fas_id = ?';
            }
        }

        $sql = 
            'SELECT
                deq_id                                              id 
                ,deq_equipo_nombre                                  nombre
                ,deq_equipo_nombre_corto                            nombre_corto
                ,deq_equipo_abreviatura                             abreviatura
                ,deq_equipo_escudo                                  escudo
                ,IFNULL(puntos,0)               puntos
                ,IFNULL(partidos_jugados,0)     partidos_jugados
                ,IFNULL(partidos_ganados,0)     partidos_ganados
                ,IFNULL(partidos_empatados,0)   partidos_empatados
                ,IFNULL(partidos_perdidos,0)    partidos_perdidos
                ,IFNULL(goles_favor,0)          goles_favor
                ,IFNULL(goles_contra,0)         goles_contra
                ,IFNULL(goles_diferencia,0)     goles_diferencia
            FROM dim_equipos
                LEFT OUTER JOIN (
                    SELECT
                        equipo_fk
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
                    WHERE
                        dfe_torneo_id = ?
                        AND (
                            (-1 = ? AND dfe_fase_acumulada = 1)
                            OR (dfe_fase_id = ?)
                        )
                    GROUP BY equipo_fk
                ) tabla on deq_id = equipo_fk
                WHERE deq_id IN ('. $equiposBuscados .')
                ORDER BY puntos DESC, goles_diferencia DESC';

        $tabla = DB::select($sql, $parametros);

        return $tabla;
    }

    public function obtenerTablasTorneo($torneo_id) {
        $torneo = $this->torneoInstance()->find($torneo_id);

        $tablas = [];
        // $tablas = $torneo
        $torneo->fases()->get()
                // ->map( function ($fase) use ($tablas){
                ->map( function ($fase) use (&$tablas){
                    // return ["$fase->fas_id " => $this->obtenerTablaPosicionesPorFase($fase->tor_id, $fase->fas_id) ];
                    $tablas[$fase->fas_id] = $this->obtenerTablaPosicionesPorFase($fase->tor_id, $fase->fas_id);
                });

        if ( $torneo->contieneFaseAcumulada() ) {
            // $tablas = $tablas->push(["acumulada" => $this->obtenerTablaPosicionesPorFase($torneo_id, -1) ]);
            $tablas["acumulada"] = $this->obtenerTablaPosicionesPorFase($torneo_id, -1);
        }

        // return $tablas->collapse();
        return $tablas;
    }

    public function obtenerTablaGoleadores($torneo_id) {
        $sql = "SELECT
                    CONCAT(jug_nombre, ' ', jug_apellido)                       jugador
                    ,COUNT(CASE WHEN gol_auto = 0 THEN 1 ELSE NULL END)         goles
                FROM partido_goles g
                    JOIN jugadores j ON g.gol_autor = j.jug_id
                WHERE par_id IN (
                    SELECT par_id FROM partidos p
                        JOIN fechas h ON h.fec_id = p.fec_id
                        JOIN fases f ON f.fas_id = h.fas_id
                        JOIN torneos t ON t.tor_id = f.tor_id
                    WHERE t.tor_id = ?
                )
                GROUP BY jug_nombre, jug_apellido
                HAVING COUNT(CASE WHEN gol_auto = 0 THEN 1 ELSE NULL END) > 0
                ORDER BY 2 DESC";

        $tabla = DB::select($sql, [$torneo_id]);

        return $tabla;   
    }
}