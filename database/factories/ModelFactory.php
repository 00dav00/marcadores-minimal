<?php

$factory->define(App\Lugar::class, function ($faker) {
    return [
        'lug_abreviatura' => $faker->cityPrefix,
        'lug_nombre' => $faker->country,
        'lug_tipo' => $faker->randomElement($array = ['continente', 'pais', 'provincia', 'ciudad']),
        'parent_lug_id' => NULL
    ];
});

$factory->define(App\User::class, function ($faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->email,
        'password' => bcrypt('password')
    ];
});

$factory->define(App\Jugador::class, function ($faker) {
    return [
        'jug_apellido' => $faker->lastname,
        'jug_nombre' => $faker->firstNameMale,
        'jug_apodo' => $faker->userName,
        'jug_fecha_nacimiento' => $faker->date($format = 'Y-m-d', $max = 'now'),
        'jug_altura' => $faker->numberBetween($min = 160, $max = 200),
        'jug_sitioweb' => $faker->url,
        'jug_twitter' => $faker->userName,
        'jug_foto' => $faker->imageUrl($width = 200, $height = 200),
        'lug_id' => $factory(App\Lugar::class)->create()->lug_id,
    ];
});

$factory->define(App\Equipo::class, function ($faker) {
    return [
        'eqp_nombre' => $faker->streetName,
        'eqp_escudo' => $faker->imageUrl($width = 320, $height = 280),
        'eqp_twitter' => $faker->userName,
        'eqp_facebook' => $faker->url,
        'eqp_fecha_fundacion' => $faker->date($format = 'Y-m-d', $max = 'now'),
        'eqp_sitioweb' => $faker->url,
        'eqp_tipo' => $faker->randomElement($array = ['seleccion', 'profesional', 'amateur']),
        'lug_id' => $factory(App\Lugar::class)->create()->lug_id,
    ];
});

$factory->define(App\TipoTorneo::class, function ($faker) {
    return [
        'ttr_nombre' => $faker->company,
        'ttr_descripcion' => $faker->sentence(6),
    ];
});

$factory->define(App\Torneo::class, function ($faker) {
    return [
        'tor_nombre' => $faker->company,
        'tor_anio_referencia' => $faker->year($max = 'now'),
        'tor_fecha_inicio' => $faker->date($format = 'Y-m-d', $max = 'now'),
        'tor_fecha_fin' => $faker->date($format = 'Y-m-d', $max = 'now'),
        'tor_tipo_equipos' => $faker->randomElement($array = ['seleccion', 'profesional', 'amateur']),
        'tor_numero_equipos' => $faker->randomElement($array = [2,4,8,12,24,32]),
        'lug_id' => $factory(App\Lugar::class)->create()->lug_id,
        'ttr_id'=> $factory(App\TipoTorneo::class)->create()->ttr_id
    ];
});

$factory->define(App\Estadio::class, function ($faker) {
    return [
        'est_nombre' => $faker->company,
        'est_fecha_inauguracion' => $faker->date($format = 'Y-m-d', $max = 'now'),
        'est_foto_por_defecto' => $faker->imageUrl($width = 200, $height = 200),
        'est_aforo' => $faker->numberBetween($min = 5000, $max = 80000),
        'lug_id' => $factory(App\Lugar::class)->create()->lug_id,
    ];
});
$factory->define(App\TipoTorneo::class, function ($faker) {
    return [
        'ttr_nombre' => $faker->sentence(3),
        'ttr_descripcion' => $faker->sentence(10),
    ];
});

$factory->define(App\Estadio::class, function ($faker) use ($factory){
    return [
        'est_nombre' => $faker->company,
        'est_fecha_inauguracion' => $faker->date($format = 'Y-m-d', $max = 'now'),
        'est_foto_por_defecto' => $faker->imageUrl($width = 200, $height = 200),
        'est_aforo' => $faker->numberBetween($min = 5000, $max = 80000),
        'lug_id' => $factory->create('App\Lugar')->lug_id,
    ];
});

$factory->define(App\Jugador::class, function ($faker) use ($factory){
    return [
        'jug_apellido' => $faker->lastname,
        'jug_nombre' => $faker->firstNameMale,
        'jug_apodo' => $faker->userName,
        'jug_fecha_nacimiento' => $faker->date($format = 'Y-m-d', $max = 'now'),
        'jug_altura' => $faker->numberBetween($min = 160, $max = 200),
        'jug_sitioweb' => $faker->url,
        'jug_twitter' => $faker->userName,
        'jug_foto' => $faker->imageUrl($width = 200, $height = 200),
        'jug_nacionalidad' => $factory->create('App\Lugar')->lug_id,
    ];
});

$factory->define(App\Equipo::class, function ($faker) use ($factory){
    return [
        'eqp_nombre' => $faker->streetName,
        'eqp_escudo' => $faker->imageUrl($width = 320, $height = 280),
        'eqp_twitter' => $faker->userName,
        'eqp_facebook' => $faker->url,
        'eqp_fecha_fundacion' => $faker->date($format = 'Y-m-d', $max = 'now'),
        'eqp_sitioweb' => $faker->url,
        'eqp_tipo' => $faker->randomElement($array = ['seleccion', 'profesional', 'amateur']),
        'lug_id' => $factory->create('App\Lugar')->lug_id,
    ];
});

$factory->define(App\Torneo::class, function ($faker) use ($factory){
    return [
        'tor_nombre' => $faker->company,
        'tor_anio_referencia' => $faker->year($max = 'now'),
        'tor_fecha_inicio' => $faker->date($format = 'Y-m-d', $max = 'now'),
        'tor_fecha_fin' => $faker->date($format = 'Y-m-d', $max = 'now'),
        'tor_tipo_equipos' => $faker->randomElement($array = ['seleccion', 'profesional', 'amateur']),
        'tor_numero_equipos' => $faker->randomElement($array = [2,4,8,12,24,32]),
        'lug_id' => $factory->create('App\Lugar')->lug_id,
        'ttr_id'=> $factory->create('App\TipoTorneo')->ttr_id
    ];
});

$factory->define(App\Estadio::class, function ($faker) use ($factory){
    return [
        'est_nombre' => $faker->company,
        'est_fecha_inauguracion' => $faker->date($format = 'Y-m-d', $max = 'now'),
        'est_foto_por_defecto' => $faker->imageUrl($width = 200, $height = 200),
        'est_aforo' => $faker->numberBetween($min = 5000, $max = 80000),
        'lug_id' => $factory->create('App\Lugar')->lug_id,
    ];
});

$factory->define(App\PlantillaTorneo::class, function ($faker) use ($factory){
    return [
        'plt_numero_camiseta' => $faker->numberBetween(1, 50),
        'eqp_id' => $factory->create('App\Equipo')->eqp_id,
        'jug_id' => $factory->create('App\Jugador')->jug_id,
        'tor_id' => $factory->create('App\Torneo')->tor_id,
    ];
});

$factory->define(App\TipoFase::class, function ($faker) {
    return [
        'tfa_nombre' => $faker->company,
        'tfa_descripcion' => $faker->sentence(6),
    ];
});

$factory->define(App\EquipoParticipante::class, function ($faker) use ($factory){
    return [
        'eqp_id' => $factory->create('App\Equipo')->eqp_id,
        'tor_id' => $factory->create('App\Torneo')->tor_id,
    ];
});

$factory->define(App\Fase::class, function ($faker) use ($factory){
    return [
        'tfa_id' => $factory->create('App\TipoFase')->tfa_id,
        'fas_descripcion'=> $faker->sentence(10),
        'tor_id'=> $factory->create('App\Torneo')->tor_id,
        'fas_acumulada'=> $faker->numberBetween(0, 1),
    ];
});

$factory->define(App\PenalizacionTorneo::class, function ($faker) use ($factory){
    return [
        'fas_id' => $factory->create('App\Fase')->fas_id,
        'eqp_id' => $factory->create('App\Equipo')->eqp_id,
        'ptr_puntos' => $faker->numberBetween(1, 6),
        'ptr_motivo' => $faker->sentence(6),
    ];
});

$factory->define(App\Cliente::class, function ($faker) {
    return [
        'clt_nombre' => $faker->company,
        'clt_descripcion' => $faker->catchPhrase,
        'clt_dominio' => $faker->url
    ];
});

$factory->define(App\Fecha::class, function ($faker) use ($factory){
    return [
        'fas_id' => $factory->create('App\Fase')->fas_id,
        'fec_numero' => $faker->numberBetween(160, 200),
        'fec_estado' => $faker->randomElement(['jugada', 'no_jugada', 'en_juego', 'suspendida'])
    ];
});

$factory->define(App\Partido::class, function ($faker) use ($factory){
    return [
        'fec_id' => $factory->create('App\Fecha')->fec_id,
        'par_eqp_local' => $factory->create('App\Equipo')->eqp_id,
        'par_eqp_visitante' => $factory->create('App\Equipo')->eqp_id,
        'est_id' => $factory->create('App\Estadio')->est_id,
        'par_fecha' => $faker->date($format = 'Y-m-d', $max = 'now'),
        'par_hora' => null,
        'par_cronica' => $faker->url,
        'par_goles_local' => $faker->numberBetween(0, 4),
        'par_goles_visitante' => $faker->numberBetween(0, 4),
    ];
});

$factory->define(App\PartidoJugador::class, function ($faker) use ($factory){
    return [
        'par_id'  => $factory->create('App\Partido')->par_id,
        'jug_id' => $factory->create('App\Jugador')->jug_id,
        'pju_minuto_ingreso' => 0,
        'pju_reemplazo_de' => null,
        'pju_amarilla' => $faker->boolean(50),
        'pju_doble_amarilla' => $faker->boolean(50),
        'pju_roja' => $faker->boolean(50),
        'pju_numero_camiseta' => $faker->numberBetween(1, 30),
        'pju_juvenil' => $faker->boolean(50),
    ];
});

$factory->define(App\Producto::class, function ($faker) use ($factory){
    return [
        'prd_nombre' => $faker->company,
        'prd_descripcion' => $faker->catchPhrase,
    ];
});


$factory->define(App\PenalizacionTorneo::class, function ($faker) use ($factory){
    return [
        'fas_id' => $factory->create('App\Fase')->fas_id,
        'eqp_id' => $factory->create('App\Equipo')->eqp_id,
        'ptr_puntos' => $faker->numberBetween(1, 6),
        'ptr_motivo' => $faker->sentence(6),
    ];
});
