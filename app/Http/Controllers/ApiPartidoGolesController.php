<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Http\Requests\PartidoGolRequest;
use App\PartidoGol;

class ApiPartidoGolesController extends Controller
{
    protected $_partidoGol;

    public function __construct(PartidoGol $partidoGol) {
        $this->_partidoGol = $partidoGol;
    }

    public function store(PartidoGolRequest $request) {
        return $this->_partidoGol->ingresarGol($request->all())->toJson();
    }

    public function show($id) {
        return $this->_partidoGol->find($id)->toJson();   
    }

    public function obtenerGolesPartido($partido_id) {
        return $this->_partidoGol
                    ->with('autor','asistente')
                    ->where('par_id',$partido_id)
                    ->get()
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
