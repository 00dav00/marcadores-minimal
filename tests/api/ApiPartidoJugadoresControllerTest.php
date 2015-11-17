<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;


class ApiPartidoJugadoresControllerTest extends TestCase
{	
    use WithoutMiddleware;

    public function setUp()
    {
    	parent::createApplication();
        Artisan::call('migrate:refresh');
    }

    public function test_Ingreso_Jugador_Titular_crea_registro_y_devuelve_objeto()
    {
    	$partido = factory(App\Partido::class)->create();
        $jugador = factory(App\Jugador::class)->create();
        $partidoJugador = [
            'par_id' => $partido->par_id,
            'jug_id' => $jugador->jug_id,
            'pju_numero_camiseta' => 10,
            'pju_juvenil' => false,
        ];

        $response = $this->call('POST', 'api/partidoJugadores/titulares', $partidoJugador);

        $this->assertJson($response->getContent(),'Se esperaba JSON');
        $this->seeInDatabase('partido_jugadores', ['pju_id' => json_decode($response->getContent())->pju_id]);
    }

    public function test_Ingreso_Jugador_Titular_deveulve_400_al_tratar_de_ingresar_duplicado()
    {
        $partidoJugador1 = factory(App\PartidoJugador::class)->create();
        $partidoJugador2 = [
            'par_id' => $partidoJugador1->par_id,
            'jug_id' => $partidoJugador1->jug_id,
            'pju_numero_camiseta' => 10,
            'pju_juvenil' => false,
        ];

        $response = $this->call('POST', 'api/partidoJugadores/titulares', $partidoJugador2);

        $this->assertResponseStatus(400);
    }

    public function test_Ingreso_Jugador_Cambio_crea_registro_actualiza_anterior_y_devuelve_objeto()
    {
    	$jugador = factory(App\Jugador::class)->create();
        $minuto = 50;
        $partidoJugador1 = factory(App\PartidoJugador::class)->create();
        $partidoJugador2 = [
            'par_id' => $partidoJugador1->par_id,
            'jug_id' => $jugador->jug_id,
            'pju_minuto_ingreso' => $minuto,
            'pju_reemplazo_de' => $partidoJugador1->pju_id,
            'pju_numero_camiseta' => 10,
            'pju_juvenil' => false,
        ];

        $response = $this->call('POST', 'api/partidoJugadores/cambio', $partidoJugador2);

        $this->assertJson($response->getContent(),'Se esperaba JSON');
        $this->seeInDatabase('partido_jugadores', [
            'pju_id' => json_decode($response->getContent())->pju_id,
            'pju_minuto_ingreso' => json_decode($response->getContent())->pju_minuto_ingreso
        ]);
        $this->seeInDatabase('partido_jugadores', [
            'pju_id' => $partidoJugador1->pju_id, 
            'pju_minuto_salida' => $minuto
        ]);
    }

    public function test_Destroy_devuelve_200_cuando_es_exitoso()
    {
        $partidoJugador = factory(App\PartidoJugador::class)->create();

        $response = $this->call('DELETE', 'api/partidoJugadores/'. $partidoJugador->pju_id);

        $this->assertResponseOk();
        $this->assertEquals(null,$response->getContent());
        $this->notSeeInDatabase('partido_jugadores', ['pju_id' =>  $partidoJugador->pju_id]);
    }

    public function test_Destroy_devuelve_404_cuando_no_existe_registro()
    {
        $response = $this->call('DELETE', 'api/partidoJugadores/1');
        $this->assertResponseStatus(404);
    }
}