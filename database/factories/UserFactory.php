<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\User::class, function (Faker $faker) {
    return [
        'name'                     => $faker->name,
        'email'                    => $faker->unique()->safeEmail,
        'email_verified_at'        => now(),
        'password'                 => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
        'remember_token'           => str_random(10),
        'active'                   =>  1,
        'phone'                    =>  $faker->phoneNumber,
        'address'                  =>  'address',
        'organigation_name'        =>  'organigation_name',
        'organigation_address'     =>  'organigation_address',
        'gstn'                     =>  'gstn',
        'year_of_establishment'    =>  'year_of_establishment',
        'no_of_partners'           =>  'no_of_partners',
        'total_no_of_people'       =>  'address',
        'description'              =>  'description',
        'transfer_policy'          =>  'transfer_policy',
        'training_policy'          =>  'training_policy',
        'leave_compensation'       =>  'leave_compensation',

        'dob'                      =>  'dob',
        'gender'                   =>  'gender',
        'marital_status'           =>  'marital_status',
        '10_passing_marks'         =>  '10_passing_marks',
        '10_total_marks'           =>  '10_total_marks',
        '12_passing_marks'         =>  '12_passing_marks',
        '12_total_marks'           =>  '12_total_marks',
        'cpt_passing_year'         =>  'cpt_passing_year',
        'cpt_marks'                =>  'cpt_marks',
        'cpt_attempts'             =>  'cpt_attempts',
        'ipcc_group_1_passing_year'=>  'ipcc_group_1_passing_year',




        'ipcc_group_1_marks'        =>  'ipcc_group_1_marks',
        'ipcc_group_1_attempts'     =>  'ipcc_group_1_attempts',
        'ipcc_group_2_passing_marks'=>  'ipcc_group_2_passing_marks',
        'ipcc_group_2_attempts'     =>  'ipcc_group_2_attempts',
        'entry_scheme'              =>  'entry_scheme',
        'icitss_passed'             =>  'icitss_passed',
        'icitss_passing_marks'      =>  'icitss_passing_marks',
        'icitss_total_marks'        =>  'icitss_total_marks',
        'other_training_details'    =>  'other_training_details',
        'outstation_travel'         =>  'outstation_travel',

      ];
});
