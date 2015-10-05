<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Jugador;
use Laracasts\Flash\Flash;

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

        if (!empty($keyword)) {
            Flash::info("Resultados de la búsqueda: $keyword");
            // flash()->info("Resultados de la búsqueda: $keyword");
        }

        return view('jugadores.index',compact('jugadores','searchFields','keyword','column'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
