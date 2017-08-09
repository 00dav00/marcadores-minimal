<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\PenalizacionTorneo;

use App\Http\Requests\PenalizacionTorneoRequest;

class ApiPenalizacionesTorneoController extends Controller {

  protected $_penalizacion;

  public function __construct(PenalizacionTorneo $penalizacion) {
    $this->_penalizacion = $penalizacion;
  }

  public function store(PenalizacionTorneoRequest $request) {
    $penalizacion = $this->_penalizacion->create($request->all());

    return $penalizacion->toJson();
  }

  public function update($id, PenalizacionTorneoRequest $request) {
    $penalizacion = $this->_penalizacion->find($id);

    if(!isset($penalizacion))
      return \Response::make(null, 404);

    $penalizacion->update($request->all());
    return \Response::make(null, 200);
  }

  public function destroy($id) {
    $penalizacion = $this->_penalizacion->find($id);

    if(!isset($penalizacion))
      return \Response::make(null, 404);

    $penalizacion->delete();
    return \Response::make(null, 200);
  }
}
