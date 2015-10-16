<?php 

namespace App\Libraries;

trait MetaDataTrait
{

	/**
	 * Obtener el path para imagenes de la clase
	 * @return string
	 * */
	public static function getImagePath()
	{	
		$instance = new static;
		return $instance->imagePath;
	}

	public static function getPKColumn()
	{
		$instance = new static;
		return $instance->primaryKey;
	}	
	
	public static function getNameColumn()
	{
		$instance = new static;
		return $instance->nameColumn;
	}

	public function getTableAttribute()
  	{
   		return $this->table;
  	}

}