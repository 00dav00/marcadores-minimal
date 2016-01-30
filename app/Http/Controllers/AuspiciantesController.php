<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Flash;

use App\Auspiciante;
use App\Http\Requests\AuspicianteRequest;

class AuspiciantesController extends Controller
{
    protected $_auspiciante;

    public function __construct(Auspiciante $auspiciante)
    {
        $this->_auspiciante = $auspiciante;
    }

    public function index(Request $request)
    {
        $keyword = $request->get('keyword');
        $column = $request->get('column');
        
        $auspiciantes = $this->_auspiciante->search($keyword, $column);
        $searchFields = $this->_auspiciante->searchFields;

        if (!empty($keyword)) 
            Flash::info("Resultados de la búsqueda: $keyword");

        return view('auspiciantes.index',compact('auspiciantes','searchFields','keyword','column'));
    }

    public function create()
    {
        return view('auspiciantes.create');
    }

    public function store(AuspicianteRequest $request)
    {
        $data = $request->all();

        if ($request->file('aus_imagen'))
            $data['aus_imagen'] = $this->_auspiciante->procesarImagen($request->file('aus_imagen'));

        $this->_auspiciante->create($data);
        Flash::success('Auspiciante creado exitosamente');

        return redirect('auspiciantes');
    }

    public function show($id)
    {
        $auspiciante = $this->_auspiciante->findOrFail($id);

        return view('auspiciantes.show', compact('auspiciante'));
    }

    public function edit($id)
    {
        $auspiciante = $this->_auspiciante->findOrFail($id);

        return view('auspiciantes.edit', compact('auspiciante')); 
    }

    public function update(AuspicianteRequest $request, $id)
    {
        $data = $request->all();
        $auspiciante = $this->_auspiciante->findOrFail($id);

        if ( $request->file('aus_imagen') ) 
            $data['aus_imagen'] = $auspiciante->reemplazarImagen($request->file('aus_imagen'));

        $auspiciante->update($data);
        Flash::success('Auspiciante actualizado exitosamente');

        return redirect('auspiciantes');
    }

    public function destroy($id)
    {
        $auspiciante = $this->_auspiciante->findOrFail($id);

        if ($auspiciante->getPicturePath() !== null)
            $auspiciante->borrarImagen();

        if ($auspiciante->delete())
            Flash::warning('Auspiciante borrado exitosamente');

        return redirect('auspiciantes'); 
    }
}
