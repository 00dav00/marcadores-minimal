<?php 

namespace App\Libraries;

// use Illuminate\Http\Request;
use Image;

trait ImageTrait 
{

	/**
	 * Obtener guarda una imagen y devuelve el path hacia ella
	 * @param  	object $image Imagen obtenida desde el formulario
	 * 			string $directorio directorio en el que se desea guardar la imagen
	 * @return string          nombre del archivo con la fotografia
	 */
	protected function procesarImagen($image, $directorio)
	{
		$filename = date('Y-m-d-H:i:s'). "-" .$image->getClientOriginalName();
		$path = public_path($directorio . $filename);
		Image::make($image->getRealPath())->resize(300, 200)->save($path);
		return $directorio . $filename;
	}

}