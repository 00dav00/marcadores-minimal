<?php 

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\TipoEvento;

class TipoEventoTableSeeder extends Seeder {

	public function run()
	{
		Model::unguard();

		if (!count(TipoEvento::all())){
			TipoEvento::create([
				'tev_nombre' => 'inicio partido',
				'tev_descripcion' => 'Inicio del partido',
				'tev_comentario1' => 'Ha iniciado el partido',
				'tev_comentario2' => 'El encuentro ha comenzado',
			]);
			TipoEvento::create([
				'tev_nombre' => 'fin primer tiempo',
				'tev_descripcion' => 'Fin del primer tiempo',
				'tev_comentario1' => 'El arbitro señala la finalización del primer tiempo',
				'tev_comentario2' => 'El primer tiempo ha finalizado',
			]);
			TipoEvento::create([
				'tev_nombre' => 'inicio segundo tiempo',
				'tev_descripcion' => 'Comienzo del segundo tiempo',
				'tev_comentario1' => 'El segundo tiempo se ha puesto en marcha',
				'tev_comentario2' => 'Ha comenzado el segundo tiempo',
			]);
			TipoEvento::create([
				'tev_nombre' => 'fin partido',
				'tev_descripcion' => 'Finalización del partido',
				'tev_comentario1' => 'El encuentro ha concluido',
				'tev_comentario2' => 'Final del partido',
			]);
			TipoEvento::create([
				'tev_nombre' => 'gol',
				'tev_descripcion' => 'Gol',
				'tev_comentario1' => 'anota un gol',
				'tev_comentario2' => 'convierte un gol',
			]);
			TipoEvento::create([
				'tev_nombre' => 'falta',
				'tev_descripcion' => 'Falta',
				'tev_comentario1' => 'le realiza un falta a',
				'tev_comentario2' => 'comete una falta sobre',
			]);
			TipoEvento::create([
				'tev_nombre' => 'tiro libre',
				'tev_descripcion' => 'Tiro libre',
				'tev_comentario1' => 'Tiro libre para',
				'tev_comentario2' => 'Se decreta un tiro libre para',
			]);
			TipoEvento::create([
				'tev_nombre' => 'penal',
				'tev_descripcion' => 'penal',
				'tev_comentario1' => 'Tiro penal a favor de',
				'tev_comentario2' => 'Se decreta la pena máxima a favor de',
			]);
			TipoEvento::create([
				'tev_nombre' => 'tiro de esquina',
				'tev_descripcion' => 'tiro de esquina',
				'tev_comentario1' => 'Tiro de esquina para',
				'tev_comentario2' => 'Lanzamiento de esquina para',
			]);
			TipoEvento::create([
				'tev_nombre' => 'amarilla',
				'tev_descripcion' => 'tarjeta amarilla',
				'tev_comentario1' => 'es amonestado con cartulina amarilla',
				'tev_comentario2' => 'recibe tarjeta amarilla',
			]);
			TipoEvento::create([
				'tev_nombre' => 'doble amarilla',
				'tev_descripcion' => 'doble tarjeta amarilla',
				'tev_comentario1' => 'recibe su segunda cartulina amarilla y debe abandonar el partido',
				'tev_comentario2' => 'es expulsado por doble cartulina amarilla',
			]);
			TipoEvento::create([
				'tev_nombre' => 'roja',
				'tev_descripcion' => 'tarjeta roja',
				'tev_comentario1' => 'es expulsado del encuentro con roja directa',
				'tev_comentario2' => 'recibe la tarjeta roja y debe abandonar el encuentro',
			]);
			TipoEvento::create([
				'tev_nombre' => 'lateral',
				'tev_descripcion' => 'saque lateral',
				'tev_comentario1' => 'Saque lateral a favor de',
				'tev_comentario2' => 'Saque de banda para',
			]);
			TipoEvento::create([
				'tev_nombre' => 'puerta',
				'tev_descripcion' => 'saque de puerta',
				'tev_comentario1' => 'Saque de meta para',
				'tev_comentario2' => 'Saque de puerta para',
			]);
			TipoEvento::create([
				'tev_nombre' => 'lesion',
				'tev_descripcion' => 'lesion',
				'tev_comentario1' => 'sufrió una lesión',
				'tev_comentario2' => 'se encuentra lesionado',
			]);
			TipoEvento::create([
				'tev_nombre' => 'disparo',
				'tev_descripcion' => 'Disparo',
				'tev_comentario1' => 'realiza un remate a puerta',
				'tev_comentario2' => 'saca un disparo',
			]);
			TipoEvento::create([
				'tev_nombre' => 'palo',
				'tev_descripcion' => 'palo',
				'tev_comentario1' => 'remata y el balon se estrella en el palo',
				'tev_comentario2' => 'dispara y el palo impide la anotación',
			]);
			TipoEvento::create([
				'tev_nombre' => 'autogol',
				'tev_descripcion' => 'gol en propia puerta',
				'tev_comentario1' => 'convierte un desafortunado autogol',
				'tev_comentario2' => 'convierte un gol en su propia puerta',
			]);
			TipoEvento::create([
				'tev_nombre' => 'offside',
				'tev_descripcion' => 'fuera de fuego',
				'tev_comentario1' => 'cae en fuera de juego',
				'tev_comentario2' => 'es encontrado en offside',
			]);
			TipoEvento::create([
				'tev_nombre' => 'contra ataque',
				'tev_descripcion' => 'contra ataque',
				'tev_comentario1' => 'realiza un contra ataque',
				'tev_comentario2' => 'genera un contra ataque',
			]);
			TipoEvento::create([
				'tev_nombre' => 'cambio',
				'tev_descripcion' => 'cambio de jugador',
				'tev_comentario1' => 'es sustituido por',
				'tev_comentario2' => 'deja el campo por',
			]);
			TipoEvento::create([
				'tev_nombre' => 'adicion',
				'tev_descripcion' => 'tiempo extra',
				'tev_comentario1' => 'Se ha adicionado',
				'tev_comentario2' => 'Se agrega al partido',
			]);
			TipoEvento::create([
				'tev_nombre' => 'finta',
				'tev_descripcion' => 'jugada vistosa',
				'tev_comentario1' => 'dribla vistosamente a',
				'tev_comentario2' => 'elude vistosamente a',
			]);
			TipoEvento::create([
				'tev_nombre' => 'atajada',
				'tev_descripcion' => 'Detener un disparo',
				'tev_comentario1' => 'detiene un gran remate a',
				'tev_comentario2' => 'realiza una estupenda atajada tras remate de',
			]);
			TipoEvento::create([
				'tev_nombre' => 'ole',
				'tev_descripcion' => 'el publico grita ole desde las gradas',
				'tev_comentario1' => 'Los fanáticos corean el OLE por el gran juego de',
				'tev_comentario2' => 'Los fanáticos corean el OLE por el gran juego de',
			]);
			TipoEvento::create([
				'tev_nombre' => 'mano',
				'tev_descripcion' => 'el balon es jugado con la mano',
				'tev_comentario1' => 'juega el balón con la mano',
				'tev_comentario2' => 'utiliza la mano para jugar el balón',
			]);
			TipoEvento::create([
				'tev_nombre' => 'suspecion',
				'tev_descripcion' => 'el partido se suspende',
				'tev_comentario1' => 'El partido es suspendido',
				'tev_comentario2' => 'El juez suspende el encuentro',
			]);
			TipoEvento::create([
				'tev_nombre' => 'pelea',
				'tev_descripcion' => 'pelea de un jugador en particular',
				'tev_comentario1' => 'se ve involucrado en una pelea',
				'tev_comentario2' => 'inicia una riña',
			]);
			TipoEvento::create([
				'tev_nombre' => 'pelea general',
				'tev_descripcion' => 'pelea entre jugadores',
				'tev_comentario1' => 'Se enciende un lamentable pelea en el campo',
				'tev_comentario2' => 'Se enciende un lamentable pelea en el campo',
			]);




		}
	}
}