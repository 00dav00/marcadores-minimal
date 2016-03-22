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

    public function showTablaGoleadores($cliente_id, $torneo_id) {
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
    }
}
