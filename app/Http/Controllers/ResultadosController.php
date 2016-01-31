<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ResultadosController extends Controller
{
	/**
	 * Muestra la informacion de la siguiente fecha de un torneo
	 *  
	 * @param  integer $cliente id del cliente
	 * @param  integer $torneo  id del torneo
	 * @return mixed          
	 */
    public function tablaShow($cliente, $torneo)
	{
		return view('tablas.show', ['cliente' => $cliente, 'torneo' => $torneo]);
	}
}
