<?php

use Faker\Generator as Faker;
use App\UserAttendance;

$factory->define(UserAttendance::class, function (Faker $faker) {
  return [
    'date'        =>  '2019-02-01',
    'login_time'  =>  '10.15',
    'logout_time' =>  '6.20',
    'login_lat'   =>  '23.34',
    'login_lng'   =>  '23.34',
    'logout_lat'  =>  '34.34',
    'logout_lng'  =>  '34.34'
  ];
});
