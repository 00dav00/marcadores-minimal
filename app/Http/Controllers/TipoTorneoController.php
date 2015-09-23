<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\TipoTorneo;

use App\Http\Requests\TipoTorneoRequest;

class TipoTorneoController extends Controller {

	public function index()
	{
		$tipo_torneo = TipoTorneo::orderBy('ttr_nombre')
							->paginate(20);

		return view ('tipo_torneo.index', compact('tipo_torneo'));
	}


	public function create()
	{
		return view('tipo_torneo.create');
	}


	public function store(TipoTorneoRequest $request)
	{
		TipoTorneo::create($request->all());

		flash()->success('Tipo de torneo creado exitosamente');
		
		return redirect('tipo_torneo');
	}


	public function show($id)
	{
		$tipo_torneo = TipoTorneo::findOrFail($id);
		return view('tipo_torneo.show', compact('tipo_torneo'));
	}


	public function edit($id)
	{
		$tipo_torneo = TipoTorneo::findOrFail($id);
		return view('tipo_torneo.edit', compact('tipo_torneo'));
	}


	public function update($id, TipoTorneoRequest $request)
	{
		// openlog('myapplication', LOG_NDELAY, LOG_USER);
 	// 	syslog(LOG_NOTICE, "Something has happened");
		$tipo_torneo = TipoTorneo::findOrFail($id);
		$tipo_torneo->update($request->all());
		flash()->success('Tipo de torneo actualizado correctamente');

		return redirect('tipo_torneo');
	}


	public function destroy($id)
	{
		$tipo_torneo = TipoTorneo::findOrFail($id);

		if ($tipo_torneo) {
			$tipo_torneo->delete();
			flash()->warning('Tipo de torneo borrado correctamente');

			return redirect('tipo_torneo');
		}

		return redirect('tipo_torneo')->with('message', 'Tipo de torneo no encontrado');
	}

}
