<?php

use Faker\Generator as Faker;
use App\OfficeTiming;

$factory->define(OfficeTiming::class, function (Faker $faker) {
    return [
		'from'        =>  'from',
		'from_am_pm'  =>  'from am pm',
		'to'          =>  'to',
		'to_am_pm'    =>  'to am pm'
    ];
});
