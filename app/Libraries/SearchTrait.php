<?php 

namespace App\Libraries;

use Illuminate\Http\Request;
 
trait SearchTrait 
{

	/**
	 * Verifica si se desea dividir la busqueda en varias partes (paginar)
	 * 
	 * @return mixed devuelve el valor de paginacion
	 */
	protected function checkIfPaginationExists($query) {

		// Si se ha definido un valor para paginacion, se toma ese
		// valor del array definido en el modelo
		if (array_key_exists('pagination', $this->searchArray)){	
			return $query->paginate($this->searchArray['pagination']);	
		} else if(env('PAGINATION_NUMBER')) {
			return $query->paginate(env('PAGINATION_NUMBER'));
		} else {	
			return $query->get();
		}
	}

	/**
	 * Verificar si existen relaciones entre modelos
	 * 
	 * @return mixed devuelve el string con las relaciones
	 */
	protected function checkIfRelationsExists($query) {

		// Se chequea si se ha detallado la relacion con otros modelos
		// para realizar "eagle-loading" en la búsqueda
		if (array_key_exists('joins', $this->searchArray)) {
			foreach ($this->searchArray['joins'] as $join) {
				$query->with($join);				
			}			
		} 
	}

	/**
	 * Verificar si se ha definido el parámetro que se quiere buscar
	 * 
	 * @param  string $column Parámetro que se desea buscar
	 * @return bool         
	 */
	protected function checkIfSearchExists($keyword, $column, $query) {

		// Si existe la columna se devuelve verdadero
		if (array_key_exists($column, $this->searchArray['columns']) && !empty($keyword)) {
			$query->where($column, 'LIKE', '%' . $keyword . '%');
		}
	}

	/**
	 * Metodo para realizar busquedas
	 * 
	 * @param  string $keyword palabra que se desea buscar
	 * @param  string $column  columna que se desea buscar
	 * @return mixed          resultado de la busqueda
	 */
	public static function search($keyword = '', $column = '')
	{

		// Borrar los mensajes de la sesión anterior
		\Session::forget('flash_notification.message');

		$instance = new static;

		// Eliminar espacios de la palabra que se desea buscar
		$keyword = trim($keyword);

		// Eliminar los espacios de la columna que se desea buscar
		$column = trim($column);

		// Iniciar el objeto que realizara las consultas
		$query = $instance->query();

		// Identificar si se va a filtrar
		$instance->checkIfSearchExists($keyword, $column, $query);
			
		// Verificar si existen relaciones con otros modelos
		$instance->checkIfRelationsExists($query);

		// Realizar la consulta, se verificara si se va paginar
		return $instance->checkIfPaginationExists($query);
	}

	/**
	 * Devolver los parámetros de búsqueda
	 * @return array Parámetros de búsqueda
	 */
	public static function getSearchFields() 
	{

		$instance = new static;

		return $instance->searchArray['columns'];

	}

	// public function getSearchFields()
	// {
	// 	return $this->searchArray['columns'];		
	// }

}