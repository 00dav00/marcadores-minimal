<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Flash;

use App\Jugador;
use App\Http\Requests\JugadorRequest;

use Log;


class JugadoresController extends Controller
{
    protected $jugador;

    public function __construct(Jugador $jugador)
    {
        $this->jugador = $jugador;
    }

    public function index(Request $request)
    {
        $keyword = $request->get('keyword');
        $column = $request->get('column');
        
        $jugadores = $this->jugador->search($keyword, $column);
        $searchFields = $this->jugador->getSearchFields();

        if (!empty($keyword)) 
            Flash::info("Resultados de la búsqueda: $keyword");

        return view('jugadores.index',compact('jugadores','searchFields','keyword','column'));
    }

    public function create()
    {
        return view('jugadores.create');
    }

    public function store(JugadorRequest $request)
    {
        $data = $request->all();

        if ($request->file('jug_foto'))
            $data['jug_foto'] = $this->jugador->procesarImagen($request->file('jug_foto'));

        $this->jugador->create($data);
        Flash::success('Jugador creado exitosamente');

        return redirect('jugadores');
        // return view('jugadores.index');
    }

    public function show($id)
    {
        $jugador = $this->jugador->findOrFail($id);

        return view('jugadores.show', compact('jugador'));
    }

    public function edit($id)
    {
        $jugador = $this->jugador->with('nacionalidad')->findOrFail($id);
        // Log::info($jugador);

        return view('jugadores.edit', compact('jugador'));    
    }

    public function update(JugadorRequest $request, $id)
    {
        $data = $request->all();
        $jugador = $this->jugador->findOrFail($id);

        if ( $request->file('jug_foto') ) 
            $data['jug_foto'] = $jugador->reemplazarImagen($request->file('jug_foto'));

        $jugador->update($data);
        Flash::success('Jugador actualizado exitosamente');

        return redirect('jugadores');
    }

    public function destroy($id)
    {
        $jugador = $this->jugador->findOrFail($id);

        if ( $jugador->getPicturePath() !== null )
            $jugador->borrarImagen();

        if ($jugador->delete())
            Flash::warning('Jugador borrado exitosamente');

        return redirect('jugadores');   
    }    
}
