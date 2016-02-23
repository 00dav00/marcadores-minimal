<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Http\Requests\PartidoGolRequest;
use App\PartidoGol;
use App\Domain\DomGol;

class ApiPartidoGolesController extends Controller
{
    protected $_partidoGol;
    protected $_gol;

    public function __construct(PartidoGol $partidoGol) {
        $this->_partidoGol = $partidoGol;
    }

    private function domainInstance() {
        if (!$this->_gol) {
            $this->_gol = new DomGol;
        }
        return $this->_gol;
    }

    public function store(PartidoGolRequest $request) {
        return $this->domainInstance()
                    ->ingresarGol($request->all())
                    ->toJson();
    }

    public function show($id) {
        return $this->_partidoGol->find($id)->toJson();   
    }

    public function obtenerGolesPartido($partido_id) {
        return $this->domainInstance()
                    ->obtenerGolesPartido($partido_id)
                    ->toJson();   
    }

    public function update(PartidoGolRequest $request, $id) {
        $partidoGol = $this->_partidoGol->find($id);
        
        if(!isset($partidoGol))
            return \Response::make(null, 404);

        $partidoGol->update($request->all());
        return \Response::make(null, 200);
    }

    public function destroy($id) {
        $partidoGol = $this->_partidoGol->find($id);
        
        if(!isset($partidoGol))
            return \Response::make(null, 404);

        $partidoGol->delete();
        return \Response::make(null, 200);
    }
}
