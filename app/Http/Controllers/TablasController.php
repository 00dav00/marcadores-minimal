<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class TablasController extends Controller {

	public function index() {
		return view ('tablas.index');
	}

	public function show($cliente, $torneo) {
		return view('tablas.show', ['cliente' => $cliente, 'torneo' => $torneo]);
	}

	public function goleadores($cliente, $torneo) {
		return view('tablas.goleadores', ['cliente' => $cliente, 'torneo' => $torneo]);
	}

	public function listado() {
		return view('tablas.list');
	}

	public function preview($torneo_id) {
		return view('tablas.preview', compact('torneo_id'));
	}

	// personalizado
	// cancheros
	public function cancherosShow($torneo) {
		return $this->show(1, $torneo);
		// return view('tablas.cancherosShow', ['cliente' => 1, 'torneo' => $torneo]);
	}

}
