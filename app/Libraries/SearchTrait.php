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
	protected function checkIfPaginationExists() {

		// Si se ha definido un valor para paginacion, se toma ese
		// valor del array definido en el modelo
		if (array_key_exists('pagination', $this->searchArray)){	
			return $this->searchArray['pagination'];	
		} else {	
			return false;	
		}
	}

	/**
	 * Verificar si existen relaciones entre modelos
	 * 
	 * @return mixed devuelve el string con las relaciones
	 */
	protected function checkIfRelationsExists() {

		// Se chequea si se ha detallado la relacion con otros modelos
		// para realizar "eagle-loading" en la búsqueda
		// Si no existe se devuelve falso.
		if (array_key_exists('joins', $this->searchArray)) {			
			return implode(', ', $this->searchArray['joins']);
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
	protected function checkIfSearchExists($column) {

		// Si existe la columna se devuelve verdadero
		// si no existe, se devuelve falso
		if (array_key_exists($column, $this->searchArray['columns'])) {
			return true;
		} else {
			return false;
		}
	}

	public static function search($keyword = '', $column = '')
	{

		// Borrar los mensajes de la sesión
		\Session::forget('flash_notification.message');

		$instance = new static;

		// Eliminar espacios de la palabra que se desea buscar
		$keyword = trim($keyword);

		// Eliminar los espacios de la columna que se desea buscar
		$column = trim($column);

		// Verificar si existen relaciones con otros modelos
		$relations = $instance->checkIfRelationsExists();

		// Verificar si se va a paginar
		$pagination = $instance->checkIfPaginationExists();

		// Construir las consultas
		if (empty($keyword)) {

			if ($relations) {
				if ($pagination) {
					return static::with((string)$relations)
							->paginate($pagination);
				} else {
					return static::with($relations)
							->get();
				}
			} else {
				if ($pagination) {
					return static::paginate($pagination);
				} else {
					return static::get();
				}
			}

		} else if ($instance->checkIfSearchExists($column)) {

			if ($relations) {
				if ($pagination) {
					return static::with($relations)
							->where($column, 'LIKE', '%' . $keyword . '%')
							->paginate($pagination);
				} else {
					return static::with($relations)
							->where($column, 'LIKE', '%' . $keyword . '%')
							->get();
				}
			} else {
				if ($pagination) {
					return static::where($column, 'LIKE', '%' . $keyword . '%')
							->paginate($pagination);
				} else {
					return static::where($column, 'LIKE', '%' . $keyword . '%')
							->get();
				}
			}

		} else {

			return false;

		}

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

}