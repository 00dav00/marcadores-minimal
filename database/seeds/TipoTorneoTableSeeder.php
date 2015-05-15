<?php 

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\TipoTorneo;

class TipoTorneoTableSeeder extends Seeder {

	public function run()
	{
		Model::unguard();

		// TipoTorneo::truncate();
		if (!count(TipoTorneo::all())){

			TipoTorneo::create([
				'ttr_nombre' => 'Campeonato Nacional',
				'ttr_descripcion' => 'Campeonato principal dentro de un país.',
			]);

			TipoTorneo::create([
				'ttr_nombre' => 'Copa Nacional',
				'ttr_descripcion' => 'Copa alterna dentro de un país.',
			]);

			TipoTorneo::create([
				'ttr_nombre' => 'Copa continental de clubes',
				'ttr_descripcion' => 'Torneo a nivel continental de equipos profesionales',
			]);

			TipoTorneo::create([
				'ttr_nombre' => 'Copa continental de selecciones',
				'ttr_descripcion' => 'Torneo a nivel continental de selecciones nacionales',
			]);

			TipoTorneo::create([
				'ttr_nombre' => 'Copa mundial de clubes',
				'ttr_descripcion' => 'Torneo a nivel mundial de equipos profesionales',
			]);

			TipoTorneo::create([
				'ttr_nombre' => 'Copa mundial de selecciones',
				'ttr_descripcion' => 'Torneo a nivel mundial de selecciones nacionales',
			]);

		}

	}

}