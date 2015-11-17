<?php

use Illuminate\Database\Seeder;

use Illuminate\Database\Eloquent\Model;
use App\Producto;

class ProductosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

		if (!count(Producto::all())) {

			Producto::create([
				'prd_nombre' => 'tabla_posiciones',
				'prd_descripcion' => 'Tabla de posiciones de un torneo'
			]);

			Producto::create([
				'prd_nombre' => 'tabla_resultados',
				'prd_descripcion' => 'Tabla de resultados de una fecha de un torneo'
			]);

			Producto::create([
				'prd_nombre' => 'widget_resultados',
				'prd_descripcion' => 'Widget de resultados de una fecha de un torneo'
			]);

			Producto::create([
				'prd_nombre' => 'tabla_goleadores',
				'prd_descripcion' => 'Tabla con los goleadores de un torneo'
			]);

		}

		Model::reguard();
    }
}
