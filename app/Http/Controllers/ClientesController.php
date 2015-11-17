<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Flash;

use App\Cliente;
use App\Http\Requests\ClienteRequest;

use Log;

class ClientesController extends Controller
{

    protected $_cliente;

    public function __construct(Cliente $cliente)
    {
        $this->_cliente = $cliente;
    }

    public function index(Request $request)
    {
        $keyword = $request->get('keyword');
        $column = $request->get('column');

        $clientes = $this->_cliente->search($keyword, $column);
        $searchFields = $this->_cliente->searchFields;

        if (!empty($keyword)) { 
            Flash::info("Resultados de la búsqueda: $keyword");
        }

        return view('clientes.index', compact('clientes', 'searchFields', 'keyword', 'column'));
    }

    public function create()
    {
        return view('clientes.create');
    }

    public function store(ClienteRequest $request)
    {
        $data = $request->all();

        $this->_cliente->create($data);

        Flash::success('Cliente creado exitosamente');

        return redirect('clientes');
    }

    public function show($id)
    {
        $cliente = $this->_cliente->findOrFail($id);

        return view('clientes.show', compact('cliente'));
    }

    public function edit($id)
    {
        $cliente = $this->_cliente->findOrFail($id);

        return view('clientes.edit', compact('cliente')); 
    }

    public function update(ClienteRequest $request, $id)
    {
        $data = $request->all();

        $cliente = $this->_cliente->findOrFail($id);

        $cliente->update($data);

        Flash::success('Cliente actualizado exitosamente');

        return redirect('clientes');
    }

    public function destroy($id)
    {
        $cliente = $this->_cliente->findOrFail($id);

        if ($cliente->delete()) {
            Flash::warning('Cliente borrado exitosamente');
        }

        return redirect('clientes');
    }

    public function wizard()
    {
        return view('clientes.wizard');
    }

    public function wizard()
    {
        return view('clientes.wizard');
    }
}
