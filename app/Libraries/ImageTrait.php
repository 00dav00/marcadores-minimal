<?php 

namespace App\Libraries;

// use Illuminate\Http\Request;
use Image;
use File;

trait ImageTrait 
{
	/**
	 * Tamaño por defecto para las imagenes
	 * @var array
	 */
	protected $_imageSize = [ 'width' => 300, 'height' => 200 ];
	
	/**
	 * Establecer el tamaño de una imagen
	 * @param integer $width  ancho
	 * @param integer $height largo
	 */
	protected function _setImageSize($width, $height)
	{
		if ($width > 0 && $height > 0 && is_integer($width) && is_integer($height)) {
			$this->_imageSize = [ 'width' => $width, 'height' => $height ];
		}
	}


	/**
	 * Llama al método adecuado (modelo o controlador) para guardar una imagen y devuelve el path hacia ella
	 * @param  	object $image Imagen obtenida desde el formulario
	 * 			string $directorio directorio en el que se desea guardar la imagen
	 * @return string          nombre del archivo con la fotografia
	 */
	public function procesarImagen() {
 		$params = func_get_args();
 		// syslog(LOG_ALERT, var_dump($params));
	    if(count($params) == 1) {
	    	return $this->procesarImagenModelo($params[0]);
	    } elseif(count($params) == 2) {
	      	return $this->procesarImagenControlador($params[0], $params[1]);
	    } else {
	      	return false;
	    }
  	}

  	public function reemplazarImagen($imagen)
  	{
  		$this->borrarImagen();

  		return $this->procesarImagen($imagen);
  	}

	public function borrarImagen()
	{
  		if ( File::exists($this->getPicturePath()) )
  			File::delete( $this->getPicturePath());
  	}  	

	protected function procesarImagenControlador($image, $directorio)
	{
		$filename = date('Y-m-d-H:i:s'). "-" .$image->getClientOriginalName();
		$path = public_path($directorio . $filename);
		Image::make($image->getRealPath())->resize($this->_imageSize['width'], $this->_imageSize['height'])->save($path);
		return $directorio . $filename;
	}

	protected function procesarImagenModelo($imagen)
	{
		$filename = date('Y-m-d-H:i:s') . "-" . $imagen->getClientOriginalName();
		$pathCompleto = $this->imagePath . $filename;
		Image::make( $imagen->getRealPath() )
				->resize( $this->_imageSize['width'], $this->_imageSize['height'] )
				->save( public_path($pathCompleto) );

		return $pathCompleto;
	}



}