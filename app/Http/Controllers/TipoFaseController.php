<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\TipoFase;

use App\Http\Requests\TipoFaseRequest;

class TipoFaseController extends Controller {

	public function index()
	{
		$tipo_fase = TipoFase::orderBy('tfa_nombre')
							->paginate(20);

		return view ('tipo_fase.index', compact('tipo_fase'));
	}

	public function create()
	{
		return view('tipo_fase.create');
	}

	public function store(TipoFaseRequest $request)
	{
		TipoFase::create($request->all());

		flash()->success('Tipo de fase creada exitosamente');
		
		return redirect('tipo_fase');
	}

	public function show($id)
	{
		$tipo_fase = TipoFase::findOrFail($id);

		return view('tipo_fase.show', compact('tipo_fase'));
	}

	public function edit($id)
	{
		$tipo_fase = TipoFase::findOrFail($id);

		return view('tipo_fase.edit', compact('tipo_fase'));
	}

	public function update($id, TipoFaseRequest $request)
	{
		$tipo_fase = TipoFase::findOrFail($id);

		$tipo_fase->update($request->all());

		flash()->success('Tipo de fase actualizada correctamente');

		return redirect('tipo_fase');
	}

	public function destroy($id)
	{
		$tipo_fase = TipoFase::findOrFail($id);

		if ($tipo_fase) {
			$tipo_fase->delete();

			flash()->warning('Tipo de fase borrada correctamente');

			return redirect('tipo_fase');
		}

		flash()->warning('Tipo de tipo_fase no encontrado');

		return redirect('tipo_fase');
	}

}
