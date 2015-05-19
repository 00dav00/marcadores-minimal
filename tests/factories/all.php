<?php

$factory('App\Jugador', [
	'jug_apellido' => $faker->lastname,
	'jug_nombre' => $faker->firstNameMale,
	'jug_apodo' => $faker->userName,
	'jug_fecha_nacimiento' => $faker->date($format = 'Y-m-d', $max = 'now'),
	'jug_altura' => $faker->numberBetween($min = 160, $max = 200),
	'jug_sitioweb' => $faker->url,
	'jug_twitter' => $faker->userName,
	'jug_foto' => $faker->imageUrl($width = 320, $height = 280),
	'lug_id' => $faker->numberBetween($min = 5, $max = 240),

	]);

$factory('App\Equipo', [
	'eqp_nombre' => $faker->streetName,
	'eqp_escudo' => $faker->imageUrl($width = 320, $height = 280),
	'eqp_twitter' => $faker->userName,
	'eqp_facebook' => $faker->url,
	'eqp_fecha_fundacion' => $faker->date($format = 'Y-m-d', $max = 'now'),
	'eqp_sitioweb' => $faker->url,
	'eqp_tipo' => $faker->randomElement($array = ['seleccion', 'profesional', 'amateur']),
	'lug_id' => $faker->numberBetween($min = 5, $max = 240)

	]);

$factory('App\Torneo', [
	'tor_nombre' => $faker->company,
	'tor_anio_referencia' => $faker->year($max = 'now'),
	'tor_fecha_inicio' => $faker->date($format = 'Y-m-d', $max = 'now'),
	'tor_fecha_fin' => $faker->date($format = 'Y-m-d', $max = 'now'),
	'tor_tipo_equipos' => $faker->randomElement($array = ['seleccion', 'profesional', 'amateur']),
	'tor_numero_equipos' => $faker->randomElement($array = [2,4,8,12,24,32]),
	'lug_id' => $faker->numberBetween($min = 5, $max = 240),
	'ttr_id'=> $faker->numberBetween($min = 1, $max = 6)

	]);

$factory('App\Estadio', [
	'est_nombre' => $faker->company,
	'est_fecha_inauguracion' => $faker->date($format = 'Y-m-d', $max = 'now'),
	'est_foto_por_defecto' => $faker->imageUrl($width = 320, $height = 280),
	'est_aforo' => $faker->numberBetween($min = 5000, $max = 80000),
	'lug_id' => $faker->numberBetween($min = 5, $max = 240)

	]);