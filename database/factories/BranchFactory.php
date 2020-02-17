<?php

use Faker\Generator as Faker;
use App\Branch;

$factory->define(Branch::class, function (Faker $faker) {
    return [
        'name'  =>  'Vijay'
    ];
});
