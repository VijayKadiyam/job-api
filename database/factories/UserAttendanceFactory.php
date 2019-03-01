<?php

use Faker\Generator as Faker;
use App\UserAttendance;

$factory->define(UserAttendance::class, function (Faker $faker) {
  return [
    'date'        =>  '01-01-2019',
    'login_time'  =>  '10.15',
    'logout_time' =>  '6.20',
    'login_lat'   =>  '23.34',
    'login_lng'   =>  '23.34',
    'logout_lat'  =>  '34.34',
    'logout_lng'  =>  '34.34'
  ];
});
