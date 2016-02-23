<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterPartidoJugadoresEqpIdNotNull extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement(
            'UPDATE partido_jugadores
            INNER JOIN (   
                select pju_id, pl.eqp_id
                from partido_jugadores pj
                    join partidos p on p.par_id = pj.par_id
                    join fechas fe on p.fec_id = fe.fec_id
                    join fases f on fe.fas_id = f.fas_id
                    join plantillas_torneo pl on f.tor_id = pl.tor_id and pj.jug_id = pl.jug_id
            ) query ON query.pju_id = partido_jugadores.pju_id

            SET partido_jugadores.eqp_id = query.eqp_id;'
        );

        Schema::table('partido_jugadores', function(Blueprint $table) {
            $table->integer('eqp_id')->unsigned()->change();
            $table->foreign('eqp_id')->references('eqp_id')->on('equipos');
        });
    }

    public function down() {
        Schema::table('partido_jugadores', function (Blueprint $table) {
            $table->dropForeign('partido_jugadores_eqp_id_foreign');
            $table->integer('eqp_id')->unsigned()->nullable()->change();;
        });
    }
}
