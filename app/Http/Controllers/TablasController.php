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

	public function show($id)
	{
		return view('tablas.show', compact('id'));
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
