<?php

use Faker\Generator as Faker;
use App\UserSale;

$factory->define(UserSale::class, function (Faker $faker) {
  return [
    'date'        =>  '01-01-2019',
    'amount'      =>  '20',
    'customer_name' =>  'Vijay',
    'phone_no'      =>  '978787778787'
  ];
});
