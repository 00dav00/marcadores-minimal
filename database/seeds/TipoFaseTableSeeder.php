<?php 

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\TipoFase;

class TipoFaseTableSeeder extends Seeder {

	public function run()
	{
		Model::unguard();

		if (!count(TipoFase::all())){

			TipoFase::create([
				'tfa_nombre' => 'Primera Etapa',
				'tfa_descripcion' => 'Primera etapa de un torneo',
			]);

			TipoFase::create([
				'tfa_nombre' => 'Segunda Etapa',
				'tfa_descripcion' => 'Segunda etapa de un torneo',
			]);

			TipoFase::create([
				'tfa_nombre' => 'Tercera Etapa',
				'tfa_descripcion' => 'Tercera Etapa de un Torneo',
			]);

			TipoFase::create([
				'tfa_nombre' => 'Cuarta Etapa',
				'tfa_descripcion' => 'Cuarta Etapa de un torneo',
			]);

			TipoFase::create([
				'tfa_nombre' => 'Clasificación',
				'tfa_descripcion' => 'Etapa previa a ingresar a un tornéo',
			]);

			TipoFase::create([
				'tfa_nombre' => 'Eliminación directa',
				'tfa_descripcion' => 'Duelo directo entre 2 equipos donde el ganador clasifica a la siguiente ronda.',
			]);

			TipoFase::create([
				'tfa_nombre' => 'Fase de grupos',
				'tfa_descripcion' => 'Instacia del torneo donde los equipos juegan todos contra todos, para obtener la clasificación por suma de puntos.',
			]);

			TipoFase::create([
				'tfa_nombre' => 'Octavos de final',
				'tfa_descripcion' => 'Ronda con 16 equipos que juegan en modo de eliminación directa.',
			]);

			TipoFase::create([
				'tfa_nombre' => 'Octavos de final',
				'tfa_descripcion' => 'Ronda con 16 equipos que juegan en modo de eliminación directa.',
			]);

			TipoFase::create([
				'tfa_nombre' => 'Cuartos de final',
				'tfa_descripcion' => 'Ronda con 8 equipos que juegan en modo de eliminación directa.',
			]);

			TipoFase::create([
				'tfa_nombre' => 'Semifinal',
				'tfa_descripcion' => 'Ronda con 4 equipos que juegan en modo de eliminación directa.',
			]);

			TipoFase::create([
				'tfa_nombre' => 'Final',
				'tfa_descripcion' => 'Partido donde se decide el campéon de un torneo.',
			]);

		}


	}
}