<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\PersonalizacionValor;
use App\Http\Requests\PersonalizacionValorRequest;

use DB;

class ApiPersonalizacionValoresController extends Controller
{
    /**
     * Objeto con el modelo a consultar
     * @var object
     */
    protected $_valor;

    /**
     * Constructor de la clase
     * @param valor $valor
     */
    public function __construct(PersonalizacionValor $valor)
    {
        $this->_valor = $valor;
    }

    /**
     * Obtener los campos a personalizar y sus valores
     * @return json 
     */
    public function getCampos()
    {
        return $this->_valor->getCampos();
    }

    public function savePersonalizacionValores(Request $request)
    {
        $arrRequest = $request->all();

        $cliente = $arrRequest['cliente'];

        $campos = $arrRequest['campos'];

        $valores = [];
        foreach ($campos as $campo) {
            $valores[] = [
                'pca_id' => $campo['id'], 
                'clt_id' => $cliente['clt_id'], 
                'pva_valor' => $campo['valor_default']
                ];
        }

        // borrar los datos asociados a un cliente
        DB::table('personalizacion_valores')
            ->where('clt_id', $cliente['clt_id'])
            ->delete();

        // insertar los valores de personalizacion
        DB::table('personalizacion_valores')->insert($valores);

        return response()->json($valores);
    }
}
