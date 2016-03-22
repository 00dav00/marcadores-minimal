<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;


use App\Http\Requests\AmonestacionRequest;
use App\Domain\DomAmonestacion;


class ApiAmonestacionesController extends Controller{

    protected $_amonestacion ;
    
    /****************** WRAPPERS PARA CLASES **************************/
    private function domainAmonestacionInstance() {
        if (!$this->_amonestacion) {
            $this->_amonestacion = new DomAmonestacion;
        }
        return $this->_amonestacion;
    }
    /****************** WRAPPERS PARA CLASES **************************/

    public function store(AmonestacionRequest $request) {
        $resultado = $this->domainAmonestacionInstance()
                            ->ingresarAmonestacion($request->all());

        if(!isset($resultado)) {
            return \Response::make('No sepuede amonestar a este jugador', 422);
        }

        return \Response::make(null, 200);        
    }

    public function update(AmonestacionRequest $request, $id) {
        $amonestacion = $request->all();

        $resultado = $this->domainAmonestacionInstance()
                            ->actualizarAmonestacion($id, $amonestacion['amn_minuto']);

        if(!isset($resultado)) {
            return \Response::make(null, 500);
        }

        return \Response::make(null, 200);   
    }

    public function destroy($id) {
        $resultado = $this->domainAmonestacionInstance()
                            ->eliminarAmonestacion($id);

        if (!isset($resultado)) {
            return \Response::make(null, 500);
        }

        return \Response::make(null, 200);
    }
}
