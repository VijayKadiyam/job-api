<?php

use Faker\Generator as Faker;
use App\Practice;

$factory->define(Practice::class, function (Faker $faker) {
    return [
        'name'  =>  'Vijay'
    ];
});
