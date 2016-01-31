<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

/**
 * tiene que recibir como argumentos el cliente-id para
 * determinar los valores pesonalizados (colores) y
 * el torneo-id
 * con el torneo-id se trae los datos de los equipos participantes
 * con el torneo-id se determina la fase actual (la ultima fase creada)
 * con la fase actual se determina cual es la fecha a mostrar (la primera opcion
 * es la fecha que está en juego, si no hay una fecha en juego la segunda opcion
 * es la fecha despues de una fecha jugada que puede ser no_jugada o suspendida)
 * tambien se determina la fecha anterior o la fecha siguiente si es que existe
 * con la fecha se traen los partidos, con los resultados de cada uno de ellos, si 
 * no hay goles (null), se debe cambiar la forma como se muestra
 * en el refresco automatico (cada 120seg), se determinará la hora y segun ello
 * dira si el partido está en juego o no
 */

use App\Torneo;
use App\Cliente;
use App\Fase;
use App\Fecha;

use DB;

class ApiTablaResultadosController extends Controller
{

	/**
	 * Objeto que contiene la informacion de un cliente
	 * @var object
	 */
	protected $_cliente;

	/**
	 * Objeto que contiene la informacion de un torneo
	 * @var object
	 */
	protected $torneo;

	/**
	 * Objeto que contiene la informacion de una fase
	 * @var object
	 */
	protected $_fase;

	/**
	 * Objeto que contiene la informacion de una fecha
	 * @var object
	 */
	protected $_fecha;

	/**
	 * Verifica que el id del cliente existe
	 * @param  integer $cliente id del cliente
	 * @return collection
	 */
	protected function verificarClienteId($cliente)
	{
		$sql = "
			SELECT clt_id
			FROM clientes
			WHERE
			clt_id = ?
			LIMIT 1";
		
		$result = DB::select($sql, [$cliente]);

		if (is_array($result) && count($result) > 0) {
			return $result[0]->clt_id;
		} else {
			$this->errorResponse;
		}
	}

	/**
	 * Verifica que el id del torneo existe
	 * @param  integer $tor_i id del torneo
	 * @return collection         
	 */
	protected function verificarTorneoId($torneo)
	{
		$sql = "
			SELECT tor_id
			FROM torneos
			WHERE
			tor_id = ?
			LIMIT 1";
		
		$result = DB::select($sql, [$torneo]);

		if (is_array($result) && count($result) > 0) {
			return $result[0]->tor_id;
		} else {
			$this->errorResponse;
		}
	}

	/**
	 * Obtener la informacion de la ultima fase de un torneo
	 * @param  integer $tor_id id del torneo
	 * @return integer         id de la fase
	 */
	protected function buscarUltimaFaseTorneo($tor_id)
	{
		$sql = "
			SELECT fas_id
			FROM fases
			WHERE
			tor_id = ?
			ORDER BY fas_id DESC
			LIMIT 1";
		
		$result = DB::select($sql, [$tor_id]);

		if (is_array($result) && count($result) > 0) {
			return $result[0]->fas_id;
		} else {
			$this->errorResponse;
		}
	}

	/**
	 * Buscar el id de la fecha a mostrar
	 * @param  integer $fas_id id de la fase
	 * @return integer         id de la fecha
	 */
	protected function buscarUltimaFecha($fas_id)
	{
		// obtener el numero de fechas asociado a una fase
		if ($this->numeroFechasFase($fas_id) > 0) 		{
			// si el numero de fechas es mayor a 0 se obtiene la fecha que
			// se debe mostrar, la prioridad es la fecha en_juego, la segunda
			// prioridad es cualquiera que no este marcada como jugada y por ultimo
			// la ultima fecha jugada
			return $this->buscarFechaAMostrar($fas_id);
		} else {
			$this->errorResponse;
		}
	}

	/**
	 * Obtener el numero de fechas asociados a una fase
	 * @param  integer $fas_id id de la fase
	 * @return integer         numero de fechas
	 */
	protected function numeroFechasFase($fas_id)
	{
		$sql = "
			SELECT COUNT(*) AS total
			FROM fechas
			WHERE fas_id = ?";

		$result = DB::select($sql, [$fas_id]);

		return $result[0]->total;
	}

	/**
	 * Realiza las consultas para encontrar la fecha que se debe mostrar
	 * @param  integer $fas_id id de la fase
	 * @return integer         id de la fecha
	 */
	protected function buscarFechaAMostrar($fas_id)
	{
		$sql = "
			SELECT MIN(fec_id) AS fecha
			FROM fechas
			WHERE fas_id = ?
			AND (fec_estado = ?)";

		$result = DB::select($sql, [$fas_id, 'en_juego']);

		if ($result[0]->fecha) {
			return $result[0]->fecha;
		} else {
			$sql = "
				SELECT MIN(fec_id) AS fecha
				FROM fechas
				WHERE fas_id = ?
				AND (fec_estado != ?)";

			$result = DB::select($sql, [$fas_id, 'jugada']);

			return $result[0]->fecha;
		}
	}

	protected function buscarFechaAnteriorYSiguiente($fas_id, $fec_id)
	{
		// buscar fecha anterior
		$sql = "
			SELECT fec_id
			FROM fechas
			WHERE
			(fas_id = ?)
			AND (fec_id < ?)
			ORDER BY fec_id DESC
			LIMIT 1
		";

		$result = DB::select($sql, [$fas_id, $fec_id]);

		if (is_array($result) && count($result) > 0) {
			$response['anterior'] = $result[0]->fec_id;
		} else {
			$response['anterior'] = NULL;
		}

		// buscar fecha siguiente
		$sql = "
			SELECT fec_id
			FROM fechas
			WHERE
			(fas_id = ?)
			AND (fec_id > ?)
			ORDER BY fec_id ASC
			LIMIT 1
		";

		$result = DB::select($sql, [$fas_id, $fec_id]);

		if (is_array($result) && count($result) > 0) {
			$response['siguiente'] = $result[0]->fec_id;
		} else {
			$response['siguiente'] = NULL;
		}

		return $response;
	}

	/**
	 * Constructor de la clase
	 * @param Cliente $cliente 
	 * @param Torneo  $torneo  
	 * @param Fase    $fase    
	 */
	public function __construct(Cliente $cliente, Torneo $torneo, Fase $fase, Fecha $fecha)
	{
		$this->_cliente = $cliente;
		$this->_torneo 	= $torneo;
		$this->_fase 	= $fase;
		$this->_fecha 	= $fecha;
	}

	/**
	 * Respuesta de error, devuelve HTTP response 404
	 * @return mixed
	 */
	protected function errorResponse()
	{
		abort(404, 'Not found');
	}

	/**
	 * Este metodo se encarga de buscar la ultima fase creada de un torneo
	 * y la fecha que se debe mostrar por defecto de ese torneo
	 * @param  integer $cliente id del cliente
	 * @param  integer $torneo id del torneo
	 */
	public function mostrarUltimaFecha($cliente, $torneo)
	{
		// verificar que el cliente existe
		$clt_id = $this->verificarClienteId($cliente);
		
		// verificar que el torneo existe
		$tor_id = $this->verificarTorneoId($torneo);

		// obtener la ultima fase del torneo
		$fas_id = $this->buscarUltimaFaseTorneo($tor_id);

		// obtener la fecha actual (primera prioridad la fecha en juego,
		// si no hay fecha en juego se obtiene la primera fecha no_finalizada)
		$fec_id = $this->buscarUltimaFecha($fas_id);

		// mostrar informacion
		return $this->mostrarInformacionFecha($clt_id, $tor_id, $fas_id, $fec_id);
	}

	public function mostrarInformacionFecha($clt_id, $tor_id, $fas_id, $fec_id)
	{
		// buscar informacion del cliente
		$cliente = $this->_cliente->with('personalizacion')->findOrFail($clt_id);

		// buscar informacion del torneo
		$torneo = $this->_torneo->with('equiposParticipantes')->findOrFail($tor_id);

		// buscar informacion de la fase
		$fase = $this->_fase->findOrFail($fas_id);

		// buscar informacion de la fecha
		$fecha = $this->_fecha->with('partidos.estadio')->findOrFail($fec_id);

		// buscar la fecha anterior y fecha siguiente
		$proximasFechas = $this->buscarFechaAnteriorYSiguiente($fas_id, $fec_id);

		return response()->json([
			'cliente' 	=> $cliente,
			'torneo' 	=> $torneo,
			'fase' 		=> $fase,
			'fecha'		=> $fecha,
			'proximas'	=> $proximasFechas,
			]);
	}
}
