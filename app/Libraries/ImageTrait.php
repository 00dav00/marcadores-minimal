<?php 

namespace App\Libraries;

// use Illuminate\Http\Request;
use Image;

trait ImageTrait 
{
	/**
	 * Tamaño por defecto para las imagenes
	 * @var array
	 */
	protected $_imageSize = [
		'width' => 300,
		'height' => 200
		];

	/**
	 * Establecer el tamaño de una imagen
	 * @param integer $width  ancho
	 * @param integer $height largo
	 */
	protected function _setImageSize($width, $height)
	{
		if ($width > 0 && $height > 0 && is_integer($width) && is_integer($height)) {
			$this->_imageSize = [
				'width' => $width,
				'height' => $height
				];
		}
	}

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
		Image::make($image->getRealPath())->resize($this->_imageSize['width'], $this->_imageSize['height'])->save($path);
		return $directorio . $filename;
	}

}