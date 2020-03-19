<?php

use Faker\Generator as Faker;
use App\Qualification;

$factory->define(Qualification::class, function (Faker $faker) {
    return [
        'name'  =>  'Vijay'
    ];
});
