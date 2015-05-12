<?php

$factory('App\Jugador', [
	'jug_apellido' => $faker->lastname,
	'jug_nombre' => $faker->firstNameMale,
	'jug_apodo' => $faker->userName,
	'jug_fecha_nacimiento' => $faker->date($format = 'Y-m-d', $max = 'now'),
	'jug_altura' => $faker->randomDigit,
	'jug_sitioweb' => $faker->url,
	'jug_twitter' => '',
	'jug_foto' => $faker->imageUrl($width = 320, $height = 280),
	'lug_id' => 3,

	]);