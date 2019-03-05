<?php

use Faker\Generator as Faker;
use App\UserSale;

$factory->define(UserSale::class, function (Faker $faker) {
  return [
    'date'        =>  '01-01-2019',
    'amount'      =>  '20'
  ];
});
