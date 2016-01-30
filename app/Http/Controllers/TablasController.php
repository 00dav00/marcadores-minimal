<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
// use Illuminate\Http\Response;

use DB;
use App\Quotation;

class TablasController extends Controller {

	public function index()
	{
		return view ('tablas.index');
	}

	public function create()
	{

	}

	public function store()
	{
	}

	public function show($cliente, $torneo)
	{
		return view('tablas.show', ['cliente' => $cliente, 'torneo' => $torneo]);
	}

	public function edit($id)
	{
	}

	public function update($id)
	{
	}

	public function destroy($id)
	{
	}

	public function listado()
	{
		return view('tablas.list');
	}

	public function preview($torneo_id)
	{
		return view('tablas.preview', compact('torneo_id'));
	}

}
