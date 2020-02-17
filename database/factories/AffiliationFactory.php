<?php

use Faker\Generator as Faker;
use App\Affiliation;

$factory->define(Affiliation::class, function (Faker $faker) {
    return [
        'name'  =>  'Vijay'
    ];
});
