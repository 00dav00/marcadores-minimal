<?php 

namespace App\Libraries;

use Illuminate\Http\Request;
 
trait SearchTrait 
{

	protected $_pagination = NULL;

	/**
	 * Devuelve las columnas de busqueda del modelo
	 * 
	 * @return array 
	 */
	public function getSearchFieldsAttribute()
  	{
  		return $this->searchFields;	
  	}
	
	/**
	 * Verifica si se desea dividir la busqueda en varias partes (paginar)
	 * 
	 * @return mixed devuelve el valor de paginacion
	 */
	public function checkIfPaginationExists($query) {

		if ($this->_pagination) {
			return $query->paginate($this->_pagination);
		} else {
			return $query->paginate(env('PAGINATION_NUMBER'));
		} 

	}

	/**
	 * Verificar si existen relaciones entre modelos
	 * 
	 * @return mixed devuelve el string con las relaciones
	 */
	public function checkIfRelationsExists($query, $joins = NULL) 
	{
		
		if (count($joins) > 0 && is_array($joins)) {
			return $query->with($joins);				
		} else {
			return false;
		}

	}

	/**
	 * Verificar si se ha definido el parámetro que se quiere buscar
	 * 
	 * @param  string $column Parámetro que se desea buscar
	 * @return bool         
	 */
	public function checkIfSearchExists($keyword = NULL, $column = NULL, $query) 
	{

		$arg1 = 'LIKE';
		$arg2 = '%' . $keyword . '%';

		// Si existe la columna se devuelve verdadero
		if (!empty($keyword) && !empty($column)) {
			return $query->where($column, $arg1, $arg2);
		} else {
			return false;
		}
	}

	/**
	 * Establecer el numero de elementos a consultar
	 * 
	 * @param int $value Valor a establecer de paginacion
	 */
	public function setPagination($value)
	{
		return $this->_pagination = $value;
	}

	/**
	 * Metodo para realizar busquedas
	 * 
	 * @param  string $keyword palabra que se desea buscar
	 * @param  string $column  columna que se desea buscar
	 * @return mixed          resultado de la busqueda
	 */
	public function search($keyword = '', $column = '', $joins = NULL)
	{

		// Borrar los mensajes de la sesión anterior
		\Session::forget('flash_notification.message');

		$keyword = trim($keyword);
		$column = trim($column);

		// Iniciar el objeto que realizara las consultas
		$query = $this->query();

		// Identificar si se va a filtrar
		$this->checkIfSearchExists($keyword, $column, $query);
			
		// Verificar si existen relaciones con otros modelos
		$this->checkIfRelationsExists($query, $joins);

		// Realizar la consulta, se verificara si se va paginar
		return $this->checkIfPaginationExists($query);
	}
}