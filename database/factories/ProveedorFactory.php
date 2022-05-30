<?php

use App\Resena;
use App\Proveedor;
use App\Post;
use App\Rubro;
use App\TipoPago;
use App\Denuncia;
use App\Cliente;
use App\Evento;
use App\Conversation;
use App\Certificado;
use App\Notificacion;
use App\Message;
use Faker\Generator as Faker;

$factory->define(Proveedor::class, function (Faker $faker) {
    return [
        'nombre' => $faker->company,
        'rubro_id' => Rubro::all()->random()->id,
        // 'tipo_susc_id' => TipoPago::all()->random()->id,
        'tipo_susc_id' => $faker->numberBetween($min = 3, $max = 5),
        'cuit' => $faker->phoneNumber,
        'email' => $faker->unique()->safeEmail,
        'descripcion' => $faker->optional()->realText($maxNbChars = 100, $indexSize = 2),
        'password' => Hash::make('garrafas'),
    ];
});

$factory->define(Cliente::class, function (Faker $faker) {
    return [
        'nombre' => $faker->firstName,
        'apellido' => $faker->lastName,
        'bio' => $faker->optional()->realText($maxNbChars = 100, $indexSize = 2),
        'email' => $faker->unique()->safeEmail,
        'password' => Hash::make('estufas'),
    ];
});

$factory->define(Notificacion::class, function (Faker $faker) {
    if(rand(0,1)){
        return [
            'proveedor_id' => Proveedor::all()->random()->id,
            'title' => $faker->title,
            'body' => $faker->realText($maxNbChars = 50),
            'reference' => 'clientesList',
        ];
    } else{
        return [
            'cliente_id' => Cliente::all()->random()->id,
            'title' => $faker->title,
            'body' => $faker->realText($maxNbChars = 50),
            'reference' => 'clientesList',
        ];
    }
});

$factory->define(Certificado::class, function (Faker $faker) {
    return [
        // 'rubro_id' => Rubro::all()->random()->id,
        'titulo' => $faker->unique()->catchPhrase,
        'descripcion' => $faker->optional()->realText($maxNbChars = 100, $indexSize = 2),
        'obligatorio' => $faker->boolean,
        // 'fecha' => $faker->dateTimeBetween($startDate = '+3 days', $endDate = '+3 months', $timezone = null),
    ];
});

$factory->define(Denuncia::class, function(Faker $faker){
    return [        
        'titulo' => $faker->unique()->catchPhrase,
        'descripcion' => $faker->realText($maxNbChars = 100, $indexSize = 2),
    ];
});

$factory->define(Post::class, function (Faker $faker) {
    $bool = false;
    if (rand(0,10) == 1) { $bool = true; }
    return [
        'rubro_id' => Rubro::all()->random()->id,
        'titulo' => $faker->unique()->catchPhrase,
        'cuerpo' => $faker->realText($maxNbChars = 200, $indexSize = 5),
        'maxPersonas' => $faker->optional()->numberBetween($min = 1, $max = 10) * 100,
        'simultaneo' => $bool
    ];
});

$factory->define(Evento::class, function (Faker $faker) {
    return [
        'fecha' => $faker->dateTimeBetween($startDate = '+3 days', $endDate = '+3 months', $timezone = null),
        'cantPersonas' => $faker->numberBetween($min = 1, $max = 10) * 100,
    ];
});

$factory->define(Message::class, function (Faker $faker) {
    return [
        'message' => $faker->text($maxNbChars = 200),
    ];
});
