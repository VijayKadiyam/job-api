<?php

use Faker\Generator as Faker;
use App\LeavePolicy;

$factory->define(LeavePolicy::class, function (Faker $faker) {
    return [
        'exam'                   =>  'exam',
		'ipcc_group_1'           =>  'ipcc group1',
		'ipcc_group_2'           =>  'ipcc group2',
		'ca_final_group_1'       =>  'ca final group1',
		'ca_final_group_2'       =>  'ca final group2',
		'ipcc_both_groups'       =>  'ipcc both groups',
		'ca_final_both_groups'   =>  'ca final both groups',
    ];
});
