<?php

use Faker\Generator as Faker;
use App\Day;

$factory->define(Day::class, function (Faker $faker) {
    return [
        'name'  =>  'Vijay'
    ];
});
