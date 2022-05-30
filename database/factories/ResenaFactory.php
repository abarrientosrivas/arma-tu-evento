<?php

use Faker\Generator as Faker;
// use App\Post;
// use App\Resena;

$factory->define(App\Resena::class, function (Faker $faker) {
    return [
        'titulo' => $faker->text(50),
        'cuerpo' => $faker->text(200),
        'calificacion' => $faker->numberBetween($min = 1, $max = 10),
        // 'post_id' => function() {
        //   return factory(App\Post::class)->make()->id;
        // }
    ];
});
