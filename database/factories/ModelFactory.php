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