<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\PersonalizacionCampo;

class PersonalizacionCamposSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

		if (!count(PersonalizacionCampo::all())) {

			PersonalizacionCampo::create([
				'pca_nombre' => 'color_header',
				'pca_descripcion' => 'Color de header del panel'
			]);

			PersonalizacionCampo::create([
				'pca_nombre' => 'color_texto_titulo',
				'pca_descripcion' => 'Color del texto del titulo'
			]);

			PersonalizacionCampo::create([
				'pca_nombre' => 'color_fondo',
				'pca_descripcion' => 'Color de fondo'
			]);

			PersonalizacionCampo::create([
				'pca_nombre' => 'color_texto_body',
				'pca_descripcion' => 'Color del texto'
			]);

			PersonalizacionCampo::create([
				'pca_nombre' => 'color_boton',
				'pca_descripcion' => 'Color de los botones'
			]);

			PersonalizacionCampo::create([
				'pca_nombre' => 'color_texto_boton',
				'pca_descripcion' => 'Color de texto de los botones'
			]);

			PersonalizacionCampo::create([
				'pca_nombre' => 'resaltar_posiciones_tabla',
				'pca_descripcion' => 'Color para resaltar posiciones'
			]);
		}

		Model::reguard();
    }
}
