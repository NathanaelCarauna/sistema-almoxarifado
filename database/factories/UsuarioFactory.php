<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Usuario;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\Hash;

$factory->define(Usuario::class, function (Faker $faker) {
    return [
        'nome' => $faker->name,
        'cpf' => rand(10000000000, 99999999999),
        'numTel' => rand(10000000000, 99999999999),
        'rg' => rand(100000000, 999999999),
        'data_nascimento' => '1998-06-18',
        'matricula' => rand(100000, 999999),
        'cargo_id' => 1,
        'email' => $faker->email,
        'senha' => Hash::make('password'),
        'setor' => 'Administrativo',
        'email_verified_at' => '2021-01-29 00:00:00',
    ];
});
