<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\PlantillaTorneo;
use App\Http\Requests\PlantillaTorneoRequest;

class ApiPlantillasTorneoController extends Controller
{
    protected $plantillaTorneo;

    public function __construct(PlantillaTorneo $plantillaTorneo)
    {
        $this->plantillaTorneo = $plantillaTorneo;
    }

    public function index()
    {
        $plantillaTorneo = $this->plantillaTorneo->orderBy('plt_id','asc')->get();

        return $plantillaTorneo->toJson();
    }

    public function store(PlantillaTorneoRequest $request)
    {
        $plantilla = $this->plantillaTorneo->create($request->all());

        return $plantilla->toJson();
    }

    public function show($id)
    {
        return $this->plantillaTorneo->findOrFail($id);
    }

    public function update(PlantillaTorneoRequest $request, $id)
    {
        $plantilla = $this->plantillaTorneo->find($id);

        if(!isset($plantilla))
            return \Response::make(null, 404);
           
        $plantilla->update($request->all());
        return \Response::make(null, 200);
    }

    public function destroy($id)
    {
        $plantilla = $this->plantillaTorneo->find($id);
        
        if(!isset($plantilla))
            return \Response::make(null, 404);

        $plantilla->delete();
        return \Response::make(null, 200);
    }
}
